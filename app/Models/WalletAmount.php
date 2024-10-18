<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletAmount extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'free_amount',
    ];
}
