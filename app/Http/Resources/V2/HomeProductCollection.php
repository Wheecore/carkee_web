<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HomeProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($collection) {
                $home_discounted_base_price = home_discounted_base_price($collection);
                $home_base_price = home_base_price($collection);
                return [
                    'id' => $collection->id,
                    'name' => $collection->name,
                    'thumbnail_image' => $collection->thumbnail_image,
                    'discount_price' => $home_discounted_base_price,
                    // 'base_price' => $home_base_price,
                    'brand_id' => $collection->brand_id,
                    'base_price' => 'RM --',
                    'has_discount' => ($home_base_price != $home_discounted_base_price),
                    'rating' => (float) $collection->rating,
                    'sales' => (int) $collection->num_of_sale,
                    'total_reviews' => 0,
                    'tyre_size' => '',
                    'brand_photo' => $collection->photo ? api_asset($collection->photo) : ''
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
