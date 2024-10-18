<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class SizeChildCategory extends Model
{
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $size_child_category_translation = $this->hasMany(SizeChildCategoryTranslation::class)->where('lang', $lang)->first();
        return $size_child_category_translation != null ? $size_child_category_translation->$field : $this->$field;
    }

    public function size_child_category_translations(){
        return $this->hasMany(SizeChildCategoryTranslation::class);
    }
}
