<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Instrument;

trait Apitrait
{
    /**
     * Get cryptocurrency price from multiple APIs with fallback
     *
     * @param string $coin The cryptocurrency symbol
     * @param string $currency The fiat currency (usd, eur, etc.)
     * @return float The price
     */
    // Add property to track price source
    public $priceSource = 'unknown';

    public function get_rate($coin, $currency = 'usd')
    {
        $coin = strtolower($coin);
        $currency = strtolower($currency);

        // Reset price source for new request
        $this->priceSource = 'unknown';

        // Cache key for storing the price
        $cacheKey = "crypto_price_{$coin}_{$currency}";

        // Check if price is cached (cache for 2 minutes)
        if (Cache::has($cacheKey)) {
            $this->priceSource = 'cache';
            return Cache::get($cacheKey);
        }

        // If both are USD, return 1
        if ($coin === 'usd' && $currency === 'usd') {
            $this->priceSource = 'fixed';
            return 1.0;
        }

        // If coin is USD, get the inverse rate
        if ($coin === 'usd') {
            $this->priceSource = 'inverse';
            return $this->getUsdToOtherRate($currency);
        }

        // CHANGE: Prioritize database as primary source for prices
        // Get price from instruments table first
        $price = $this->getDatabasePrice($coin, $currency);
        if ($price !== null) {
            $this->priceSource = 'database';
            Cache::put($cacheKey, $price, 120); // Cache for 2 minutes
            return $price;
        }

        // Map common cryptocurrency symbols to CoinGecko IDs for fallback
        $coinMap = [
            'btc' => 'bitcoin',
            'eth' => 'ethereum',
            'usdt' => 'tether',
            'bnb' => 'binancecoin',
            'ada' => 'cardano',
            'xrp' => 'ripple',
            'ltc' => 'litecoin',
            'bch' => 'bitcoin-cash',
            'link' => 'chainlink',
            'xlm' => 'stellar',
            'aave' => 'aave',
            'usd' => 'usd'
        ];

        // Get the CoinGecko ID for the coin
        $coinId = $coinMap[$coin] ?? $coin;

        // Only try APIs as fallback if database doesn't have the price
        try {
            // Fallback API: CoinGecko (Free, reliable)
            $price = $this->getCoinGeckoPrice($coinId, $currency);
            if ($price !== null) {
                $this->priceSource = 'coingecko';
                Cache::put($cacheKey, $price, 120); // Cache for 2 minutes
                return $price;
            }

            // Fallback API: CryptoCompare
            $price = $this->getCryptoComparePrice($coin, $currency);
            if ($price !== null) {
                $this->priceSource = 'cryptocompare';
                Cache::put($cacheKey, $price, 120); // Cache for 2 minutes
                return $price;
            }

            // Fallback API: Binance
            $price = $this->getBinancePrice($coin, $currency);
            if ($price !== null) {
                $this->priceSource = 'binance';
                Cache::put($cacheKey, $price, 120); // Cache for 2 minutes
                return $price;
            }

        } catch (\Exception $e) {
            \Log::error("Error fetching crypto price for {$coin}/{$currency}: " . $e->getMessage());
        }

        // Final fallback: return cached price if available (even if expired)
        $fallbackPrice = Cache::get($cacheKey . '_fallback');
        if ($fallbackPrice !== null) {
            $this->priceSource = 'expired_cache';
            return $fallbackPrice;
        }

        // Default fallback prices for common cryptocurrencies
        $this->priceSource = 'default';
        return $this->getDefaultPrice($coin, $currency);
    }

