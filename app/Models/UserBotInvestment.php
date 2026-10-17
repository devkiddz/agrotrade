<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserBotInvestment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bot_id',
        'investment_amount',
        'current_balance',
        'total_profit',
        'total_loss',
        'successful_trades',
        'failed_trades',
        'started_at',
        'expires_at',
        'last_profit_at',
        'status',
        'auto_reinvest',
        'reinvest_percentage',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_profit_at' => 'datetime',
    ];

    /**
     * Get the user that owns this investment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the trading bot for this investment
     */
    public function bot()
    {
        return $this->belongsTo(TradingBot::class, 'bot_id');
    }

    /**
     * Get trading history for this investment
     */
    public function tradingHistory()
    {
        return $this->hasMany(BotTradingHistory::class, 'user_bot_investment_id');
    }

    /**
     * Get recent trading history
     */
    public function recentTrades()
    {
        return $this->hasMany(BotTradingHistory::class, 'user_bot_investment_id')
                    ->latest('opened_at')
                    ->limit(10);
    }

    /**
     * Check if investment is active
     */
    public function isActive()
    {
        return $this->status === 'active' && $this->expires_at > Carbon::now();
    }

    /**
     * Check if it's time to generate profit
     */
    public function shouldGenerateProfit()
    {
        if (!$this->isActive()) {
            return false;
        }

        // Generate profit every 4-8 hours
        $lastProfit = $this->last_profit_at ?: $this->started_at;
        $hoursToAdd = rand(4, 8);
        $nextProfitTime = $lastProfit->addHours($hoursToAdd);

        return Carbon::now()->greaterThanOrEqualTo($nextProfitTime);
    }

    /**
     * Get total ROI percentage
     */
    public function getRoiPercentageAttribute()
    {
        if ($this->investment_amount <= 0) {
            return 0;
        }

        return round((($this->total_profit - $this->total_loss) / $this->investment_amount) * 100, 2);
    }

    /**
     * Get current profit (total profit minus total loss)
     */
    public function getCurrentProfitAttribute()
    {
        return $this->total_profit - $this->total_loss;
    }

    /**
     * Get success rate for this investment
     */
    public function getSuccessRateAttribute()
    {
        $totalTrades = $this->successful_trades + $this->failed_trades;

        if ($totalTrades <= 0) {
            return 0;
        }

        return round(($this->successful_trades / $totalTrades) * 100, 2);
    }

    /**
     * Get days remaining
     */
    public function getDaysRemainingAttribute()
    {
        if (!$this->isActive()) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->expires_at, false);
    }

    /**
     * Scope for active investments
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('expires_at', '>', Carbon::now());
    }

    /**
     * Scope for expired investments
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', Carbon::now())
                    ->where('status', 'active');
    }
}
