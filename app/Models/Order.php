<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'seller_id',
        'carlist_id',
        'availability_id',
        'remind_package_status',
        'user_date_update',
        'start_installation_status',
        'done_installation_status',
        'delivery_type',
        'reassign_status',
        'workshop_date',
        'workshop_time',
        'old_workshop_date',
        'old_workshop_time',
        'old_workshop_id',
        'reassign_date',
        'viewed',
        'admin_viewed',
        'is_gift_discount_applied',
        'gift_discount_data',
        'is_gift_product_availed',
        'gift_product_data'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function refund_requests()
    {
        return $this->hasMany(RefundRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->hasOne(Shop::class, 'user_id', 'seller_id');
    }

    public function affiliate_log()
    {
        return $this->hasMany(AffiliateLog::class);
    }
}
