<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'seller_id',
        'nearby_workshop',
        'longitude',
        'latitude',
        'address',
        'rating'
    ];
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
