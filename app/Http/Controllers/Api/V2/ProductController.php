<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\ProductMiniCollection;
use App\Http\Resources\V2\ProductDetailCollection;
use App\Models\BrowseHistory;
use App\Models\Product;
use App\Models\SearchKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function show(Request $request, $id)
    {
        $product = Product::where('id', $id)->select('category_id')->first();
        if($product && $product->category_id == 1){
            $tyre_browse_histoy = DB::table('browse_histories')->where('user_id', $request->user_id)->where('product_id', $id)->where('product_type','tyre')->first();
            if(!$tyre_browse_histoy && $request->user_id != 0){
                $b_histoy = new BrowseHistory();
                $b_histoy->user_id = $request->user_id;
                $b_histoy->product_id = $id;
                $b_histoy->product_type = 'tyre';
                $b_histoy->save();
            }
        }
        else{
            $service_browse_histoy = DB::table('browse_histories')->where('user_id', $request->user_id)->where('product_id', $id)->where('product_type','service')->first();
            if(!$service_browse_histoy && $request->user_id != 0){
                $b_histoy = new BrowseHistory();
                $b_histoy->user_id = $request->user_id;
                $b_histoy->product_id = $id;
                $b_histoy->product_type = 'service';
                $b_histoy->save();
            }
        }

        $product = Product::
        join('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.id', $id)
        ->select('products.*','categories.name as category_name')
        ->get();
        return new ProductDetailCollection($product);
    }

    public function all_reviews(Request $request)
    {
        $reviews = [];
        if($request->type == 'tyre'){
            $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('users.name', 'reviews.rating', 'reviews.comment')
            ->where('reviews.product_id', $request->shop_id)
            ->where('reviews.status', 1)
            ->orderBy('reviews.id', 'desc')
            ->get();
        }
        else if($request->type == 'battery'){
            $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('users.name', 'reviews.rating', 'reviews.comment')
            ->where('reviews.battery_id', $request->shop_id)
            ->where('reviews.status', 1)
            ->orderBy('reviews.id', 'desc')
            ->get();
        }
        else if($request->type == 'shop'){
            if ($request->shop_type == 'carwash') {
                $shop = DB::table('car_wash_technicians as shops')->select('shops.user_id')->where('shops.id', $request->shop_id)->first();
                $reviews = DB::table('car_wash_usages')
                ->join('users', 'users.id', 'car_wash_usages.user_id')
                ->select('car_wash_usages.rating', 'car_wash_usages.review as comment', 'users.name')
                ->where('car_wash_usages.technician_id', $shop->user_id)
                ->orderBy('car_wash_usages.id', 'desc')
                ->get();
            } else {
                $reviews = DB::table('reviews')
                ->join('users', 'users.id', 'reviews.user_id')
                ->select('reviews.rating', 'reviews.comment', 'users.name')
                ->where('reviews.shop_id', $request->shop_id)
                ->orderBy('reviews.id', 'desc')
                ->get();
            }
        }
        else if($request->type == 'car_wash'){
            $reviews = DB::table('car_wash_usages')
            ->join('users', 'users.id', '=', 'car_wash_usages.user_id')
            ->select('users.name', 'car_wash_usages.rating', 'car_wash_usages.review as comment')
            ->where('car_wash_usages.car_wash_product_id', $request->shop_id)
            ->groupBy('car_wash_usages.user_id')
            ->get();
        }
        
        $reviews_arr = [];
        foreach ($reviews as $review) {
            $reviews_arr[] = array(
                'name' => $review->name,
                'rating' => number_format($review->rating, 1),
                'review' => $review->comment,
            );
        }
        return response()->json([
            'result' => true,
            'reviews' => $reviews_arr,
        ], 200);
    }

    public function related($id)
    {
        $product = Product::find($id);
        return new ProductMiniCollection(Product::where('category_id', $product->category_id)->where('id', '!=', $id)->limit(10)->get());
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $search_histoy = DB::table('search_keywords')->where('user_id', $request->user_id)->where('keyword', $name)->first();
        if(!$search_histoy && $request->user_id != 0 && $name != ''){
            $s_histoy = new SearchKeyword();
            $s_histoy->user_id = $request->user_id;
            $s_histoy->keyword = $name;
            $s_histoy->save();
        }

        $tyre_products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type',
        'products.discount', 'products.rating', 'products.num_of_sale','products.category_id','products.quantity_1_price','brand_datas.photo')
        ->where('products.category_id', 1)
        ->where('products.published', 1)
        ->where('products.name', 'like', '%' . $name . '%')
        ->orderBy('products.num_of_sale', 'desc')
        ->paginate(10)->appends(request()->query());

        $tyre_products->getCollection()->transform(function ($product) use($request){
            $home_discounted_base_price = home_discounted_base_price($product);
            $home_base_price = home_base_price($product);
            return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail_image' => $product->thumbnail_image,
                    'discount_price' => $home_discounted_base_price,
                    'base_price' => $home_base_price,
                    'has_discount' => ($home_base_price != $home_discounted_base_price),
                    'rating' => (float) $product->rating,
                    'sales' => (int) $product->num_of_sale,
                    'total_reviews' => 0,
                    'tyre_size' => '',
                    'brand_photo' => $product->photo ? api_asset($product->photo) : ''
                ];
        });

        $service_products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type', 'products.discount',
        'products.rating', 'products.num_of_sale','products.category_id','brand_datas.photo')
        ->where('products.category_id', 4)
        ->where('products.published', 1)
        ->where('products.name', 'like', '%' . $name . '%')
        ->orderBy('products.num_of_sale', 'desc')
        ->paginate(10)->appends(request()->query());

        $service_products->getCollection()->transform(function ($product) use($request){
            $home_discounted_base_price = home_discounted_base_price($product);
            $home_base_price = home_base_price($product);
            return [
                   'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail_image' => $product->thumbnail_image,
                    'discount_price' => $home_discounted_base_price,
                    'base_price' => $home_base_price,
                    'has_discount' => ($home_base_price != $home_discounted_base_price),
                    'rating' => (float) $product->rating,
                    'sales' => (int) $product->num_of_sale,
                    'total_reviews' => 0,
                    'tyre_size' => '',
                    'brand_photo' => $product->photo ? api_asset($product->photo) : ''
                ];
        });

        $battery_products = DB::table('batteries as b')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'b.battery_brand_id')
        ->leftJoin('uploads', 'uploads.id', '=', 'b.attachment_id')
        ->leftJoin('uploads as battery_brand_img', 'battery_brand_img.id', '=', 'brand_datas.photo')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"),
        DB::raw("CONCAT('" . url('/') . "/public/', battery_brand_img.file_name) AS battery_brand_img"),
        'b.id as product_id', 'b.name', 'b.warranty', 'b.discount as discount', 'b.amount', "b.model")
        ->orderBy('b.id', 'desc')
        ->where('b.name', 'like', '%' . $name . '%')
        ->paginate(10)->appends(request()->query());

        $battery_products->getCollection()->transform(function ($product) use($request){
            return [
                'attachment' => $product->attachment,
                'battery_brand_img' => $product->battery_brand_img,
                'product_id' => $product->product_id,
                'name' => $product->name,
                'warranty' => $product->warranty,
                'discount' => $product->discount,
                'amount' => $product->amount,
                'model' => $product->model
            ];
        });

        $search_keywords = DB::table('search_keywords')->where('user_id', $request->user_id)->select('keyword')->get()->toArray();
        return response()->json([
            'result' => true,
            'tyre_products' => $tyre_products,
            'service_products' => $service_products,
            'battery_products' => $battery_products,
            'search_keywords' => $search_keywords
        ], 200);
    }

    public function search_first_page($user_id)
    {
        $tyre_products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type',
        'products.discount', 'products.rating', 'products.num_of_sale','products.category_id','products.quantity_1_price','brand_datas.photo')
        ->where('products.category_id', 1)
        ->where('products.published', 1)
        ->orderBy('products.num_of_sale', 'desc')
        ->paginate(10)->appends(request()->query());

        $tyre_products->getCollection()->transform(function ($product) {
            $home_discounted_base_price = home_discounted_base_price($product);
            $home_base_price = home_base_price($product);
            return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail_image' => $product->thumbnail_image,
                    'discount_price' => $home_discounted_base_price,
                    'base_price' => $home_base_price,
                    'has_discount' => ($home_base_price != $home_discounted_base_price),
                    'rating' => (float) $product->rating,
                    'sales' => (int) $product->num_of_sale,
                    'total_reviews' => 0,
                    'tyre_size' => '',
                    'brand_photo' => $product->photo ? api_asset($product->photo) : ''
                ];
        });

        $service_products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type', 'products.discount',
        'products.rating', 'products.num_of_sale','products.category_id','brand_datas.photo')
        ->where('products.category_id', 4)
        ->where('products.published', 1)
        ->orderBy('products.num_of_sale', 'desc')
        ->paginate(10)->appends(request()->query());

        $service_products->getCollection()->transform(function ($product) {
            $home_discounted_base_price = home_discounted_base_price($product);
            $home_base_price = home_base_price($product);
            return [
                   'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail_image' => $product->thumbnail_image,
                    'discount_price' => $home_discounted_base_price,
                    'base_price' => $home_base_price,
                    'has_discount' => ($home_base_price != $home_discounted_base_price),
                    'rating' => (float) $product->rating,
                    'sales' => (int) $product->num_of_sale,
                    'total_reviews' => 0,
                    'tyre_size' => '',
                    'brand_photo' => $product->photo ? api_asset($product->photo) : ''
                ];
        });

        $battery_products = DB::table('batteries as b')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'b.battery_brand_id')
        ->leftJoin('uploads', 'uploads.id', '=', 'b.attachment_id')
        ->leftJoin('uploads as battery_brand_img', 'battery_brand_img.id', '=', 'brand_datas.photo')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"),
        DB::raw("CONCAT('" . url('/') . "/public/', battery_brand_img.file_name) AS battery_brand_img"),
        'b.id as product_id', 'b.name', 'b.warranty', 'b.discount as discount', 'b.amount', "b.model")
        ->orderBy('b.id', 'desc')
        ->paginate(10)->appends(request()->query());

        $battery_products->getCollection()->transform(function ($product) {
            return [
                'attachment' => $product->attachment,
                'battery_brand_img' => $product->battery_brand_img,
                'product_id' => $product->product_id,
                'name' => $product->name,
                'warranty' => $product->warranty,
                'discount' => $product->discount,
                'amount' => $product->amount,
                'model' => $product->model
            ];
        });

        $search_keywords = DB::table('search_keywords')->where('user_id', $user_id)->select('keyword')->get()->toArray();
        return response()->json([
            'result' => true,
            'tyre_products' => $tyre_products,
            'service_products' => $service_products,
            'battery_products' => $battery_products,
            'search_keywords' => $search_keywords
        ], 200);
    }

    public function delete_search_history($user_id)
    {
        DB::table('search_keywords')->where('user_id', $user_id)->delete();
        return response()->json([
            'result' => true,
        ], 200);
    }

}
