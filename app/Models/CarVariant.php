<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class CarVariant extends Model
{
    protected $fillable=[
        'brand_id',
        'model_id',
        'year_id',
        'name'
    ];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $year_translation = $this->hasMany(CarVariantTranslation::class)->where('lang', $lang)->first();
        return $year_translation != null ? $year_translation->$field : $this->$field;
    }

    public function car_variant_translations(){
        return $this->hasMany(CarVariantTranslation::class);
    }
}
