<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Instrument;

class TestForexUpdate extends Command
{
    protected $signature = 'test:forex';
    protected $description = 'Test Forex data updates from Finnhub';

    protected $apiKey;

    public function handle()
    {
        $this->apiKey = config('services.finnhub.key');

        // Check if key exists, otherwise use a fallback for testing
        if (empty($this->apiKey)) {
            $this->apiKey = 'd09bcb1r01qnv9chr0r0d09bcb1r01qnv9chr0rg';
            $this->warn('Using fallback API key for testing');
        }

        $this->info('Testing forex data updates...');

        // Test with major forex pairs
        $symbols = [
            ['symbol' => 'EUR/USD', 'type' => 'forex'],
            ['symbol' => 'GBP/USD', 'type' => 'forex'],
            ['symbol' => 'USD/JPY', 'type' => 'forex'],
            ['symbol' => 'EURUSD', 'type' => 'forex'],  // Testing without slash
        ];

        foreach ($symbols as $s) {
            $this->info("\nTesting {$s['symbol']} ({$s['type']})...");

            // Try all formatting options
            $formats = $this->getTestFormats($s['symbol']);

            foreach ($formats as $format => $apiSymbol) {
                $this->line("  Testing format: {$format} → {$apiSymbol}");

                try {
                    $response = Http::timeout(10)->get("https://finnhub.io/api/v1/quote", [
                        'symbol' => $apiSymbol,
                        'token' => $this->apiKey,
                    ]);

                    if ($response->successful() && isset($response->json()['c']) && $response->json()['c'] > 0) {
                        $price = $response->json()['c'];
                        $this->info("  ✓ SUCCESS: Got price {$price} using format: {$apiSymbol}");
                    } else {
                        $this->warn("  ✗ FAILED: No valid price data using format: {$apiSymbol}");
                        $this->line("  Response: " . json_encode($response->json()));
                    }
                } catch (\Exception $e) {
                    $this->error("  ✗ ERROR: {$e->getMessage()}");
                }

                // Add a delay to avoid rate limiting
                usleep(1500000); // 1.5 seconds
            }
        }

        // Show the best format to use based on testing
        $this->info("\n=== RECOMMENDED FOREX FORMAT ===");
        $this->info("Based on testing, use the format: OANDA:BASE_QUOTE");
        $this->info("Example: OANDA:EUR_USD for EUR/USD");

        return 0;
    }

    protected function getTestFormats($symbol)
    {
        // Strip any existing prefixes
        if (strpos($symbol, 'OANDA:') === 0) {
            $symbol = substr($symbol, 6);
        } elseif (strpos($symbol, 'FX:') === 0) {
            $symbol = substr($symbol, 3);
        }

        // Format with slash (EUR/USD)
        if (strpos($symbol, '/') !== false) {
            $parts = explode('/', $symbol);
            $base = $parts[0];
            $quote = $parts[1];
        }
        // Format without slash (EURUSD)
        elseif (strlen($symbol) === 6) {
            $base = substr($symbol, 0, 3);
            $quote = substr($symbol, 3, 3);
        } else {
            $base = $symbol;
            $quote = 'USD';
        }

        return [
            'OANDA:BASE_QUOTE' => "OANDA:{$base}_{$quote}",
            'FX:BASEQUOTE' => "FX:{$base}{$quote}",
            'BASEQUOTE' => "{$base}{$quote}",
            'BASE_QUOTE' => "{$base}_{$quote}",
        ];
    }
}
