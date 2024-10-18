<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tyre extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'car_brand_id',
        'car_model_id',
        'car_detail_id',
        'car_year_id',
        'car_type_id',
        'name',
        'amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
