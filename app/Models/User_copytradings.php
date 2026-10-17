<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class User_copytradings extends Model
{
    use HasFactory;

    protected $fillable = [
        'cptrading',
        'user',
        'price',
        'active',
        'name',
        'tag',
        'type',
        'started_at',
        'last_profit',
        'total_profit',
        'current_balance',
        'total_trades',
        'winning_trades',
        'profit_percentage'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'profit_percentage' => 'decimal:2',
        'total_trades' => 'integer',
        'winning_trades' => 'integer',
        'started_at' => 'datetime',
        'last_profit' => 'datetime'
    ];

    /**
     * Get the copytrading plan this user is following
     */
    public function dcopytrading()
    {
        return $this->belongsTo(Copytrading::class, 'cptrading', 'id');
    }

    /**
     * Get the expert trader this user is copying
     */
    public function expert()
    {
        return $this->belongsTo(Copytrading::class, 'cptrading', 'id');
    }

    /**
     * Get the user who owns this copy trading plan
     */
    public function cuser()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    /**
     * Get the win rate for this user's copy trading
     */
    public function getWinRateAttribute()
    {
        if ($this->total_trades == 0) {
            return 0;
        }
        return round(($this->winning_trades / $this->total_trades) * 100, 2);
    }

    /**
     * Get the total return on investment
     */
    public function getTotalRoiAttribute()
    {
        if ($this->price == 0) {
            return 0;
        }
        return round(($this->total_profit / $this->price) * 100, 2);
    }

    /**
     * Check if it's time for next profit calculation
     */
    public function isTimeForNextProfit()
    {
        if (!$this->last_profit) {
            return true; // First profit calculation
        }

        $lastProfit = Carbon::parse($this->last_profit);
        $hoursToAdd = rand(4, 6); // Random interval between 4-6 hours
        $nextProfitTime = $lastProfit->addHours($hoursToAdd);

        return Carbon::now()->greaterThanOrEqualTo($nextProfitTime);
    }

    /**
     * Scope for active copy trading plans
     */
    public function scopeActive($query)
    {
        return $query->where('active', 'yes');
    }
}
