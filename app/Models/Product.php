<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use App\User;

class Product extends Model
{

    protected $fillable = [
        'name', 'added_by', 'user_id', 'category_id', 'brand_id', 'model_id', 'details_id', 'year_id', 'type_id', 'video_provider', 'video_link', 'cost_price', 'unit_price',
        'slug', 'low_stock_quantity', 'thumbnail_img', 'meta_title', 'meta_description', 'sub_category_id', 'sub_child_category_id','qty'
    ];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $product_translations = $this->hasMany(ProductTranslation::class)->where('lang', $lang)->first();
        return $product_translations != null ? $product_translations->$field : $this->$field;
    }

    public function product_translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 1);
    }

    public function taxes()
    {
        return $this->hasMany(ProductTax::class);
    }

    public function deal_product()
    {
        return $this->hasOne(DealProduct::class);
    }
    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function cartype()
    {
        return $this->belongsTo(CarType::class, 'type_id');
    }
    public function detail()
    {
        return $this->belongsTo(CarDetail::class, 'details_id');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}
