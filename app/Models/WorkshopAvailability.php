<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopAvailability extends Model
{
     protected $fillable = [
        'shop_id',
        'date',
        'from_time',
        'to_time',
        'booked_appointments'
        ];
}
