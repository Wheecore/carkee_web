<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarYearTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'car_year_id'];

    public function car_year(){
        return $this->belongsTo(CarYear::class, 'car_year_id');
    }
}
