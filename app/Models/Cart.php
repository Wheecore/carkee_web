<?php

namespace App\Models;

use App\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];
    protected $fillable = ['owner_id','user_id','carlist_id','package_id','address_id','product_id','price','tax','shipping_cost','shipping_type','pickup_point','discount','gift_discount','coupon_code','coupon_id','coupon_applied','coupon_applied_product','is_gift_discount_applied','discount_title','gift_discount_coupon_applied_product','quantity','express_delivery'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
