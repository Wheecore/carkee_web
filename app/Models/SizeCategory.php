<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class SizeCategory extends Model
{
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $size_category_translation = $this->hasMany(SizeCategoryTranslation::class)->where('lang', $lang)->first();
        return $size_category_translation != null ? $size_category_translation->$field : $this->$field;
    }

    public function size_category_translations(){
        return $this->hasMany(SizeCategoryTranslation::class);
    }
}
