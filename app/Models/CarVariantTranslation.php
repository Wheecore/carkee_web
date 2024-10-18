<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarVariantTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'car_variant_id'];

    public function car_variant(){
        return $this->belongsTo(CarVariant::class, 'car_variant_id');
    }
}
