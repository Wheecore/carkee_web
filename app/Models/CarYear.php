<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
class CarYear extends Model
{
    protected $fillable=[
        'brand_id',
        'model_id',
        'name'
    ];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $detail_translation = $this->hasMany(CarYearTranslation::class)->where('lang', $lang)->first();
        return $detail_translation != null ? $detail_translation->$field : $this->$field;
    }

    public function car_year_translations(){
        return $this->hasMany(CarYearTranslation::class);
    }
}
