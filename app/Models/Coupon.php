<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
   protected $fillable=['user_id','claimed_user_id','type','code', 'details', 'product_ids','discount','discount_type',
'start_date','end_date','limit','gift_type','gifts'];
}
