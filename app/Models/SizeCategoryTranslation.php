<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeCategoryTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'size_category_id'];

    public function size_category(){
        return $this->belongsTo(SizeCategory::class);
    }
}
