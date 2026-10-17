<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Instrument;
use Exception;

class UpdateMarketInstruments extends Command
{
    protected $signature = 'update:market {--chunk=10 : Number of symbols to process in one batch} {--forex-only : Process only forex symbols}';
    protected $description = 'Update Stocks, Forex, and Indices from Finnhub';

    protected $apiKey;
    protected $delay = 1.2; // Delay in seconds between API calls (to stay under 60 calls/min)

    public function handle()
    {
        // Track execution time
        $startTime = microtime(true);

        // Check for API key
        $this->apiKey = config('services.finnhub.key');
        if (empty($this->apiKey)) {
            $this->error('Finnhub API key not configured! Check your .env file.');
            return 1;
        }

        // Get symbols and chunk size option
        $symbols = $this->getSymbols();
        $chunkSize = max(1, (int) $this->option('chunk'));

        // Filter for forex-only if option is set
        if ($this->option('forex-only')) {
            $symbols = array_filter($symbols, function($symbol) {
                return $symbol['type'] === 'forex';
            });
            $this->info('Forex-only mode enabled. Will process ' . count($symbols) . ' forex symbols.');
        }

        // Set up counters and stats
        $total = count($symbols);
        $successCount = 0;
        $errorCount = 0;
        $rateLimitHits = 0;

        $this->info('Starting market data update for ' . $total . ' instruments...');
        $this->line('Using chunk size: ' . $chunkSize . ' (Adjust with --chunk=X if needed)');

        // Create progress bar
        $bar = $this->output->createProgressBar($total);
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %message%');
        $bar->setMessage('Starting...');

        // Process in chunks to handle rate limiting better
        foreach (array_chunk($symbols, $chunkSize) as $chunkIndex => $chunk) {
            $bar->setMessage("Processing chunk " . ($chunkIndex + 1) . " of " . ceil($total / $chunkSize));

            foreach ($chunk as $s) {
                try {
                    $symbolType = $s['type'];
                    $bar->setMessage("Symbol: {$s['symbol']} ({$symbolType})");

                    // For forex symbols, show the API format as well
                    if ($symbolType === 'forex') {
                        $apiSymbol = $this->formatSymbolForApi($s['symbol'], $symbolType);
                        $bar->setMessage("Symbol: {$s['symbol']} -> $apiSymbol ({$symbolType})");
                    }

                    $this->processSymbol($s);
                    $successCount++;

                    // Add delay to avoid rate limiting
                    usleep($this->delay * 1000000);

                } catch (Exception $e) {
                    $errorCount++;
                    $message = $e->getMessage();

                    // Check if it was a rate limit error
                    if (stripos($message, 'rate limit') !== false || stripos($message, '429') !== false) {
                        $rateLimitHits++;

                        // Increase delay on rate limit hits
                        $this->delay = min(5, $this->delay * 1.5);
                        $this->warn("\nRate limit hit, increasing delay to {$this->delay}s");
                    } else {
                        $this->error("\nError processing {$s['symbol']}: " . $message);
                    }

                    Log::error("Failed to update {$s['symbol']}", [
                        'error' => $message,
                        'type' => $s['type']
                    ]);
                } finally {
                    $bar->advance();
                }
            }

            // Add extra delay between chunks to avoid rate limiting
            if ($chunkIndex < ceil($total / $chunkSize) - 1) {
                $bar->setMessage("Pausing between chunks...");
                sleep(2);
            }
        }

        $bar->finish();

        // Calculate statistics
        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);

        // Print summary
        $this->line("\n");
        $this->info("Market instruments update completed in {$executionTime}s");
        $this->line("✓ Successful updates: " . $successCount);

        if ($errorCount > 0) {
            $this->warn("✗ Failed updates: " . $errorCount);
        }

        if ($rateLimitHits > 0) {
            $this->warn("⚠ Rate limit hits: " . $rateLimitHits);
        }

