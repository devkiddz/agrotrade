<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;


    public function luser(){
    	return $this->belongsTo(User::class, 'user', 'id');
    }
}
