<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instrument;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $instruments = [
            // Cryptocurrencies
            [
                'symbol' => 'BTC/USD',
                'name' => 'Bitcoin',
                'type' => 'crypto',
                'price' => 43250.75,
                'open' => 42800.00,
                'high' => 43500.00,
                'low' => 42300.00,
                'close' => 43250.75,
                'change' => 450.75,
                'percent_change_24h' => 1.05,
                'volume' => 28500000000,
                'market_cap' => 845000000000,
                'logo' => 'https://cryptologos.cc/logos/bitcoin-btc-logo.png'
            ],
            [
                'symbol' => 'ETH/USD',
                'name' => 'Ethereum',
                'type' => 'crypto',
                'price' => 2650.40,
                'open' => 2580.00,
                'high' => 2680.00,
                'low' => 2560.00,
                'close' => 2650.40,
                'change' => 70.40,
                'percent_change_24h' => 2.73,
                'volume' => 15200000000,
                'market_cap' => 318000000000,
                'logo' => 'https://cryptologos.cc/logos/ethereum-eth-logo.png'
            ],
            [
                'symbol' => 'BNB/USD',
                'name' => 'Binance Coin',
                'type' => 'crypto',
                'price' => 315.80,
                'open' => 308.50,
                'high' => 318.90,
                'low' => 305.20,
                'close' => 315.80,
                'change' => 7.30,
                'percent_change_24h' => 2.37,
                'volume' => 890000000,
                'market_cap' => 47200000000,
                'logo' => 'https://cryptologos.cc/logos/bnb-bnb-logo.png'
            ],
            [
                'symbol' => 'SOL/USD',
                'name' => 'Solana',
                'type' => 'crypto',
                'price' => 98.75,
                'open' => 95.20,
                'high' => 101.30,
                'low' => 94.80,
                'close' => 98.75,
                'change' => 3.55,
                'percent_change_24h' => 3.73,
                'volume' => 2400000000,
                'market_cap' => 42800000000,
                'logo' => 'https://cryptologos.cc/logos/solana-sol-logo.png'
            ],
            [
                'symbol' => 'ADA/USD',
                'name' => 'Cardano',
                'type' => 'crypto',
                'price' => 0.485,
                'open' => 0.470,
                'high' => 0.492,
                'low' => 0.468,
                'close' => 0.485,
                'change' => 0.015,
                'percent_change_24h' => 3.19,
                'volume' => 450000000,
                'market_cap' => 17200000000,
                'logo' => 'https://cryptologos.cc/logos/cardano-ada-logo.png'
            ],

            // Stocks
            [
                'symbol' => 'AAPL',
                'name' => 'Apple Inc.',
                'type' => 'stock',
                'price' => 175.84,
                'open' => 174.20,
                'high' => 176.50,
                'low' => 173.90,
                'close' => 175.84,
                'change' => 1.64,
                'percent_change_24h' => 0.94,
                'volume' => 65000000,
                'market_cap' => 2750000000000,
                'logo' => 'https://logo.clearbit.com/apple.com'
            ],
            [
                'symbol' => 'GOOGL',
                'name' => 'Alphabet Inc.',
                'type' => 'stock',
                'price' => 138.45,
                'open' => 136.80,
                'high' => 139.20,
                'low' => 136.30,
                'close' => 138.45,
                'change' => 1.65,
                'percent_change_24h' => 1.21,
                'volume' => 28000000,
                'market_cap' => 1710000000000,
                'logo' => 'https://logo.clearbit.com/google.com'
            ],
            [
                'symbol' => 'MSFT',
                'name' => 'Microsoft Corporation',
                'type' => 'stock',
                'price' => 368.20,
                'open' => 365.50,
                'high' => 370.10,
                'low' => 364.80,
                'close' => 368.20,
                'change' => 2.70,
                'percent_change_24h' => 0.74,
                'volume' => 32000000,
                'market_cap' => 2740000000000,
                'logo' => 'https://logo.clearbit.com/microsoft.com'
            ],
            [
                'symbol' => 'TSLA',
                'name' => 'Tesla, Inc.',
                'type' => 'stock',
                'price' => 248.50,
                'open' => 245.20,
                'high' => 252.80,
                'low' => 243.90,
                'close' => 248.50,
                'change' => 3.30,
                'percent_change_24h' => 1.35,
                'volume' => 85000000,
                'market_cap' => 790000000000,
                'logo' => 'https://logo.clearbit.com/tesla.com'
            ],
            [
                'symbol' => 'NVDA',
                'name' => 'NVIDIA Corporation',
                'type' => 'stock',
                'price' => 875.30,
                'open' => 862.40,
                'high' => 881.90,
                'low' => 858.70,
                'close' => 875.30,
                'change' => 12.90,
                'percent_change_24h' => 1.50,
                'volume' => 42000000,
                'market_cap' => 2160000000000,
                'logo' => 'https://logo.clearbit.com/nvidia.com'
            ],

            // Forex
            [
                'symbol' => 'EUR/USD',
                'name' => 'Euro to US Dollar',
                'type' => 'forex',
                'price' => 1.0875,
                'open' => 1.0860,
                'high' => 1.0890,
                'low' => 1.0845,
                'close' => 1.0875,
                'change' => 0.0015,
                'percent_change_24h' => 0.14,
                'volume' => 1500000000,
                'market_cap' => null,
                'logo' => null
            ],
            [
                'symbol' => 'GBP/USD',
                'name' => 'British Pound to US Dollar',
                'type' => 'forex',
                'price' => 1.2685,
                'open' => 1.2650,
                'high' => 1.2720,
                'low' => 1.2635,
                'close' => 1.2685,
                'change' => 0.0035,
                'percent_change_24h' => 0.28,
                'volume' => 1200000000,
                'market_cap' => null,
                'logo' => null
            ],
            [
                'symbol' => 'USD/JPY',
                'name' => 'US Dollar to Japanese Yen',
                'type' => 'forex',
                'price' => 148.75,
                'open' => 148.20,
                'high' => 149.10,
                'low' => 147.90,
                'close' => 148.75,
                'change' => 0.55,
                'percent_change_24h' => 0.37,
                'volume' => 1100000000,
                'market_cap' => null,
                'logo' => null
            ],

            // Commodities
            [
                'symbol' => 'GOLD',
                'name' => 'Gold',
                'type' => 'commodity',
                'price' => 1985.40,
                'open' => 1978.50,
                'high' => 1992.80,
                'low' => 1975.20,
                'close' => 1985.40,
                'change' => 6.90,
                'percent_change_24h' => 0.35,
                'volume' => 2800000000,
                'market_cap' => null,
                'logo' => null
            ],
            [
                'symbol' => 'SILVER',
                'name' => 'Silver',
                'type' => 'commodity',
                'price' => 24.85,
                'open' => 24.60,
                'high' => 25.10,
                'low' => 24.45,
                'close' => 24.85,
                'change' => 0.25,
                'percent_change_24h' => 1.02,
                'volume' => 450000000,
                'market_cap' => null,
                'logo' => null
            ],
            [
                'symbol' => 'OIL',
                'name' => 'Crude Oil',
                'type' => 'commodity',
                'price' => 78.95,
                'open' => 77.80,
                'high' => 79.40,
                'low' => 77.50,
                'close' => 78.95,
                'change' => 1.15,
                'percent_change_24h' => 1.48,
                'volume' => 1800000000,
                'market_cap' => null,
                'logo' => null
            ],

            // Bonds
            [
                'symbol' => 'US10Y',
                'name' => 'US 10-Year Treasury Bond',
                'type' => 'bond',
                'price' => 4.425,
                'open' => 4.400,
                'high' => 4.450,
                'low' => 4.385,
                'close' => 4.425,
                'change' => 0.025,
                'percent_change_24h' => 0.57,
                'volume' => 890000000,
                'market_cap' => null,
                'logo' => null
            ],
            [
                'symbol' => 'US30Y',
                'name' => 'US 30-Year Treasury Bond',
                'type' => 'bond',
                'price' => 4.580,
                'open' => 4.560,
                'high' => 4.595,
                'low' => 4.545,
                'close' => 4.580,
                'change' => 0.020,
                'percent_change_24h' => 0.44,
                'volume' => 320000000,
                'market_cap' => null,
                'logo' => null
            ],
        ];

        foreach ($instruments as $instrument) {
            Instrument::create($instrument);
        }
    }
}