        return 0;
    }

    protected function processSymbol($s)
    {
        // Format symbol based on type
        $apiSymbol = $this->formatSymbolForApi($s['symbol'], $s['type']);

        // Show more verbose debug information
        $this->line("\nFetching data for {$s['symbol']} ({$s['type']}) using API symbol: {$apiSymbol}");

        // Special handling for forex to make debugging easier
        if ($s['type'] === 'forex') {
            $this->info("FOREX: Converting {$s['symbol']} to {$apiSymbol} for Finnhub");

            // For verbose mode, show more details
            if ($this->getOutput()->isVerbose()) {
                $this->line("FOREX FORMAT DETAILS:");
                $this->line("- Original symbol: {$s['symbol']}");
                $this->line("- API format: {$apiSymbol}");
                $this->line("- Expected URL: https://finnhub.io/api/v1/quote?symbol=" . urlencode($apiSymbol));
            }
        }

        Log::debug("API request", [
            'endpoint' => 'https://finnhub.io/api/v1/quote',
            'original_symbol' => $s['symbol'],
            'api_symbol' => $apiSymbol,
            'type' => $s['type']
        ]);

        // Get quote data - this works for most instrument types
        $response = Http::timeout(10)->get("https://finnhub.io/api/v1/quote", [
            'symbol' => $apiSymbol,
            'token' => $this->apiKey,
        ]);

        // Handle various API response codes
        if (!$response->successful()) {
            $statusCode = $response->status();

            // Handle rate limiting (HTTP 429)
            if ($statusCode === 429) {
                $this->warn("\nAPI rate limit reached for {$s['symbol']}. Pausing for 60 seconds...");
                Log::warning("Finnhub API rate limit reached", [
                    'symbol' => $s['symbol'],
                    'type' => $s['type']
                ]);

                // Sleep for 60 seconds to respect rate limits
                sleep(60);

                // Try the request again
                $this->line("\nRetrying request for {$s['symbol']}...");
                $response = Http::timeout(10)->get("https://finnhub.io/api/v1/quote", [
                    'symbol' => $apiSymbol,
                    'token' => $this->apiKey,
                ]);
            }
            // Handle invalid API key (HTTP 401)
            else if ($statusCode === 401) {
                $this->error("\nInvalid API key or unauthorized request");
                throw new Exception("API Error: Unauthorized - Check your API key");
            }
            // Handle not found (HTTP 404)
            else if ($statusCode === 404) {
                $this->warn("\nAPI returned 404 for {$apiSymbol} - Symbol may not be supported");

                // Try alternate formats for some asset types
                if ($s['type'] === 'index') {
                    $alternateSymbol = str_replace(['I:', '^'], '', $apiSymbol);
                    $this->line("Trying alternate format for index: {$alternateSymbol}");

                    $response = Http::timeout(10)->get("https://finnhub.io/api/v1/quote", [
                        'symbol' => $alternateSymbol,
                        'token' => $this->apiKey,
                    ]);
                }
            }
        }

        if ($response->failed()) {
            $errorData = [
                'status' => $response->status(),
                'body' => $response->body(),
                'original_symbol' => $s['symbol'],
                'api_symbol' => $apiSymbol,
                'type' => $s['type']
            ];
            Log::error("Finnhub API error", $errorData);

            // Check for existing instrument data to use as fallback
            $existing = Instrument::where('symbol', $s['symbol'])->first();
            if ($existing && $existing->price > 0) {
                $this->warn("\nUsing existing data for {$s['symbol']} due to API error");
                $existing->updated_at = now();
                $existing->save();
                return;
            }

            throw new Exception("API error: " . $response->status() . ' - ' . $response->body());
        }

        $quote = $response->json();

        if (empty($quote) || !isset($quote['c'])) {
            $this->error("Empty or invalid quote data for {$s['symbol']} using API symbol {$apiSymbol}");
            $this->line("Response: " . json_encode($quote));

            Log::error("Empty or invalid quote data", [
                'symbol' => $s['symbol'],
                'api_symbol' => $apiSymbol,
                'type' => $s['type'],
                'response' => $quote
            ]);

            // Check if there's existing data
            $existing = Instrument::where('symbol', $s['symbol'])->first();
            if ($existing) {
                $this->warn("Using existing data for {$s['symbol']} from " . $existing->updated_at);
                $existing->updated_at = now();
                $existing->save();
                return;
            }

            throw new Exception("Invalid price data received: empty or missing price");
        }

        if ($quote['c'] == 0 && $s['type'] != 'index') {
            // Zero price might be valid for some indices but typically not for stocks/forex
            Log::warning("Zero price received", [
                'symbol' => $s['symbol'],
                'api_symbol' => $apiSymbol,
                'type' => $s['type'],
                'data' => $quote
            ]);
        }

        $price = $quote['c'] ?? 0;
        $previousClose = $quote['pc'] ?? 0;

        // If we have a zero price but previous close is valid, use that instead
        if ($price == 0 && $previousClose > 0) {
            $price = $previousClose;
            Log::info("Using previous close as current price for {$s['symbol']}", [
                'previous_close' => $previousClose
            ]);
        }

        $data = [
            'type' => $s['type'],
            'name' => $s['symbol'],
            'open' => $quote['o'] ?? $price,
            'high' => $quote['h'] ?? $price,
            'low' => $quote['l'] ?? $price,
            'close' => $previousClose,
            'price' => $price,
            'change' => $previousClose > 0 ? ($price - $previousClose) : 0,
            'percent_change_24h' => $previousClose > 0 ?
                (($price - $previousClose) / $previousClose) * 100 : 0,
            'updated_at' => now(),
        ];

        // Only fetch profile data for stocks
        if ($s['type'] === 'stock') {
            usleep($this->delay * 1000000); // Add delay before making another API call

            $profile = Http::get("https://finnhub.io/api/v1/stock/profile2", [
                'symbol' => $apiSymbol,
                'token' => $this->apiKey,
            ])->json();

            $data['logo'] = $profile['logo'] ?? null;
            $data['market_cap'] = $profile['marketCapitalization'] ?? null;
            $data['name'] = $profile['name'] ?? $s['symbol'];

            // Get volume data if available
            usleep($this->delay * 1000000);

            $candle = Http::get("https://finnhub.io/api/v1/stock/candle", [
                'symbol' => $apiSymbol,
                'resolution' => 'D',
                'from' => now()->subDays(1)->timestamp,
                'to' => now()->timestamp,
                'token' => $this->apiKey,
            ])->json();

            if (isset($candle['v']) && !empty($candle['v'])) {
                $data['volume'] = end($candle['v']);
            }
        }

        // Update or create the instrument
        Instrument::updateOrCreate(
            ['symbol' => $s['symbol']],
            $data
        );
    }

    public function formatSymbolForApi($symbol, $type)
    {
        // Format symbol based on type for API compatibility
        switch ($type) {
            case 'forex':
                // For forex pairs, Finnhub typically expects the format OANDA:EUR_USD

                // Log input for debugging
                Log::debug("Formatting forex symbol: $symbol");
                $this->info("Formatting forex symbol: $symbol");

                // If already has OANDA prefix, leave as is
                if (strpos($symbol, 'OANDA:') === 0) {
                    return $symbol;
                }

                // Remove any existing prefixes (FX:, etc.)
                if (strpos($symbol, ':') !== false) {
                    $parts = explode(':', $symbol, 2);
                    $symbol = $parts[1];
                }

                // Format with slash (EUR/USD)
                if (strpos($symbol, '/') !== false) {
                    $parts = explode('/', $symbol);
                    if (count($parts) == 2) {
                        $formatted = 'OANDA:' . $parts[0] . '_' . $parts[1];
                        Log::debug("Converted $symbol to $formatted");
                        $this->info("Converted $symbol to $formatted");
                        return $formatted;
                    }
                }

                // Format without slash but with underscore (EUR_USD)
                if (strpos($symbol, '_') !== false) {
                    return 'OANDA:' . $symbol;
                }

                // Format without slash (EURUSD) - 6 characters for standard pairs
                if (preg_match('/^[A-Z]{6}$/', $symbol)) {
                    $base = substr($symbol, 0, 3);
                    $quote = substr($symbol, 3, 3);
                    $formatted = 'OANDA:' . $base . '_' . $quote;
                    Log::debug("Converted $symbol to $formatted");
                    $this->info("Converted $symbol to $formatted");
                    return $formatted;
                }

                // Default format for other forex symbols
                $formatted = 'OANDA:' . $symbol;
                Log::debug("Using default format: $formatted");
                $this->info("Using default format: $formatted");
                return $formatted;

            case 'index':
                // First check if the symbol is directly in our map (with or without ^)
                $indexMap = [
                    'GSPC' => 'SPX', // S&P 500
                    '^GSPC' => 'SPX', // S&P 500 with caret
                    'SPX' => 'SPX',  // S&P 500 (already formatted)
                    'DJI' => 'DJI',  // Dow Jones Industrial Average
                    '^DJI' => 'DJI', // Dow Jones with caret
                    'IXIC' => 'NDX', // NASDAQ Composite -> NASDAQ-100 Index
                    '^IXIC' => 'NDX', // NASDAQ Composite with caret
                    'NDX' => 'NDX',  // NASDAQ-100 Index
                    'FTSE' => 'FTSE:FTSE', // FTSE 100
                    '^FTSE' => 'FTSE:FTSE', // FTSE 100 with caret
                    'GDAXI' => 'XETR:DAX', // German DAX
                    '^GDAXI' => 'XETR:DAX', // German DAX with caret
                    'FCHI' => 'EURONEXT:PX1', // CAC 40
                    '^FCHI' => 'EURONEXT:PX1' // CAC 40 with caret
                ];

                // Direct match in our mapping table
                if (isset($indexMap[$symbol])) {
                    $this->line("Using specific index mapping for {$symbol}: {$indexMap[$symbol]}");
                    return $indexMap[$symbol];
                }

                // For S&P 500 special case - check multiple formats
                if ($symbol === '^GSPC' || $symbol === 'GSPC') {
                    $this->line("Special handling for S&P 500");
                    return 'SPX';
                }

                // Remove the ^ prefix if present
                $cleanSymbol = (strpos($symbol, '^') === 0) ? substr($symbol, 1) : $symbol;

                // Try using symbol directly (works for many US indices)
                $this->line("Using clean index symbol: {$cleanSymbol}");
                return $cleanSymbol;

            case 'crypto':
                // Format cryptocurrencies for Finnhub
                // Finnhub expects BINANCE:BTCUSDT or COINBASE:BTC-USD format
                if (strpos($symbol, '/') !== false) {
                    // Convert BTC/USD to BTC-USD format
                    $parts = explode('/', $symbol);
                    if (count($parts) == 2) {
                        return 'COINBASE:' . $parts[0] . '-' . $parts[1];
                    }
                }

                // If already in format like BTCUSDT or ETHUSDT
                if (preg_match('/^([A-Z]+)(USDT|BTC|ETH|USD)$/', $symbol, $matches)) {
                    return 'BINANCE:' . $symbol;
                }

                // Default to BINANCE with original symbol
                return 'BINANCE:' . $symbol;

            case 'commodity':
                // Commodity mapping for better API compatibility
                $commodityMap = [
                    'XAUUSD' => 'OANDA:XAU_USD', // Gold
                    'XAGUSD' => 'OANDA:XAG_USD', // Silver
                    'XBRUSD' => 'OANDA:BCO_USD', // Brent Crude Oil
                    'XTIUSD' => 'OANDA:WTI_USD', // WTI Crude Oil
                ];

                if (isset($commodityMap[$symbol])) {
                    return $commodityMap[$symbol];
                }

                // Default commodity format
                return $symbol;

            default:
                return $symbol; // Stocks and others stay as is
        }
    }

    protected function getSymbols()
    {
        // Try to fetch symbols from database first
        try {
            $dbSymbols = Instrument::select('symbol', 'type')->get();
            if ($dbSymbols->isNotEmpty()) {
                $this->info("Using " . $dbSymbols->count() . " instruments from database");
                return $dbSymbols->toArray();
            }
        } catch (Exception $e) {
            $this->warn("Couldn't fetch symbols from database: " . $e->getMessage());
        }

        // Default symbols array if database is empty
        $this->info("Using default instruments list");
        return [
            // Major US Stocks
            ['symbol' => 'AAPL', 'type' => 'stock'],
            ['symbol' => 'MSFT', 'type' => 'stock'],
            ['symbol' => 'AMZN', 'type' => 'stock'],
            ['symbol' => 'GOOGL', 'type' => 'stock'],
            ['symbol' => 'TSLA', 'type' => 'stock'],
            ['symbol' => 'META', 'type' => 'stock'],
            ['symbol' => 'NVDA', 'type' => 'stock'],

            // Major Indices
            ['symbol' => '^GSPC', 'type' => 'index'], // S&P 500
            ['symbol' => '^DJI', 'type' => 'index'],  // Dow Jones
            ['symbol' => '^IXIC', 'type' => 'index'], // NASDAQ
            ['symbol' => '^FTSE', 'type' => 'index'], // FTSE 100
            ['symbol' => '^GDAXI', 'type' => 'index'], // German DAX

            // Major Forex Pairs
            ['symbol' => 'EUR/USD', 'type' => 'forex'],
            ['symbol' => 'GBP/USD', 'type' => 'forex'],
            ['symbol' => 'USD/JPY', 'type' => 'forex'],
            ['symbol' => 'USD/CHF', 'type' => 'forex'],

            // Commodities
            ['symbol' => 'XAUUSD', 'type' => 'commodity'], // Gold
            ['symbol' => 'XAGUSD', 'type' => 'commodity'], // Silver
            ['symbol' => 'XBRUSD', 'type' => 'commodity'], // Brent Crude Oil
        ];
    }
}
