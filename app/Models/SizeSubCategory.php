<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class SizeSubCategory extends Model
{
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $size_sub_category_translation = $this->hasMany(SizeSubCategoryTranslation::class)->where('lang', $lang)->first();
        return $size_sub_category_translation != null ? $size_sub_category_translation->$field : $this->$field;
    }

    public function size_sub_category_translations(){
        return $this->hasMany(SizeSubCategoryTranslation::class);
    }
}
