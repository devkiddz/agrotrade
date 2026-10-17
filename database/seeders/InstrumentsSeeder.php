<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instrument;

class InstrumentsSeeder extends Seeder
{
    public function run()
    {
        $instruments = [
            // Forex/Currency
            ['symbol' => 'EURUSD', 'name' => 'Euro/US Dollar', 'type' => 'forex', 'logo' => '/storage/logos/forex/eurusd.png'],
            ['symbol' => 'GBPUSD', 'name' => 'British Pound/US Dollar', 'type' => 'forex', 'logo' => '/storage/logos/forex/gbpusd.png'],
            ['symbol' => 'USDJPY', 'name' => 'US Dollar/Japanese Yen', 'type' => 'forex', 'logo' => '/storage/logos/forex/usdjpy.png'],
            ['symbol' => 'USDCAD', 'name' => 'US Dollar/Canadian Dollar', 'type' => 'forex', 'logo' => '/storage/logos/forex/usdcad.png'],
            ['symbol' => 'AUDUSD', 'name' => 'Australian Dollar/US Dollar', 'type' => 'forex', 'logo' => '/storage/logos/forex/audusd.png'],

            // Cryptocurrencies
            ['symbol' => 'BTCUSD', 'name' => 'Bitcoin', 'type' => 'crypto', 'logo' => 'https://assets.coingecko.com/coins/images/1/small/bitcoin.png'],
            ['symbol' => 'ETHUSD', 'name' => 'Ethereum', 'type' => 'crypto', 'logo' => 'https://assets.coingecko.com/coins/images/279/small/ethereum.png'],
            ['symbol' => 'ADAUSD', 'name' => 'Cardano', 'type' => 'crypto', 'logo' => 'https://assets.coingecko.com/coins/images/975/small/cardano.png'],
            ['symbol' => 'XRPUSD', 'name' => 'XRP', 'type' => 'crypto', 'logo' => 'https://assets.coingecko.com/coins/images/44/small/xrp-symbol-white-128.png'],
            ['symbol' => 'LTCUSD', 'name' => 'Litecoin', 'type' => 'crypto', 'logo' => 'https://assets.coingecko.com/coins/images/2/small/litecoin.png'],

            // Stocks
            ['symbol' => 'AAPL', 'name' => 'Apple Inc.', 'type' => 'stock', 'logo' => '/storage/logos/stocks/aapl.png'],
            ['symbol' => 'MSFT', 'name' => 'Microsoft Corporation', 'type' => 'stock', 'logo' => '/storage/logos/stocks/msft.png'],
            ['symbol' => 'GOOGL', 'name' => 'Alphabet Inc.', 'type' => 'stock', 'logo' => '/storage/logos/stocks/googl.png'],
            ['symbol' => 'TSLA', 'name' => 'Tesla, Inc.', 'type' => 'stock', 'logo' => '/storage/logos/stocks/tsla.png'],
            ['symbol' => 'AMZN', 'name' => 'Amazon.com, Inc.', 'type' => 'stock', 'logo' => '/storage/logos/stocks/amzn.png'],

            // Commodities
            ['symbol' => 'GOLD', 'name' => 'Gold', 'type' => 'commodity', 'logo' => '/storage/logos/commodities/gold.png'],
            ['symbol' => 'SILVER', 'name' => 'Silver', 'type' => 'commodity', 'logo' => '/storage/logos/commodities/silver.png'],
            ['symbol' => 'USOIL', 'name' => 'Crude Oil', 'type' => 'commodity', 'logo' => '/storage/logos/commodities/oil.png'],

            // Indices
            ['symbol' => 'SPX500', 'name' => 'S&P 500', 'type' => 'index', 'logo' => '/storage/logos/indices/spx500.png'],
            ['symbol' => 'NASDAQ', 'name' => 'NASDAQ 100', 'type' => 'index', 'logo' => '/storage/logos/indices/nasdaq.png'],
        ];

        foreach ($instruments as $instrument) {
            Instrument::updateOrCreate(
                ['symbol' => $instrument['symbol']],
                $instrument
            );
        }
    }
}
