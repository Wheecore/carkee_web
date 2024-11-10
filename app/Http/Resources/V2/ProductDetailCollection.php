<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

ini_set('serialize_precision', -1);

class ProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $date = date('F d Y', $data->discount_start_date);
                $start_time = date('H:i A', $data->discount_start_date);
                $end_time = date('H:i A', $data->discount_end_date);
                $discount = ($data->discount_type == 'amount')?single_price($data->discount):$data->discount.'%';
                $reviews = DB::table('reviews')->join('users', 'users.id', '=', 'reviews.user_id')->select('users.name', 'reviews.rating', 'reviews.comment')->where('reviews.product_id', $data->id)->where('reviews.status', 1)->orderBy('reviews.id', 'desc')->limit(4)->get()->toArray();
                $reviews_arr = [];
                foreach ($reviews as $review) {
                    $reviews_arr[] = array(
                        'name' => $review->name,
                        'rating' => number_format($review->rating, 1),
                        'review' => $review->comment,
                    );
                }
                return [
                    'id' => (integer) $data->id,
                    'name' => $data->name,
                    'photos' => get_images_path($data->photos),
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'tags' => explode(',', $data->tags),
                    'has_discount' => ($data->discount > 0)?true:false,
                    'discount' => $discount,
                    'discount_dates' => (strtotime(date('Y-m-d H:i:s', $data->discount_end_date)) > strtotime(date('Y-m-d H:i:s')))?'Get '.$discount.' discount from '. $date.'-'.$start_time.' to '.date('F d Y', $data->discount_end_date).'-'.$end_time.'!':'',
                    // 'qty_1_price' => homeDiscountedBasePrice($data, $data->quantity_1_price),
                    // if category_name == "Tyre" then qty_1_price = qty_1_price, else is unit_price
                    'qty_1_price' => ($data->category_name == "Tyre") ? homeDiscountedBasePrice($data, $data->quantity_1_price) : homeDiscountedBasePrice($data, $data->unit_price),
                    // 'greater_1_price' => homeDiscountedBasePrice($data, $data->greater_1_price),
                    'greater_1_price' => ($data->category_name == "Tyre") ? homeDiscountedBasePrice($data, $data->greater_1_price) : homeDiscountedBasePrice($data, $data->unit_price),
                    // 'greater_3_price' => homeDiscountedBasePrice($data, $data->greater_3_price),
                    'greater_3_price' => ($data->category_name == "Tyre") ? homeDiscountedBasePrice($data, $data->greater_3_price) : homeDiscountedBasePrice($data, $data->unit_price),
                    'currency_symbol' => currency_symbol(),
                    'current_stock' => (integer) $data->qty,
                    'rating' => number_format($data->rating, 2),
                    'description' => $data->description?$data->description:'',
                    'term_conditions' => $data->term_conditions?$data->term_conditions:'',
                    'brand' => ($data->featured_cat_id)?\App\Models\FeaturedCategory::where('id', $data->featured_cat_id)->first()->name:'',
                    'tyre_size' => $data->tyre_size?$data->tyre_size:'',
                    'speed_index' => $data->speed_index?$data->speed_index:'',
                    'load_index' => $data->load_index?$data->load_index:'',
                    'vehicle_type' => $data->vehicle_type?$data->vehicle_type:'',
                    // 'Viscosity' => $data->viscosity?$data->viscosity:'',
                    // 'Packaging' => $data->packaging?$data->packaging:'',
                    // 'Service_interval' => $data->service_interval?$data->service_interval:'',
                    'product_of' => $data->product_of?$data->product_of:'',
                    'warranty_type' => $data->warranty_type?$data->warranty_type:'',
                    'warranty_period' => $data->warranty_period?$data->warranty_period:'',
                    'labels' => explode(',',$data->label),
                    'video_link' => $data->video_link?$data->video_link:'',
                    'season' => $data->season,
                    'brand_photo' => ($data->tyre_service_brand_id) ? api_asset(DB::table('brand_datas')->where('id', $data->tyre_service_brand_id)->first()->photo) : '',
                    'performance' => ['dry' => $data->dry, 'wet' => $data->wet, 'sport' => $data->sport, 'comfort' => $data->comfort, 'mileage' => $data->mileage],
                    'reviews' => $reviews_arr,
                    // category_name from $data->category_name
                    'category_name' => $data->category_name,
                    ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
    
}
