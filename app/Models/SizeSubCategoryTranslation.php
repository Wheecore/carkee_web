<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeSubCategoryTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'size_sub_category_id'];

    public function size_sub_category(){
        return $this->belongsTo(SizeSubCategory::class);
    }
}
