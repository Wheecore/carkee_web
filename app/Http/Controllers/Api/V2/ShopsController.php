<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopsController extends Controller
{
    public function shops(Request $request)
    {
        $data['shops'] = [];
        $type = '';
        if ($request->category_id == 'carwash') {
            $type = 'carwash';
            $shops = DB::table('car_wash_technicians as shops')
                ->leftJoin('uploads', 'uploads.id', '=', 'shops.logo')
                ->leftJoin('users', 'users.id', '=', 'shops.user_id')
                ->where('users.banned', 0)
                ->select('shops.id', 'shops.user_id', 'shops.name', 'shops.address', 'shops.longitude', 'shops.latitude', 'shops.rating', DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"))
                ->get()->toArray();
        } else {
            $type = 'shop';
            $shops = DB::table('shops')
                ->leftJoin('uploads', 'uploads.id', '=', 'shops.logo')
                ->leftJoin('users', 'users.id', '=', 'shops.user_id')
                ->where('users.banned', 0)
                ->select('shops.id', 'shops.user_id', 'shops.name', 'shops.address', 'shops.longitude', 'shops.latitude', 'shops.rating', DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"))
                ->when($request->category_id, function ($q) {
                    return $q->whereJsonContains('shops.category_id', request('category_id'));
                })
                ->get()->toArray();
        }
        $radius = $request->radius ?? 25;
        $distance_flag = false;
        if ($request->address && $request->latitude && $request->longitude) {
            $distance_flag = true;
        }
        foreach ($shops as $shop) {
            $distance = round(distance($shop->latitude, $shop->longitude, $request->latitude, $request->longitude, 'K'), 2);
            if ($distance_flag) {
                if ($distance <= 50) {
                    if ($distance <= $radius) {
                        $data['shops'][] = array(
                            'type' => $type,
                            'id' => $shop->id,
                            'user_id' => $shop->user_id,
                            'name' => $shop->name,
                            'address' => $shop->address,
                            'rating' => $shop->rating,
                            'attachment' => $shop->attachment,
                            'distance' => $distance,
                        );
                    }
                }
            } else {
                $data['shops'][] = array(
                    'type' => $type,
                    'id' => $shop->id,
                    'user_id' => $shop->user_id,
                    'name' => $shop->name,
                    'address' => $shop->address,
                    'rating' => $shop->rating,
                    'attachment' => $shop->attachment,
                    'distance' => $distance,
                );
            }
        }
        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function shop_details(Request $request)
    {
        $data['shop'] = [];
        $data['reviews'] = [];
        if ($request->type == 'carwash') {
            $shop = DB::table('car_wash_technicians as shops')->leftJoin('uploads', 'uploads.id', '=', 'shops.logo')->select('shops.id', 'shops.user_id', 'shops.name', 'shops.address', 'shops.longitude', 'shops.latitude', 'shops.rating', DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"), 'shops.description')->where('shops.id', $request->id)->first();
            $reviews = DB::table('car_wash_usages')->join('users', 'users.id', 'car_wash_usages.user_id')->select('car_wash_usages.rating', 'car_wash_usages.review as comment', 'users.name')->where('car_wash_usages.technician_id', $shop->user_id)->orderBy('car_wash_usages.id', 'desc')->limit(4)->get()->toArray();
        } else {
            $shop = DB::table('shops')->leftJoin('uploads', 'uploads.id', '=', 'shops.logo')->select('shops.id', 'shops.user_id', 'shops.name', 'shops.address', 'shops.longitude', 'shops.latitude', 'shops.rating', 'shops.category_id', DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"), 'description')->where('shops.id', $request->id)->first();
            $reviews = DB::table('reviews')->join('users', 'users.id', 'reviews.user_id')->select('reviews.rating', 'reviews.comment', 'users.name')->where('reviews.shop_id', $request->id)->orderBy('reviews.id', 'desc')->limit(4)->get()->toArray();
        }
        foreach ($reviews as $review) {
            $data['reviews'][] = array(
                'name' => $review->name,
                'rating' => number_format($review->rating, 1),
                'review' => $review->comment,
            );
        }
        $data['shop'] = array(
            'type' => $request->type,
            'id' => $shop->id,
            'user_id' => $shop->user_id,
            'services' => (isset($shop->category_id) ? (implode(', ', json_decode($shop->category_id))) : 'carwash'),
            'name' => $shop->name,
            'address' => $shop->address,
            'rating' => $shop->rating,
            'attachment' => $shop->attachment,
            'description' => $shop->description,
            'distance' => round(distance($shop->latitude, $shop->longitude, $request->latitude, $request->longitude, 'K'), 2),
        );
        return response()->json(['data' => $data, 'status' => 200], 200);
    }
}
