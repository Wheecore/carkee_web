<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class CarModel extends Model
{
//    use HasFactory;
    protected $fillable=[
        'brand_id',
        'name',
        'type'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $modal_translation = $this->hasMany(CarModelTranslation::class)->where('lang', $lang)->first();
        return $modal_translation != null ? $modal_translation->$field : $this->$field;
    }

    public function car_modal_translations(){
        return $this->hasMany(CarModelTranslation::class);
    }
}
