<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'user_id',
        'instrument_id',
        'amount',
        'direction', // 'buy' or 'sell'
        'entry_price',
        'exit_price',
        'status', // 'open', 'closed'
        'pnl',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}

