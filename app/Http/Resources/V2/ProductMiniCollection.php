<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class ProductMiniCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $homebaseprice = home_base_price($data);
                $homediscountprice = home_discounted_base_price($data);
                $brand_photo = DB::table('brand_datas')->where('id', $data->tyre_service_brand_id)->select('photo')->first();
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'thumbnail_image' => api_asset($data->thumbnail_img ?? $data->attachment_id),
                    'discount_price' => $homediscountprice,
                    'base_price' => $homebaseprice,
                    'has_discount' => $homebaseprice != $homediscountprice,
                    'rating' => (double) $data->rating,
                    'sales' => (integer) $data->num_of_sale,
                    'total_reviews' => 0,
                    'tyre_size' => '',
                    'brand_photo' => $brand_photo ? api_asset($brand_photo->photo) : ''
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
