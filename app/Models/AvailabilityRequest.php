<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilityRequest extends Model
{
    protected $fillable = [
        'shop_id',
        'date',
        'previous_from_time',
        'previous_to_time',
        'from_time',
        'to_time',
        'status',
        'viewed',
        'request_approved'
    ];
}
