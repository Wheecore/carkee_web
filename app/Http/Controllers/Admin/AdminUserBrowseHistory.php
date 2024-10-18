<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrowseHistory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminUserBrowseHistory extends Controller
{
    function index($id)
    {
        $type = null;
        $histories = BrowseHistory::where('user_id', $id)->select('product_id', 'product_type')->get();
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
        $s_pageNumber = 0;
        $t_pageNumber = 0;
        $b_pageNumber = 0;
        if(request()->type == 'service'){
            $type = 'service';
            $s_pageNumber = request()->page;
        }
        else if(request()->type == 'tyre'){
            $type = 'tyre';
            $t_pageNumber = request()->page;
        }
        else if(request()->type == 'battery'){
            $type = 'battery';
            $b_pageNumber = request()->page;
        }
        $tyre_products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type',
        'products.discount', 'products.rating', 'products.num_of_sale','products.category_id','products.quantity_1_price','brand_datas.photo')
        ->whereIn('products.id', $tyre_products_ids)
        ->orderBy('products.num_of_sale', 'desc')
        ->paginate(10, ['*'],'tyre_page', $t_pageNumber)->appends(request()->query());

        $service_products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'products.tyre_service_brand_id')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'products.id', 'products.name',
        'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount_type', 'products.discount',
        'products.rating', 'products.num_of_sale','products.category_id','brand_datas.photo')
        ->whereIn('products.id', $service_products_ids)
        ->orderBy('products.num_of_sale', 'desc')
        ->paginate(10, ['*'],'service_page', $s_pageNumber)->appends(request()->query());

        $battery_products = DB::table('batteries as b')
        ->leftJoin('brand_datas', 'brand_datas.id', '=', 'b.battery_brand_id')
        ->leftJoin('uploads', 'uploads.id', '=', 'b.attachment_id')
        ->leftJoin('uploads as battery_brand_img', 'battery_brand_img.id', '=', 'brand_datas.photo')
        ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"),
        DB::raw("CONCAT('" . url('/') . "/public/', battery_brand_img.file_name) AS battery_brand_img"),
        'b.id as product_id', 'b.name', 'b.warranty', 'b.discount as discount', 'b.amount', "b.model", 'b.rating')
        ->orderBy('b.id', 'desc')
        ->whereIn('b.id', $battery_products_ids)
        ->paginate(10, ['*'],'battery_page', $b_pageNumber)->appends(request()->query());
        
        return view('backend.user_browse_history', compact('tyre_products', 'service_products', 'battery_products', 'type'));
    }
}
