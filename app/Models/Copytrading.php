<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copytrading extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'rating',
        'followers',
        'equity',
        'total_profit',
        'status',
        'description',
        'win_rate',
        'total_trades',
        'price',
        'tag',
        'type'
    ];

    protected $casts = [
        'rating' => 'integer',
        'followers' => 'integer',
        'equity' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'win_rate' => 'integer',
        'total_trades' => 'integer',
        'price' => 'decimal:2'
    ];

    /**
     * Get users who are copying this trader
     */
    public function copiers()
    {
        return $this->hasMany(User_copytradings::class, 'cptrading', 'id');
    }

    /**
     * Get active copiers only
     */
    public function activeCopiers()
    {
        return $this->hasMany(User_copytradings::class, 'cptrading', 'id')
                    ->where('active', 'yes');
    }

    /**
     * Get the success rate attribute
     */
    public function getSuccessRateAttribute()
    {
        return $this->win_rate ?? 80;
    }

    /**
     * Get formatted profit rate
     */
    public function getFormattedProfitRateAttribute()
    {
        return number_format($this->equity, 1) . '%';
    }
}
