<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TradingBot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bot_type',
        'description',
        'image',
        'min_investment',
        'max_investment',
        'daily_profit_min',
        'daily_profit_max',
        'success_rate',
        'duration_days',
        'total_earned',
        'total_users',
        'status',
        'trading_pairs',
        'risk_settings',
        'strategy_details',
        'last_trade',
    ];

    protected $casts = [
        'trading_pairs' => 'array',
        'risk_settings' => 'array',
        'strategy_details' => 'array',
        'last_trade' => 'datetime',
    ];

    /**
     * Get user investments for this bot
     */
    public function userInvestments()
    {
        return $this->hasMany(UserBotInvestment::class, 'bot_id');
    }

    /**
     * Get active investments for this bot
     */
    public function activeInvestments()
    {
        return $this->hasMany(UserBotInvestment::class, 'bot_id')->where('status', 'active');
    }

    /**
     * Get bot performance metrics
     */
    public function getPerformanceAttribute()
    {
        $investments = $this->userInvestments;
        $totalInvested = $investments->sum('investment_amount');
        $totalProfit = $investments->sum('total_profit');

        return [
            'total_invested' => $totalInvested,
            'total_profit' => $totalProfit,
            'roi_percentage' => $totalInvested > 0 ? round(($totalProfit / $totalInvested) * 100, 2) : 0,
            'active_users' => $this->activeInvestments()->count(),
        ];
    }

    /**
     * Check if bot is available for new investments
     */
    public function isAvailable()
    {
        return $this->status === 'active';
    }

    /**
     * Get formatted daily profit range
     */
    public function getDailyProfitRangeAttribute()
    {
        return $this->daily_profit_min . '% - ' . $this->daily_profit_max . '%';
    }

    /**
     * Scope for active bots
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for specific bot type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('bot_type', $type);
    }
}
