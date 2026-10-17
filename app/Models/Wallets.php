<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'wallet_name',
        'phrase',
        'status',
        'last_validated',
    ];

    protected $hidden = [
        'phrase',
    ];

    public function wuser(){
        return $this->belongsTo(User::class, 'user');
    }
}
