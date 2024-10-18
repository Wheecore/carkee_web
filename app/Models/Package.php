<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Package extends Model
{
    protected $fillable=[
        'brand_id',
        'model_id',
        'details_id',
        'type_id',
        'name',
        'mileage',
        'type',
        'logo',
        'slug',
        'type',
    ];
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $package_translation = $this->hasMany(PackageTranslation::class)->where('lang', $lang)->first();
        return $package_translation != null ? $package_translation->$field : $this->$field;
    }

    public function package_translations(){
        return $this->hasMany(PackageTranslation::class);
    }
}
