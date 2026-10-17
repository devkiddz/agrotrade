<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Instrument;

class TestForexSymbols extends Command
{
    protected $signature = 'test:forex-symbols';
    protected $description = 'Test Forex symbols specifically';

    protected $apiKey;

    public function handle()
    {
        $this->apiKey = config('services.finnhub.key');

        if (empty($this->apiKey)) {
            $this->apiKey = 'd09bcb1r01qnv9chr0r0d09bcb1r01qnv9chr0rg';
            $this->warn('Using fallback API key for testing');
        }

        $this->info('Testing forex symbols...');

        // Create an instance of the market update command to use its formatter
        $marketCommand = new UpdateMarketInstruments();

        // Get forex symbols
        $forexSymbols = [
            ['symbol' => 'EUR/USD', 'type' => 'forex'],
            ['symbol' => 'GBP/USD', 'type' => 'forex'],
            ['symbol' => 'USD/JPY', 'type' => 'forex']
        ];

        // Test each symbol
        foreach ($forexSymbols as $s) {
            // Format symbol for API
            $apiSymbol = $marketCommand->formatSymbolForApi($s['symbol'], $s['type']);

            $this->info("\nTesting {$s['symbol']} → {$apiSymbol}");

            try {
                $this->info("Making API request to Finnhub...");
                $url = "https://finnhub.io/api/v1/quote?symbol=" . urlencode($apiSymbol) . "&token=" . $this->apiKey;
                $this->line("URL: " . $url);

                $response = Http::timeout(15)->get($url);

                $this->line("Response status: " . $response->status());
                $this->line("Response body: " . $response->body());

                if ($response->successful() && isset($response->json()['c']) && $response->json()['c'] > 0) {
                    $this->info("SUCCESS: Got price " . $response->json()['c']);
                } else {
                    $this->warn("No valid price data received");
                }
            } catch (\Exception $e) {
                $this->error("Exception: " . $e->getMessage());
            }

            // Add delay to avoid rate limiting
            $this->line("Waiting 2 seconds to avoid rate limiting...");
            sleep(2);
        }

        return 0;
    }
}
