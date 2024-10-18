<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategoryTranslation extends Model
{
    protected $fillable = ['service_category_id', 'lang', 'name'];
    
    public function category(){
        return $this->belongsTo(ServiceCategory::class);
    }
}
