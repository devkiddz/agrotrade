<?php

// app/Console/Commands/UpdateCryptoPrices.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Instrument;

class UpdateCryptoPrices extends Command
{
    protected $signature = 'update:crypto';
    protected $description = 'Update crypto instruments with data from CoinGecko';

    public function handle()
    {
        $response = Http::get('https://api.coingecko.com/api/v3/coins/markets', [
            'vs_currency' => 'usd',
            'order' => 'market_cap_desc',
            'per_page' => 50,
            'page' => 1,
            'sparkline' => false,
        ]);

        $data = $response->json();

        foreach ($data as $item) {
            Instrument::updateOrCreate(
                ['symbol' => strtoupper($item['symbol']) . '/USD'],
                [
                    'name' => $item['name'],
                    'type' => 'crypto',
                    'open' => null,
                    'high' => $item['high_24h'],
                    'low' => $item['low_24h'],
                    'close' => $item['current_price'],
                    'price' => $item['current_price'],
                    'percent_change_24h' => $item['price_change_percentage_24h'],
                    'change' => $item['price_change_24h'],
                    'market_cap' => $item['market_cap'],
                    'volume' => $item['total_volume'],
                    'logo' => $item['image'],
                ]
            );
        }

        $this->info('Crypto prices updated.');
    }
}
