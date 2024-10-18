<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_admin',
        'type',
        'body',
        'content',
        'is_viewed',
        'order_id',
        'availability_request_id',
        'package_remind_id',
        'wallet_id',
        'gift_codes'
    ];
}
