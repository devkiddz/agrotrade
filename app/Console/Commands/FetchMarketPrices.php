<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Instrument;
use App\Models\MarketPrice;
use Carbon\Carbon;

class FetchMarketPrices extends Command
{
    protected $signature = 'market:prices';
    protected $description = 'Fetch and store historical market prices for all instruments';

    public function handle()
    {
        $now = now();
        $instruments = Instrument::all();

        foreach ($instruments as $instrument) {
            if ($instrument->type === 'crypto') {
                $this->updateCrypto($instrument);
            } else {
                $this->updateFromFinnhub($instrument);
            }
        }

        $this->info("Market prices updated at {$now->toDateTimeString()}.");
    }

    protected function updateCrypto($instrument)
    {
        if (!$instrument->coingecko_id) {
            $this->warn("Missing coingecko_id for {$instrument->symbol}");
            return;
        }

        $response = Http::get("https://api.coingecko.com/api/v3/simple/price", [
            'ids' => $instrument->coingecko_id,
            'vs_currencies' => 'usd',
            'include_market_cap' => true,
            'include_24hr_vol' => true,
            'include_24hr_change' => true,
            'include_last_updated_at' => true,
        ]);

        if (!$response->successful()) {
            $this->error("Coingecko API error for {$instrument->symbol}: {$response->status()}");
            return;
        }

        $data = $response->json()[$instrument->coingecko_id] ?? null;

        if (!$data || !isset($data['usd'])) {
            $this->warn("No data for {$instrument->symbol}");
            return;
        }

        $timestamp = now()->floorMinute();

        MarketPrice::updateOrCreate(
            [
                'instrument_id' => $instrument->id,
                'timestamp' => $timestamp,
                'interval' => '1m',
            ],
            [
                'open' => $data['usd'],
                'high' => null,
                'low' => null,
                'close' => $data['usd'],
                'volume' => $data['usd_24h_vol'] ?? null,
                'source' => 'coingecko',
            ]
        );

        // Update current price on Instrument model
        $instrument->price = $data['usd'];
        $instrument->save();

        $this->info("Updated: {$instrument->symbol} (crypto)");
    }

    protected function updateFromFinnhub($instrument)
    {
        $apiKey = config('services.finnhub.key');

        $symbol = $instrument->symbol;
        $from = now()->subMinutes(5)->timestamp;
        $to = now()->timestamp;

        $url = 'https://finnhub.io/api/v1/stock/candle';

        $params = [
            'symbol' => $symbol,
            'resolution' => '1',
            'from' => $from,
            'to' => $to,
            'token' => $apiKey,
        ];

        $response = Http::get($url, $params)->json();

        if (!isset($response['s']) || $response['s'] !== 'ok') {
            $this->warn("No data for {$symbol}");
            return;
        }

        foreach ($response['t'] as $i => $timestamp) {
            MarketPrice::updateOrCreate(
                [
                    'instrument_id' => $instrument->id,
                    'timestamp' => Carbon::createFromTimestamp($timestamp)->floorMinute(),
                    'interval' => '1m',
                ],
                [
                    'open' => $response['o'][$i],
                    'high' => $response['h'][$i],
                    'low' => $response['l'][$i],
                    'close' => $response['c'][$i],
                    'volume' => $response['v'][$i],
                    'source' => 'finnhub',
                ]
            );
        }

        // Save the latest close price to the instrument
        $latestClose = end($response['c']);
        if ($latestClose) {
            $instrument->price = $latestClose;
            $instrument->save();
        }

        $this->info("Updated: {$symbol} ({$instrument->type})");
    }
}
