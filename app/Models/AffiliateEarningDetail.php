<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AffiliateEarningDetail extends Model
{
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