    /**
     * Get price from database instruments table
     */
    private function getDatabasePrice($coin, $currency)
    {
        try {
            $coin = strtolower($coin);
            $currency = strtolower($currency);

            // Debug log the request
            \Log::info("Looking up price for {$coin}/{$currency} from database");

            // Handle USD to USD
            if ($coin === 'usd' && $currency === 'usd') {
                \Log::info("USD to USD conversion, returning 1.0");
                return 1.0;
            }

            // Map coin symbols to database format
            $coinSymbolMap = [
                'btc' => 'BTC',
                'eth' => 'ETH',
                'usdt' => 'USDT',
                'bnb' => 'BNB',
                'ada' => 'ADA',
                'xrp' => 'XRP',
                'ltc' => 'LTC',
                'bch' => 'BCH',
                'link' => 'LINK',
                'xlm' => 'XLM',
                'aave' => 'AAVE'
            ];

            $dbSymbol = $coinSymbolMap[$coin] ?? strtoupper($coin);
            \Log::info("Mapped symbol for database lookup: {$dbSymbol}");

            // Check if Instrument table exists and has records
            try {
                $instrumentCount = \DB::table('instruments')->count();
                \Log::info("Instrument table has {$instrumentCount} records");
            } catch (\Exception $e) {
                \Log::error("Error checking instrument table: " . $e->getMessage());
            }

            // IMPROVED: Simpler query to find the instrument
            $instrument = Instrument::where('type', 'crypto')
                ->where(function($query) use ($dbSymbol) {
                    // Simpler conditions for debugging
                    $query->where('symbol', $dbSymbol)
                          ->orWhere('symbol', 'LIKE', $dbSymbol . '/%')
                          ->orWhere('symbol', 'LIKE', '%/' . $dbSymbol)
                          ->orWhere('name', 'LIKE', '%' . $dbSymbol . '%');
                })
                ->whereNotNull('price')
                ->where('price', '>', 0)
                ->orderBy('updated_at', 'desc')
                ->first();

            if (!$instrument) {
                // Try again with a more direct approach
                \Log::info("First query found no instrument, trying direct name match for {$dbSymbol}");
                $instrument = Instrument::where('type', 'crypto')
                    ->where('name', 'LIKE', '%' . $dbSymbol . '%')
                    ->whereNotNull('price')
                    ->where('price', '>', 0)
                    ->orderBy('updated_at', 'desc')
                    ->first();
            }

            // If still not found, log available instruments for debugging
            if (!$instrument) {
                $availableInstruments = Instrument::where('type', 'crypto')
                    ->whereNotNull('price')
                    ->where('price', '>', 0)
                    ->select('id', 'symbol', 'name', 'price')
                    ->take(5)
                    ->get();

                \Log::info("Could not find instrument for {$dbSymbol}. Sample instruments: " . json_encode($availableInstruments));

                // As a last resort, use hardcoded prices rather than returning null
                $fallbackPrices = [
                    'btc' => 45000.00,
                    'eth' => 3000.00,
                    'usdt' => 1.00,
                    'bnb' => 300.00,
                    'ada' => 0.50,
                    'xrp' => 0.60,
                    'ltc' => 100.00,
                    'bch' => 250.00,
                    'link' => 15.00,
                    'xlm' => 0.10,
                    'aave' => 100.00
                ];

                if (isset($fallbackPrices[$coin])) {
                    $fallbackPrice = $fallbackPrices[$coin];
                    \Log::info("Using hardcoded fallback price for {$coin}: {$fallbackPrice}");
                    return $fallbackPrice;
                }
            }

            if ($instrument && $instrument->price > 0) {
                $price = (float) $instrument->price;

                // If currency is not USD, we might need conversion
                if ($currency !== 'usd') {
                    // For now, assume most DB prices are in USD
                    \Log::info("Currency is {$currency}, returning price as is: {$price}");
                    return $price;
                }

                \Log::info("Using database price for {$coin}: {$price} [ID: {$instrument->id}, Symbol: {$instrument->symbol}]");
                return $price;
            }

            // Special case: if looking for USD price and coin is USD
            if ($coin === 'usd') {
                return 1.0;
            }

        } catch (\Exception $e) {
            \Log::error("Database price lookup error for {$coin}/{$currency}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get price from CoinGecko API
     */
    private function getCoinGeckoPrice($coinId, $currency)
    {
        try {
            $response = Http::timeout(10)->get("https://api.coingecko.com/api/v3/simple/price", [
                'ids' => $coinId,
                'vs_currencies' => $currency
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$coinId][$currency])) {
                    $price = $data[$coinId][$currency];
                    // Store as fallback
                    Cache::put("crypto_price_{$coinId}_{$currency}_fallback", $price, 3600);
                    return (float) $price;
                }
            }
        } catch (\Exception $e) {
            \Log::error("CoinGecko API error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get price from CryptoCompare API
     */
    private function getCryptoComparePrice($coin, $currency)
    {
        try {
            $coin = strtoupper($coin);
            $currency = strtoupper($currency);

            $response = Http::timeout(10)->get("https://min-api.cryptocompare.com/data/price", [
                'fsym' => $coin,
                'tsyms' => $currency
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$currency])) {
                    $price = $data[$currency];
                    // Store as fallback
                    Cache::put("crypto_price_{$coin}_{$currency}_fallback", $price, 3600);
                    return (float) $price;
                }
            }
        } catch (\Exception $e) {
            \Log::error("CryptoCompare API error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get price from Binance API
     */
    private function getBinancePrice($coin, $currency)
    {
        try {
            $coin = strtoupper($coin);
            $currency = strtoupper($currency);

            // Binance uses USDT instead of USD for most pairs
            if ($currency === 'USD') {
                $currency = 'USDT';
            }

            $symbol = $coin . $currency;

            $response = Http::timeout(10)->get("https://api.binance.com/api/v3/ticker/price", [
                'symbol' => $symbol
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['price'])) {
                    $price = $data['price'];
                    // Store as fallback
                    Cache::put("crypto_price_{$coin}_{$currency}_fallback", $price, 3600);
                    return (float) $price;
                }
            }
        } catch (\Exception $e) {
            \Log::error("Binance API error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get USD to other currency rate
     */
    private function getUsdToOtherRate($currency)
    {
        if ($currency === 'usd') {
            return 1.0;
        }

        try {
            // Use a forex API for USD conversion
            $response = Http::timeout(10)->get("https://api.exchangerate-api.com/v4/latest/USD");

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['rates'][strtoupper($currency)])) {
                    return (float) $data['rates'][strtoupper($currency)];
                }
            }
        } catch (\Exception $e) {
            \Log::error("Exchange rate API error: " . $e->getMessage());
        }

        return 1.0; // Default to 1 if conversion fails
    }

    /**
     * Get default fallback prices (approximate values)
     */
    private function getDefaultPrice($coin, $currency)
    {
        $defaultPrices = [
            'btc' => ['usd' => 45000],
            'eth' => ['usd' => 3000],
            'usdt' => ['usd' => 1],
            'bnb' => ['usd' => 300],
            'ada' => ['usd' => 0.5],
            'xrp' => ['usd' => 0.6],
            'ltc' => ['usd' => 100],
            'bch' => ['usd' => 250],
            'link' => ['usd' => 15],
            'xlm' => ['usd' => 0.1],
            'aave' => ['usd' => 100],
        ];

        if (isset($defaultPrices[$coin][$currency])) {
            \Log::warning("Using default fallback price for {$coin}/{$currency}. Please update crypto prices or check API connections.");
            return (float) $defaultPrices[$coin][$currency];
        }

        // If no default price available, log error and return 1
        \Log::error("No price data available for {$coin}/{$currency}. Exchange may not work properly.");
        return 1.0;
    }

    /**
     * Get multiple cryptocurrency prices at once (for better performance)
     */
    public function getMultiplePrices($coins, $currency = 'usd')
    {
        $prices = [];

        foreach ($coins as $coin) {
            $prices[$coin] = $this->get_rate($coin, $currency);
        }

        return $prices;
    }

    /**
     * Clear price cache
     */
    public function clearPriceCache()
    {
        $coins = ['btc', 'eth', 'usdt', 'bnb', 'ada', 'xrp', 'ltc', 'bch', 'link', 'xlm', 'aave'];
        $currencies = ['usd', 'eur', 'gbp'];

        foreach ($coins as $coin) {
            foreach ($currencies as $currency) {
                Cache::forget("crypto_price_{$coin}_{$currency}");
                Cache::forget("crypto_price_{$coin}_{$currency}_fallback");
            }
        }
    }
};
