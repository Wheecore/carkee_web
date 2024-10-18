<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatterySubCategoryTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['battery_sub_category_id', 'lang', 'name'];
    
    public function category(){
        return $this->belongsTo(ServiceCategory::class);
    }
}
