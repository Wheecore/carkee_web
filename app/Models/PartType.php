<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class PartType extends Model
{
    protected $fillable=[
        'name'
    ];

    public function getTranslation($field = '', $lang = false){
          $lang = $lang == false ? App::getLocale() : $lang;
          $brand_translation = $this->hasMany(PartTypeTranslation::class)->where('lang', $lang)->first();
          return $brand_translation != null ? $brand_translation->$field : $this->$field;
    }
    
      public function part_type_translations(){
        return $this->hasMany(PartTypeTranslation::class);
      }
}
