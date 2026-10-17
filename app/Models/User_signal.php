<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_signal extends Model
{
    use HasFactory;

    public function dsignal(){
        return $this->belongsTo(Signal::class, 'signals', 'id');
    }

    public function suser(){
    	return $this->belongsTo(User::class, 'user', 'id');
    }
}
