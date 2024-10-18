<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\HomeProductCollection;
use App\Models\BrowseHistory;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Deal;
use App\Models\Shop;
use Illuminate\Http\Request;

class HomeCategoryController extends Controller
{
    public function homePageData($user_id = null)
    {
        $tyre_brands = DB::table('brand_datas')->where('brand_datas.type','tyre_brands')->leftJoin('uploads', 'uploads.id', '=', 'brand_datas.photo')->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS logo"))->orderBy('brand_datas.id', 'desc')->get()->toArray();
        $silders = DB::table('sliders')->leftJoin('uploads', 'uploads.id', '=', 'sliders.photo')->where('sliders.published', 1)->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS photo"), 'sliders.link')->get()->toArray();
        
        $promotion_products = new HomeProductCollection(Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type',
        'products.discount', 'products.rating', 'products.num_of_sale','products.category_id','products.quantity_1_price',
        'brand_datas.photo')->where('products.category_id', 1)
        ->where('products.published', 1)->where('products.featured', 1)->orderBy('products.id', 'desc')->limit(8)->get());
        
        $best_selling_products = new HomeProductCollection(Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type',
        'products.discount', 'products.rating', 'products.num_of_sale','products.category_id','products.quantity_1_price',
        'brand_datas.photo')->where('products.category_id', 1)
        ->where('products.published', 1)->orderBy('products.num_of_sale', 'desc')->limit(8)->get());
        
        $tyre_products = new HomeProductCollection(Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type',
        'products.discount', 'products.rating', 'products.num_of_sale','products.category_id','products.quantity_1_price',
        'brand_datas.photo')->where('products.category_id', 1)
        ->where('products.published', 1)->orderBy('products.num_of_sale', 'desc')->limit(8)->get());
       
        $service_products = new HomeProductCollection(Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type', 'products.discount',
        'products.rating', 'products.num_of_sale','products.category_id','brand_datas.photo')
        ->where('products.category_id', 4)->where('products.published', 1)->orderBy('products.num_of_sale', 'desc')->limit(8)->get());
        
        $batteries_products = DB::table('batteries as b')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'b.battery_brand_id')
        ->leftJoin('uploads', 'uploads.id', '=', 'b.attachment_id')
        ->leftJoin('uploads as battery_brand_img', 'battery_brand_img.id', '=', 'brand_datas.photo')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"),
        DB::raw("CONCAT('" . url('/') . "/public/', battery_brand_img.file_name) AS battery_brand_img"),
        'b.id as product_id', 'b.name', 'b.warranty', 'b.discount as discount', 'b.amount', "b.model")
        ->orderBy('b.id', 'desc')->limit(8)->get();
        $feedbacks  = DB::table('rating_orders')->join('users', 'users.id', 'rating_orders.user_id')->leftJoin('uploads', 'uploads.id', '=', 'users.avatar_original')->select('rating_orders.description', DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS avatar_original"), 'users.name', 'rating_orders.score as rating')->limit(8)->get()->toArray();
        $categories = DB::table('categories')
        ->leftJoin('uploads', 'uploads.id', '=', 'categories.icon')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS icon"), 'categories.name as cat_name')
        ->limit(4)
        ->get()
        ->toArray();

        $today_deals = Deal::where('type','today')->where('status', 1)->select('id' ,'start_date', 'end_date', 'text_color', 'banner')->get();
        $today_deals = $today_deals->map(function($today_deal){
             return[
                'id' => $today_deal->id,
                'title' => $today_deal->getTranslation('title'),
                'text_color' => $today_deal->text_color,
                'banner' => api_asset($today_deal->banner),
             ];
        });
        $shops = Shop::join('users', 'users.id', '=', 'shops.user_id')
                ->where('users.user_type', '=', 'seller')
                ->select('shops.name', 'shops.logo','shops.id', 'shops.rating')
                ->orderBy('shops.id', 'desc')->limit(8)->get();
        $shops_data = $shops->map(function($shop){
             return[
                'id' => $shop->id,
                'logo' => api_asset($shop->logo),
                'name' => $shop->name,
                'rating' => $shop->rating
             ];
        });
        $total = 0;
        $car_lists_arr = [];
        if ($user_id != null) {
            $total = DB::table('carts')->where('user_id', $user_id)->count();
            // all car lists
            $car_lists = DB::table('car_lists')
            ->leftJoin('brands', 'brands.id', '=', 'car_lists.brand_id')
            ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
            ->leftJoin('car_years', 'car_years.id', '=', 'car_lists.year_id')
            ->leftJoin('car_variants', 'car_variants.id', '=', 'car_lists.variant_id')
            ->select('brands.name as brand_name', 'car_models.name as model_name',
            'car_lists.brand_id', 'car_lists.model_id', 'car_lists.year_id', 'car_lists.variant_id',
            'car_lists.id', 'car_lists.image','car_lists.car_plate','car_years.name as year_name', 'car_variants.name as variant_name')
            ->where('car_lists.user_id', $user_id)
            ->orderBy('car_lists.id', 'desc')
            ->get();
            $car_lists_arr = $car_lists->map(function($list){
                return [
                    'id' => $list->id,
                    'car_plate' => $list->car_plate,
                    'brand_id' => $list->brand_id ? $list->brand_id : 0,
                    'model_id' => $list->model_id ? $list->model_id : 0,
                    'year_id' => $list->year_id ? $list->year_id : 0,
                    'variant_id' => $list->variant_id ? $list->variant_id : 0,
                    'brand_name' => $list->brand_name,
                    'model_name' => $list->model_name,
                    'year_name' => $list->year_name,
                    'variant_name' => $list->variant_name,
                    'image' => api_asset($list->image)
                ];
            });
        }

        return response()->json([
            'result' => true,
            'silders' => array('data' => $silders),
            'brands' => array('data' => $tyre_brands),
            'categories' => $categories,
            'feedbacks' => $feedbacks,
            'total_cart_items' => $total,
            'promotion_products' => $promotion_products,
            'best_selling_products' => $best_selling_products,
            'tyre_products' => $tyre_products,
            'service_products' => $service_products,
            'batteries_products' => $batteries_products,
            'total_notifications' => DB::table('notifications')->where('user_id', $user_id)->where('is_viewed', 0)->count(),
            'today_deals' => $today_deals,
            'shops' => $shops_data,
            'car_lists_arr' => $car_lists_arr
        ], 200);
    }

    public function show_deal_products($deal_id)
    {
        $deal_products_ids  = DB::table('deal_products')
        ->where('deal_id', $deal_id)
        ->get()->pluck('product_id')->toArray();
        $deal_products = new HomeProductCollection(Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type',
        'products.discount', 'products.rating', 'products.num_of_sale','products.category_id','products.quantity_1_price',
        'brand_datas.photo')
        ->whereIn('products.id', $deal_products_ids)
        ->where('products.published', 1)
        ->orderBy('products.num_of_sale', 'desc')
        ->get());
        return response()->json([
            'result' => true,
            'deal_products' => $deal_products,
        ], 200);
    }

    public function allFeedbacks()
    {
        $feedbacks  = DB::table('rating_orders')
            ->join('users', 'users.id', 'rating_orders.user_id')
            ->select('rating_orders.description', 'users.avatar_original', 'users.name')
            ->get();
        $feedbacks_arr = $feedbacks->map(function ($feedback) {
            return [
                'description'            => $feedback->description ? $feedback->description : '',
                'avatar_original'        => ($feedback->avatar_original) ? api_asset($feedback->avatar_original) : static_asset('assets/img/avatar-place.png'),
                'user_name'              => $feedback->name ? $feedback->name : '',
            ];
        });

        return response()->json([
            'result' => true,
            'feedbacks' => $feedbacks_arr
        ], 200);
    }

    public function viewAllProducts($type)
    {
        if ($type == 'promotion') {
            $products = Product::leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
            ->select('products.thumbnail_img', 'products.id', 'products.name', 'products.unit_price',
            'products.discount_start_date', 'products.discount_end_date',
            'products.discount_type', 'products.discount', 'products.rating', 'products.num_of_sale','products.category_id',
            'products.quantity_1_price','brand_datas.photo')
            ->where('products.category_id', 1)
            ->where('products.published', 1)
            ->where('products.featured', 1)
            ->orderBy('products.id', 'desc')
            ->paginate(20);
        }
        if ($type == 'best_selling') {
            $products = Product::leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
            ->select('products.thumbnail_img', 'products.id', 'products.name', 'products.unit_price',
            'products.discount_start_date', 'products.discount_end_date',
            'products.discount_type', 'products.discount', 'products.rating', 'products.num_of_sale','products.category_id',
            'products.quantity_1_price','brand_datas.photo')
            ->where('products.category_id', 1)
            ->where('products.published', 1)
            ->orderBy('products.num_of_sale', 'desc')
            ->paginate(20);
        }
        $products->getCollection()->transform(function ($product) {
            $home_discounted_base_price = home_discounted_base_price($product);
            $home_base_price = home_base_price($product);
            return [
                'id' => $product->id,
                'name' => $product->name ? $product->name : '',
                'thumbnail_image' => api_asset($product->thumbnail_img),
                'discount_price' => $home_discounted_base_price,
                'base_price' => $home_base_price,
                'has_discount' => $home_base_price != $home_discounted_base_price,
                'rating' => (float) $product->rating,
                'sales' => (int) $product->num_of_sale,
                'total_reviews' => 0,
                'tyre_size' => '',
                'brand_photo' => $product->photo ? api_asset($product->photo) : ''
            ];
        });

        return response()->json([
            'result' => true,
            'products' => $products
        ], 200);
    }
    
    public function aboutUsWebView()
    {
        $html = view('frontend.aboutus_webview')->render();
        return $html;
    }

    public function contactus_webview()
    {
        $html = view('frontend.contactus_webview')->render();
        return $html;
    }

    public function termsWebView()
    {
        $html = view('frontend.terms_webview')->render();
        return $html;
    }

    public function returnpolicyWebView()
    {
        $html = view('frontend.returnpolicy_webview')->render();
        return $html;
    }

    public function delivery_policy_webview()
    {
        $html = view('frontend.delivery_policy_webview')->render();
        return $html;
    }

    public function privacypolicyWebView()
    {
        $html = view('frontend.privacy_policy_webView')->render();
        return $html;
    }

    public function browsehistory_index($user_id)
    {
        $histories = BrowseHistory::where('user_id', $user_id)->select('product_id', 'product_type')->get();
        $tyre_products_ids = [];
        $service_products_ids = [];
        $battery_products_ids = [];
        foreach($histories as $history){
             if($history->product_type == 'battery'){
                array_push($battery_products_ids, $history->product_id);
             }
             else if($history->product_type == 'tyre'){
                array_push($tyre_products_ids, $history->product_id);
             }
             else{
                array_push($service_products_ids, $history->product_id);
             }
        }
        $tyre_products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type',
        'products.discount', 'products.rating', 'products.num_of_sale','products.category_id','products.quantity_1_price','brand_datas.photo')
        ->whereIn('products.id', $tyre_products_ids)
        ->orderBy('products.num_of_sale', 'desc')
        ->paginate(10)->appends(request()->query());

        $service_products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type', 'products.discount',
        'products.rating', 'products.num_of_sale','products.category_id','brand_datas.photo')
        ->whereIn('products.id', $service_products_ids)
        ->orderBy('products.num_of_sale', 'desc')
        ->paginate(10)->appends(request()->query());

        $battery_products = DB::table('batteries as b')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'b.battery_brand_id')
        ->leftJoin('uploads', 'uploads.id', '=', 'b.attachment_id')
        ->leftJoin('uploads as battery_brand_img', 'battery_brand_img.id', '=', 'brand_datas.photo')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"),
        DB::raw("CONCAT('" . url('/') . "/public/', battery_brand_img.file_name) AS battery_brand_img"),
        'b.id as product_id', 'b.name', 'b.warranty', 'b.discount as discount', 'b.amount', "b.model")
        ->orderBy('b.id', 'desc')
        ->whereIn('b.id', $battery_products_ids)
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
        return response()->json([    
            'result' => true,
            'tyre_products' => $tyre_products,
            'service_products' => $service_products,
            'battery_products' => $battery_products,
        ], 200);
    }

    public function browsehistory_delete(Request $request)
    {
        BrowseHistory::where('user_id', $request->user_id)->where('product_id', $request->product_id)->where('product_type', $request->type)->delete();
        return response()->json([    
            'result' => true,
            'message' => 'Item has been deleted successfully'
        ], 200);
    }
    
    public function browsehistory_delete_all($user_id)
    {
        DB::table('browse_histories')->where('user_id', $user_id)->delete();
        return response()->json([    
            'result' => true,
            'message' => 'Items has been deleted successfully'
        ], 200);
    }

    public function referrals(Request $request)
    {
        $referral_code = str_replace((env('APP_URL') . 'register?referral_code='), '', $request->referral_code);
        if (DB::table('users')->select('id')->where('id', $request->user()->id)->where('referred_by', NULL)->first()) {
            $user = DB::table('users')->select('id')->where('id', '!=', $request->user()->id)->where('referral_code', $referral_code)->first();
            if ($user) {
                DB::table('users')->where('id', $request->user()->id)->update([
                    'referred_by' => $user->id
                ]);
                return response()->json([    
                    'result' => true,
                    'message' => 'Referrals updated successfully'
                ], 200);
            } else {
                return response()->json([    
                    'result' => true,
                    'message' => 'Referrals code does not exists'
                ], 200);
            }
        } else {
            return response()->json([    
                'result' => true,
                'message' => 'Your referrals is already updated'
            ], 200);
        }
    }
}
