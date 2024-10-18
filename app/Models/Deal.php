<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Deal extends Model
{
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $deal_translation = $this->hasMany(DealTranslation::class)->where('lang', $lang)->first();
        return $deal_translation != null ? $deal_translation->$field : $this->$field;
    }

    public function deal_translations()
    {
        return $this->hasMany(DealTranslation::class);
    }

    public function dealProducts()
    {
        return $this->hasMany(DealProduct::class);
    }
}
