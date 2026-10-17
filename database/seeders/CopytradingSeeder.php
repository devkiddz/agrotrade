<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Copytrading;

class CopytradingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $traders = [
            [
                'name' => 'Alex Johnson',
                'photo' => 'traders/alex-johnson.jpg',
                'rating' => 5,
                'followers' => 1250,
                'equity' => 87.5,
                'total_profit' => 125000.00,
                'status' => 'active',
                'description' => 'Professional forex trader with 8+ years experience. Specializes in EUR/USD and GBP/USD pairs.',
                'win_rate' => 87,
                'total_trades' => 2340,
                'price' => 500.00,
                'tag' => 'PRO',
                'type' => 'main'
            ],
            [
                'name' => 'Sarah Chen',
                'photo' => 'traders/sarah-chen.jpg',
                'rating' => 5,
                'followers' => 890,
                'equity' => 82.3,
                'total_profit' => 98500.00,
                'status' => 'active',
                'description' => 'Crypto and forex expert. Known for conservative risk management and consistent profits.',
                'win_rate' => 82,
                'total_trades' => 1890,
                'price' => 300.00,
                'tag' => 'EXPERT',
                'type' => 'main'
            ],
            [
                'name' => 'Mike Rodriguez',
                'photo' => 'traders/mike-rodriguez.jpg',
                'rating' => 4,
                'followers' => 654,
                'equity' => 79.1,
                'total_profit' => 67800.00,
                'status' => 'active',
                'description' => 'Day trader focusing on high volatility pairs. Great for short-term gains.',
                'win_rate' => 79,
                'total_trades' => 1567,
                'price' => 250.00,
                'tag' => 'FAST',
                'type' => 'main'
            ],
            [
                'name' => 'Emma Williams',
                'photo' => 'traders/emma-williams.jpg',
                'rating' => 5,
                'followers' => 1100,
                'equity' => 85.7,
                'total_profit' => 156700.00,
                'status' => 'active',
                'description' => 'Long-term strategy expert. Perfect for steady, sustainable growth.',
                'win_rate' => 85,
                'total_trades' => 2100,
                'price' => 400.00,
                'tag' => 'STABLE',
                'type' => 'main'
            ],
            [
                'name' => 'David Kim',
                'photo' => 'traders/david-kim.jpg',
                'rating' => 4,
                'followers' => 567,
                'equity' => 76.8,
                'total_profit' => 45600.00,
                'status' => 'active',
                'description' => 'Scalping specialist with quick entry and exit strategies.',
                'win_rate' => 76,
                'total_trades' => 1234,
                'price' => 200.00,
                'tag' => 'SCALP',
                'type' => 'main'
            ],
            [
                'name' => 'Lisa Thompson',
                'photo' => 'traders/lisa-thompson.jpg',
                'rating' => 5,
                'followers' => 934,
                'equity' => 88.2,
                'total_profit' => 112300.00,
                'status' => 'active',
                'description' => 'Gold and commodities trading expert with excellent risk management.',
                'win_rate' => 88,
                'total_trades' => 1876,
                'price' => 350.00,
                'tag' => 'GOLD',
                'type' => 'main'
            ]
        ];

        foreach ($traders as $trader) {
            Copytrading::create($trader);
        }
    }
}
