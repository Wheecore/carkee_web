<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ServiceCategory extends Model
{
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $category_translation = $this->hasMany(ServiceCategoryTranslation::class)->where('lang', $lang)->first();
        return $category_translation != null ? $category_translation->$field : $this->$field;
    }

    public function category_translations()
    {
        return $this->hasMany(ServiceCategoryTranslation::class);
    }
}
