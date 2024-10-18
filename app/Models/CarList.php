<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarList extends Model
{
    protected $fillable=[
        'user_id',
        'car_plate',
        'mileage',
        'chassis_number',
        'vehicle_size',
        'insurance',
        'brand_id',
        'model_id',
        'details_id',
        'year_id',
        'type_id',
        'size_alternative_id',
        'image'
    ];
}
