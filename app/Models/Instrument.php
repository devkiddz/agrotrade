<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    protected $fillable = [
        'symbol',
        'type',
        'name',
        'logo',
        'price',
        'open',
        'high',
        'low',
        'close',
        'volume',
        'market_cap',
        'change',
        'percent_change_24h',
    ];

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function marketPrices()
    {
        return $this->hasMany(MarketPrice::class);
    }
}
