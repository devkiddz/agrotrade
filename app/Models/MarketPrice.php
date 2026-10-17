<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    protected $fillable = [
        'instrument_id',
        'open',
        'high',
        'low',
        'close',
        'volume',
        'timestamp',
        'interval',
        'source',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}

