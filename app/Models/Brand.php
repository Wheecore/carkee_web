<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Brand extends Model
{
    protected $fillable=[
        'name'
    ];
    public function brandcategories()
    {
        return $this->hasMany(Brand::class);
    }
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function parent()
    {
        return $this->belongsTo(Brand::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Brand::class, 'parent_id');
    }

    // Recursive parents
    public function parents() {
        return $this->belongsTo(Brand::class, 'parent_id')
            ->with('parent');
    }

    public function getParentsNames() {

        $parents = collect([]);

        if($this->parent) {
            $parent = $this->parent;
            while(!is_null($parent)) {
                $parents->push($parent);
                $parent = $parent->parent;
            }
            return $parents;
        } else {
            return $this->name;
        }

    }
  public function getTranslation($field = '', $lang = false){
      $lang = $lang == false ? App::getLocale() : $lang;
      $brand_translation = $this->hasMany(BrandTranslation::class)->where('lang', $lang)->first();
      return $brand_translation != null ? $brand_translation->$field : $this->$field;
  }

  public function brand_translations(){
    return $this->hasMany(BrandTranslation::class);
  }

}
