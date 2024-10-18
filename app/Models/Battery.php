<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'attachment_id',
        'car_brand_id',
        'car_model_id',
        'car_detail_id',
        'car_year_id',
        'car_type_id',
        'service_type',
        'name',
        'warranty',
        'model',
        'amount',
        'discount',
        'stock',
        'capacity',
        'cold_cranking_amperes',
        'mileage_warranty',
        'reserve_capacity',
        'height',
        'length',
        'start_stop_function',
        'width',
        'jis',
        'absorbed_glass_mat'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
