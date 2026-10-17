<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BotTradingHistory extends Model
{
    use HasFactory;

    protected $table = 'bot_trading_history';

    protected $fillable = [
        'user_bot_investment_id',
        'trade_type',
        'trading_pair',
        'entry_price',
        'exit_price',
        'amount',
        'profit_loss',
        'profit_percentage',
        'result',
        'strategy_used',
        'opened_at',
        'closed_at',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * Get the user bot investment this trade belongs to
     */
    public function userBotInvestment()
    {
        return $this->belongsTo(UserBotInvestment::class, 'user_bot_investment_id');
    }

    /**
     * Get the user through the investment
     */
    public function user()
    {
        return $this->userBotInvestment->user();
    }

    /**
     * Get the bot through the investment
     */
    public function bot()
    {
        return $this->userBotInvestment->bot();
    }

    /**
     * Check if trade is profitable
     */
    public function isProfitable()
    {
        return $this->result === 'profit';
    }

    /**
     * Get formatted profit/loss
     */
    public function getFormattedProfitLossAttribute()
    {
        $symbol = $this->profit_loss >= 0 ? '+' : '';
        return $symbol . number_format($this->profit_loss, 2);
    }

    /**
     * Get trade duration in minutes
     */
    public function getDurationAttribute()
    {
        if (!$this->closed_at || !$this->opened_at) {
            return 0;
        }

        return $this->opened_at->diffInMinutes($this->closed_at);
    }

    /**
     * Scope for profitable trades
     */
    public function scopeProfitable($query)
    {
        return $query->where('result', 'profit');
    }

    /**
     * Scope for loss trades
     */
    public function scopeLoss($query)
    {
        return $query->where('result', 'loss');
    }

    /**
     * Scope for specific trading pair
     */
    public function scopeByPair($query, $pair)
    {
        return $query->where('trading_pair', $pair);
    }

    /**
     * Scope for recent trades
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('opened_at', '>=', Carbon::now()->subDays($days));
    }
}
