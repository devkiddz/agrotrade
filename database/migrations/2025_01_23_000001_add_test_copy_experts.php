<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Copytrading;

return new class extends Migration
{
    public function up()
    {
        // Add some test expert traders
        $experts = [
            [
                'name' => 'Alex Thompson',
                'tag' => 'Forex Expert',
                'rating' => 5,
                'equity' => 125000,
                'total_profit' => 85.5,
                'win_rate' => 92,
                'total_trades' => 1547,
                'price' => 100.00,
                'description' => 'Experienced forex trader specializing in major currency pairs with a focus on risk management.',
                'status' => 'active',
                'followers' => 234
            ],
            [
                'name' => 'Sarah Chen',
                'tag' => 'Crypto Specialist',
                'rating' => 4,
                'equity' => 89000,
                'total_profit' => 127.3,
                'win_rate' => 87,
                'total_trades' => 892,
                'price' => 250.00,
                'description' => 'Cryptocurrency trading expert with deep knowledge of altcoin markets and DeFi protocols.',
                'status' => 'active',
                'followers' => 156
            ],
            [
                'name' => 'Marcus Rodriguez',
                'tag' => 'Stock Market Pro',
                'rating' => 5,
                'equity' => 310000,
                'total_profit' => 203.7,
                'win_rate' => 89,
                'total_trades' => 2341,
                'price' => 500.00,
                'description' => 'Professional stock trader with 15+ years experience in equity markets and technical analysis.',
                'status' => 'active',
                'followers' => 412
            ],
            [
                'name' => 'Emma Wilson',
                'tag' => 'Day Trader',
                'rating' => 4,
                'equity' => 67000,
                'total_profit' => 156.8,
                'win_rate' => 85,
                'total_trades' => 3247,
                'price' => 150.00,
                'description' => 'High-frequency day trader focusing on scalping strategies and momentum trading.',
                'status' => 'active',
                'followers' => 298
            ],
            [
                'name' => 'David Kim',
                'tag' => 'Swing Trader',
                'rating' => 5,
                'equity' => 198000,
                'total_profit' => 94.2,
                'win_rate' => 91,
                'total_trades' => 687,
                'price' => 300.00,
                'description' => 'Swing trading specialist using fundamental and technical analysis for medium-term positions.',
                'status' => 'active',
                'followers' => 178
            ]
        ];

        foreach ($experts as $expert) {
            Copytrading::updateOrCreate(
                ['name' => $expert['name']],
                $expert
            );
        }
    }

    public function down()
    {
        Copytrading::whereIn('name', [
            'Alex Thompson',
            'Sarah Chen',
            'Marcus Rodriguez',
            'Emma Wilson',
            'David Kim'
        ])->delete();
    }
};
