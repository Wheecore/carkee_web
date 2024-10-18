<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModelTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'car_model_id'];

    public function car_model(){
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }
}
