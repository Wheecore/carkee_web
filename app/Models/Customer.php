<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
      'user_id',
      'point_balance',
    ];
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
