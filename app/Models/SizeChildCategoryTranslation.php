<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeChildCategoryTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'size_child_category_id'];

    public function size_child_category(){
        return $this->belongsTo(SizeChildCategory::class);
    }
}
