<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\CarWashMembership;
use App\Models\CarWashPayment;
use App\Models\CarWashTechnician;
use App\Models\CarWashUsage;
use App\Models\Deal;
use App\Models\DealProduct;
use App\Models\Order;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\V2\CheckoutController;
use App\Models\GiftCode;
use App\Models\GiftCodeUsage;
use App\Models\Notification;
use App\Models\Wallet;
use App\User;

class CarWashesController extends Controller
{
    public function list_car_wash_products(Request $request)
    {
        $data['active_packages'] = [];
        $category_id = request('category_id') ?? 'all';

        // active packages
        // $active_packages = DB::table('car_wash_payments as cwp')
        //     ->join('car_wash_products', 'car_wash_products.id', '=', 'cwp.car_wash_product_id')
        //     ->leftJoin('uploads', 'uploads.id', '=', 'car_wash_products.upload_id')
        //     ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS image"), 'car_wash_products.name', 'car_wash_products.type', 'cwp.id', 'cwp.usage_limit', 'cwp.used_usage_limit')
        //     ->where('car_wash_products.category_id', '!=', 4)
        //     ->where('cwp.user_id', $user_id)
        //     ->where('cwp.carlist_id', $request->car_id)
        //     ->whereRaw('cwp.usage_limit > cwp.used_usage_limit')
        //     ->get();

        // foreach ($active_packages as $package) {
        //     $data['active_packages'][] = array(
        //         "id" => $package->id,
        //         "type" => implode(', ', (json_decode($package->type) ?? [])),
        //         "name" => $package->name,
        //         "image" => $package->image,
        //         "usage_limit" => $package->usage_limit,
        //         "used_usage_limit" => $package->used_usage_limit
        //     );
        // }

        // car list
        $carlist = DB::table('car_lists')
            ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
            ->where('car_lists.id', $request->car_id)
            ->select('car_lists.user_id', 'car_lists.car_plate', 'car_models.type')
            ->first();

        $user_id = $carlist->user_id;

        if ($carlist) {
            $check_membership = DB::table('car_wash_memberships')
                ->select('id')
                ->where('user_id', $user_id)
                ->where('car_plate', $carlist->car_plate)
                ->first();
        }

        $skip_ids = [];
        $car_wash_deals = Deal::where('type', 'car_wash')->where('status', 1)->select('id', 'start_date', 'end_date', 'text_color', 'banner')->get();
        // $data['car_wash_deals'] = [];
        foreach ($car_wash_deals as $deal) {
            $records = DealProduct::where('deal_id', $deal->id)->get()->pluck('product_id')->toArray();
            $skip_ids = array_merge($skip_ids, $records);
            // $data['car_wash_deals'][] = [
            //     'id' => $deal->id,
            //     'title' => $deal->getTranslation('title'),
            //     'text_color' => $deal->text_color,
            //     'banner' => api_asset($deal->banner)
            // ];
        }

        // products
        $data['products'] = DB::table('car_wash_products')
            ->leftJoin('car_wash_categories', 'car_wash_categories.id', '=', 'car_wash_products.category_id')
            ->leftJoin('uploads', 'uploads.id', '=', 'car_wash_products.upload_id')
            ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS image"), 'car_wash_products.id', 'car_wash_products.category_id', 'car_wash_products.name', 'car_wash_products.description', 'car_wash_products.ptype', 'car_wash_products.amount', 'car_wash_products.membership_fee', 'car_wash_products.usage_limit', 'car_wash_categories.color_code as color')
            ->when(($category_id != 'all' && $category_id != 0), function ($q) use ($category_id) {
                return $q->where('category_id', $category_id);
            })
            // ->when(isset($check_membership), function ($q) {
            //     return $q->where('car_wash_products.ptype', '!=', 'M');
            // })
            ->whereJsonContains('car_wash_products.type', $carlist->type)
            ->whereNotIn('car_wash_products.id', $skip_ids)
            ->get()
            ->toArray();

        $data['membership'] = (isset($check_membership) && $check_membership) ? true : false;
        // categories
        $data['categories'][] = array('id' => 0, 'name' => 'All');
        $categories = DB::table('car_wash_categories')->select('id', 'name')->get()->toArray();
        foreach ($categories as $category) {
            // if ($category->name == 'Membership' && isset($check_membership)) {
            //     continue;
            // }
            $data['categories'][] = $category;
        }

        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function show_carwash_deal_products(Request $request)
    {
        // car list
        $carlist = DB::table('car_lists')
            ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
            ->where('car_lists.id', $request->car_id)
            ->select('car_models.type','car_lists.user_id','car_lists.car_plate')
            ->first();
        if ($carlist) {
            $check_membership = DB::table('car_wash_memberships')
            ->select('id')
            ->where('user_id', $carlist->user_id)
            ->where('car_plate', $carlist->car_plate)
            ->first();
        }
        $deal_products_ids  = DB::table('deal_products')
        ->where('deal_id', $request->deal_id)
        ->get()->pluck('product_id')->toArray();
        $deal_products = DB::table('car_wash_products as cwp')
            ->leftJoin('car_wash_categories', 'car_wash_categories.id', '=', 'cwp.category_id')
            ->leftJoin('uploads', 'uploads.id', '=', 'cwp.upload_id')
            ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS image"), 'cwp.id', 'cwp.category_id', 'cwp.name', 'cwp.description', 'cwp.ptype', 'cwp.amount', 'cwp.membership_fee', 'cwp.usage_limit', 'car_wash_categories.color_code as color')
            ->whereJsonContains('cwp.type', $carlist->type)
            ->whereIn('cwp.id', $deal_products_ids)
            ->when(isset($check_membership), function ($q) {
                return $q->where('cwp.ptype', '!=', 'M');
            })
            ->get()->toArray();
        return response()->json([
            'result' => true,
            'deal_products' => $deal_products,
        ], 200);
    }

    public function car_wash_product_details(Request $request)
    {
        $carlist = DB::table('car_lists')
            ->select('car_plate','user_id')
            ->where('id', $request->car_id)
            ->first();

        // one-time if membership give 20% discount
        $active_package = DB::table('car_wash_products')
            ->leftJoin('car_wash_categories', 'car_wash_categories.id', '=', 'car_wash_products.category_id')
            ->leftJoin('uploads', 'uploads.id', '=', 'car_wash_products.upload_id')
            ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS image"), 'car_wash_products.id',
            'car_wash_products.name', 'car_wash_products.type', 'car_wash_products.ptype', 'car_wash_products.description',
            'car_wash_products.amount', 'car_wash_products.membership_fee', 'car_wash_products.usage_limit',
            'car_wash_products.warranty', 'car_wash_categories.color_code as color')
            ->where('car_wash_products.id', $request->id)
            ->first();

        $user_id = $carlist->user_id;
        // check membership
        // $discount = 0;
        $membership_fee = $active_package->membership_fee;

        $check_membership = DB::table('car_wash_memberships')
            ->select('id')
            ->where('user_id', $user_id)
            ->where('car_plate', $carlist->car_plate)
            // ->when($active_package->ptype != 'M', function ($q) use ($carlist) {
            //     return $q->where('car_plate', $carlist->car_plate);
            // })
            ->first();
        $membership_status = (isset($check_membership) && $check_membership) ? true : false;
        // if ($membership_status) {
            // $membership_fee = 0;
            // if ($active_package->ptype == 'O') {
                // $discount = round(($active_package->amount * env('CAR_WASH_DISCOUNT') / 100));
            // }
            // elseif ($active_package->ptype == 'M') {
            //     $membership_fee = round($active_package->membership_fee * 50 / 100);
            // }
        // }

        $data['active_package'] = array(
            "id" => $active_package->id,
            "name" => $active_package->name,
            "type" => implode(', ', (json_decode($active_package->type) ?? [])),
            "description" => $active_package->description,
            // "discount" => $discount,
            "amount" => $active_package->amount,
            "image" => $active_package->image,
            "ptype" => $active_package->ptype,
            "membership_fee" => $membership_fee,
            "usage_limit" => $active_package->usage_limit,
            "warranty" => $active_package->warranty
        );
        $reviews = DB::table('car_wash_usages')->leftJoin('users', 'users.id', '=', 'car_wash_usages.user_id')
        ->select('users.name', 'car_wash_usages.rating', 'car_wash_usages.review')
        ->where('car_wash_usages.car_wash_product_id', $request->id)
        ->groupBy('car_wash_usages.user_id')->get()->toArray();
        $data['reviews'] = [];
        foreach ($reviews as $review) {
            $data['reviews'][] = array(
                'name' => $review->name,
                'rating' => number_format($review->rating, 1),
                'review' => $review->review,
            );
        }
        $data['check_membership'] = $membership_status;
        $data['membership_discount'] = env('CAR_WASH_DISCOUNT');

        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function car_wash_checkout(Request $request)
    {
        $orderController = new OrderController;
        $response = $orderController->carWashOrderstore($request);
        if($response['issue'] == 'yes'){
            return response()->json([
                'result' => false,
                'message' => $response['message'],
            ], 401);
        }
        return response()->json([
            'result' => true,
            'url' => url('api/v2/carwash-success-webview/'.$response['order_id'])
        ]);
    }

    public function carwash_success_view($order_id)
    {
        $obj = array(
            'status' => 'Success'
        );
        $checkoutController = new CheckoutController;
        $checkoutController->checkout_done($order_id, json_encode($obj));
        $order = Order::find($order_id);
        return view('frontend.order_invoice', compact('order'));  
    }

    public function car_wash_order_summary(Request $request)
    {
        $data['product'] = DB::table('car_wash_payments as cwp')
            ->join('car_wash_products', 'car_wash_products.id', '=', 'cwp.car_wash_product_id')
            ->select('cwp.id', 'car_wash_products.name', 'cwp.car_plate', 'cwp.model_name', 'cwp.date_slot', 'cwp.time_slot', 'users.name')
            ->where('cwp.id', $request->id)->first();
        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function carWashActiveSubscriptions(Request $request)
    {
        $payments = DB::table('car_wash_payments')
            ->select('id', 'usage_limit', 'warranty', 'used_usage_limit', 'car_plate', 'model_name', 'updated_at')
            ->where('user_id', $request->user_id)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
        $subscriptions = [];
        $subscription_list = [];
        foreach ($payments as $payment) {
            if ($payment->warranty > 0) {
                $date = date("Y-m-d", strtotime("+" . $payment->warranty . " years", strtotime($payment->updated_at)));
                if (strtotime(date('Y-m-d')) <= strtotime($date)) {
                    $warranty = translate('You warranty will expire on ' . $date);
                } else {
                    $warranty = translate('You warranty has expired');
                }
            } else {
                $warranty = '';
            }
            $payment_arr = [
                'id' => $payment->id,
                'usage_limit' => $payment->usage_limit,
                'used_usage_limit' => $payment->used_usage_limit,
                'warranty' => $warranty,
                'car_plate' => $payment->car_plate,
                'model_name' => $payment->model_name,
            ];
            $subscriptions[$payment->model_name]['model'] = $payment->model_name;
            $subscriptions[$payment->model_name]['list'][] = $payment_arr;
        }
        foreach ($subscriptions as $subscription) {
            $subscription_list[] = $subscription;
        }

        return response()->json(['data' => $subscription_list, 'status' => 200], 200);
    }

    public function carWashActiveSubscriptionDetails(Request $request)
    {
        $payment = DB::table('car_wash_payments')
            ->select('id', 'usage_limit', 'used_usage_limit', 'car_plate', 'model_name')
            ->where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->where('status', 1)
            ->first();
        return response()->json(['data' => $payment, 'status' => 200], 200);
    }

    public function carwash_membership_screen(Request $request)
    {
        $carlist = DB::table('car_lists')
        ->select('user_id', 'car_plate')
        ->where('id', $request->car_id)
        ->first();
        $user_id = $carlist->user_id;

        $check_membership = DB::table('car_wash_memberships')
        ->select('id')
        ->where('user_id', $user_id)
        ->where('car_plate', $carlist->car_plate)
        ->first();
        if($check_membership){
            return response()->json(['result' => false, 'message' => 'This car has already purchased the memberhsip'], 200);
        }
        else{
            $data = array(
                "membership_fee" => format_price(env('MEMBERSHIP_AMOUNT')),
                "membership_discount" => env('CAR_WASH_DISCOUNT').'%'
            );
            return response()->json(['result' => true, 'data' => $data], 200);
        }
    }

    public function carwash_checkout_membership(Request $request)
    {
        $carlist = DB::table('car_lists')
        ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
        ->select('car_lists.user_id', 'car_models.name as model', 'car_lists.car_plate')
        ->where('car_lists.id', $request->car_id)
        ->first();

        $membership_fee = env('MEMBERSHIP_AMOUNT');
        $user = DB::table('users')->where('id', $carlist->user_id)->select('id','name','balance')->first();
        if($membership_fee > $user->balance){  
            return response()->json(['result' => false, 'message' => 'Your wallet balance is not enough to complete this. Please recharge your wallet first'], 200);    
        }
        $car_wash_memberships = new CarWashMembership();
        $car_wash_memberships->user_id = $carlist->user_id;
        $car_wash_memberships->car_plate = $carlist->car_plate;
        $car_wash_memberships->amount = $membership_fee;
        $car_wash_memberships->save();

        // Add record to wallet
        $obj = array(
            'status' => 'Success'
        );
        $wallet = new Wallet();
        $wallet->user_id = $carlist->user_id;
        $wallet->charge_by = $carlist->user_id;
        $wallet->amount = $membership_fee;
        $wallet->payment_method = 'wallet';
        $wallet->payment_details = json_encode($obj);
        $wallet->type = 'deduct';
        $wallet->remarks = 'Membership purchased for vehicle '.$carlist->car_plate;
        $wallet->save();

        // decrease user wallet balance
        $user = DB::table('users')->where('id', $carlist->user_id)->decrement('balance', $membership_fee);

        return response()->json([
            'result' => true,
            'message' => 'Membership has been purchased successfully!!'
        ]);
    }

    public function carWashActiveSubscriptionValidated(Request $request)
    {
        $payment = CarWashPayment::find($request->id);
        if ($payment) {
            if (DB::table('car_wash_usages')->where('carlist_id', $payment->carlist_id)->where('user_id', $request->user_id)->whereDate('created_at', date('Y-m-d'))->count() == 2) {
                return response()->json(['data' => array('msg' => translate('You have washed the car 2 times a day please come tomorrow')), 'status' => 404], 200);
            } else {
                if ($payment) {
                    if ($payment->status != 2) {
                        if (($payment->used_usage_limit + 1) == $payment->usage_limit) {
                            $payment->status = 2;
                        }
                        $payment->used_usage_limit = $payment->used_usage_limit + 1;
                        $payment->technician_id = $payment->technician_id;
                        $payment->save();

                        // Usage Log
                        $car_wash_usage = new CarWashUsage();
                        $car_wash_usage->carlist_id = $payment->carlist_id;
                        $car_wash_usage->car_wash_payment_id = $payment->id;
                        $car_wash_usage->car_wash_product_id = $payment->car_wash_product_id;
                        $car_wash_usage->user_id = $request->user_id;
                        $car_wash_usage->technician_id = $request->technician_id;
                        $car_wash_usage->save();

                        return response()->json(['data' => array('msg' => translate('Successfully validated')), 'status' => 200], 200);
                    } else {
                        return response()->json(['data' => array('msg' => translate('Maximum usage limit reached')), 'status' => 422], 200);
                    }
                } else {
                    return response()->json(['data' => array('msg' => translate('No record found')), 'status' => 404], 200);
                }
            }
        } else {
            return response()->json(['data' => array('msg' => translate('No record found')), 'status' => 404], 200);
        }
    }

    /* 
    *   Car Wash Technicians
    */
    public function dashboard($id)
    {
        $type = request('type');
        $data['usages'] = DB::table('car_wash_usages as wu')
            // ->join('users as u', 'u.id', '=', 'wu.user_id')
            ->join('car_wash_payments as p', 'p.id', 'wu.car_wash_payment_id')
            ->leftJoin('car_wash_products as wp', 'wp.id', 'p.car_wash_product_id')
            // 'wp.name as product', 'u.name', 'u.email', 
            ->select('wu.id', 'p.car_plate', 'p.model_name', 'wu.created_at')
            ->orderBy('wu.created_at', 'desc')
            ->where('wu.technician_id', $id)
            ->when($type && $type != null, function ($q) use ($type) {
                return $q->where('wp.ptype', $type);
            })
            ->paginate(40);

        $data['total_one_time'] = 0;
        $data['total_subscriptions'] = 0;
        // $data['total_one_time'] = DB::table('car_wash_usages')
        //     ->leftJoin('car_wash_products as wp', 'wp.id', '=', 'car_wash_usages.car_wash_product_id')
        //     ->where('wp.ptype', 'O')
        //     ->where('car_wash_usages.technician_id', $id)
        //     ->count();
        // $data['total_subscriptions'] = DB::table('car_wash_usages')
        //     ->leftJoin('car_wash_products as wp', 'wp.id', '=', 'car_wash_usages.car_wash_product_id')
        //     ->where('wp.ptype', 'S')
        //     ->where('car_wash_usages.technician_id', $id)
        //     ->count();
        $data['type'] = $type;
        return response()->json([
            'result' => true,
            'data' => $data
        ]);
    }

    public function car_wash_profile_data(Request $request)
    {
        $technician = CarWashTechnician::where('user_id', $request->user_id)->first();
        return response()->json([
            'result' => true,
            'name' => $technician->name,
            'logo' => $technician->logo ? api_asset($technician->logo) : '',
            'address' => $technician->address,
            'longitude' => $technician->longitude,
            'latitude' => $technician->latitude,
            'description' => $technician->description,
        ]);
    }

    public function car_wash_profile(Request $request)
    {
        $technicians = CarWashTechnician::where('user_id', $request->user_id)->first();
        $logo = ($technicians) ? $technicians->logo : 0;
        if ($request->hasfile('logo')) {
            $type = array(
                "jpg" => "image",
                "jpeg" => "image",
                "png" => "image",
                "svg" => "image",
                "webp" => "image",
                "gif" => "image",
            );
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            if (!isset($type[$extension])) {
                return response()->json([
                    'result' => false,
                    'message' => translate('Only image can be uploaded')
                ]);
            }
            $dir = public_path('uploads/all/');
            $filename = str_replace(" ", "-", (date("YmdHis") . $file->getClientOriginalName()));
            $upload = new Upload();
            $size = $file->getSize();
            $file->move($dir, $filename);

            $upload->file_original_name = 'car_image';
            $upload->extension = $extension;
            $upload->file_name = 'uploads/all/' . $filename;
            $upload->user_id = $request->user_id;
            $upload->type = $type[$upload->extension];
            $upload->file_size = $size;
            $upload->save();
            $logo = $upload->id;
        }
        $technicians->name = $request->name;
        $technicians->logo = $logo;
        $technicians->address = $request->address;
        $technicians->longitude = $request->longitude;
        $technicians->latitude = $request->latitude;
        $technicians->description = $request->description;
        $technicians->save();
        return response()->json([
            'result' => true,
            'data' => $technicians,
            'msg' => translate('Profile updated successfully')
        ]);
    }

    public function usage_detail(Request $request)
    {
        $usage = DB::table('car_wash_usages as wu')
            ->join('users as u', 'u.id', '=', 'wu.user_id')
            ->join('car_wash_payments as p', 'p.id', 'wu.car_wash_payment_id')
            ->leftJoin('car_wash_products as wp', 'wp.id', 'p.car_wash_product_id')
            ->select('wu.id', 'u.name', 'u.email', 'wp.name as product', 'p.car_plate', 'p.model_name', 'wu.rating', 'wu.review', 'wu.created_at')
            ->where('wu.id', $request->id)
            ->first();
        return response()->json([
            'result' => true,
            'usage' => $usage
        ]);
    }

    public function usage_review(Request $request)
    {
        $car_wash_usage = CarWashUsage::find($request->id);
        $car_wash_usage->rating = $request->rating;
        $car_wash_usage->review = $request->review;
        $car_wash_usage->save();

        $car_wash = CarWashTechnician::where('user_id', $car_wash_usage->technician_id)->first();
        $car_wash->rating = (DB::table('car_wash_usages')->where('technician_id', $car_wash_usage->technician_id)->sum('rating') / DB::table('car_wash_usages')->where('technician_id', $car_wash_usage->technician_id)->count());
        $car_wash->update();

        return response()->json([
            'result' => true
        ]);
    }

    public function get_user_vehicles(Request $request)
    {
        // logged user byself
        $members = [];
        $members[] = (integer) $request->user_id;
        // getting parent of login user if have
        $login_user = DB::table('users')->where('id', $request->user_id)->select('parent_id')->first();
        if($login_user->parent_id){
          $members[] = $login_user->parent_id;
        }
        // getting childs of login user
        $childs = DB::table('users')->where('parent_id', $request->user_id)->select('id')->get();
        foreach($childs as $child){
            $members[] = $child->id;
        }
       $members = collect($members);
       
    $data = $members->map(function($member) use($request){
        $member_data = DB::table('users')->where('id', $member)->select('name','balance')->first();

        $car_lists = DB::table('car_lists')
        ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
        ->leftJoin('brands', 'brands.id', '=', 'car_lists.brand_id')
        ->leftJoin('car_years', 'car_years.id', '=', 'car_lists.year_id')
        ->leftJoin('car_variants', 'car_variants.id', '=', 'car_lists.variant_id')
        ->select('car_lists.id', 'brands.name as brand', 'car_models.name as model', 'car_years.name as year',
       'car_variants.name as variant', 'car_lists.car_plate', 'car_lists.image')
       ->where('car_lists.user_id', $member)
       ->orderBy('car_lists.id', 'desc')
       ->get();
       
       $login_user_data = DB::table('users')->where('id', $request->user_id)->select('name')->first();
       
       return [
            'user_name' => ($login_user_data->name == $member_data->name)?'Your Vehicles':$member_data->name,
            'available_balance' => format_price($member_data->balance),
            'car_lists' => $car_lists->map(function($carlist) use($member){
            $check_membership = DB::table('car_wash_memberships')
            ->select('id')
            ->where('user_id', $member)
            ->where('car_plate', $carlist->car_plate)
            ->first();
             return[
                  'id' => $carlist->id,
                   'car_plate' => $carlist->car_plate,
                   'brand_name' => $carlist->brand,
                   'model_name' => $carlist->model,
                   'year_name' => $carlist->year,
                   'variant_name' => $carlist->variant,
                   'image' => api_asset($carlist->image),
                   'is_membership' => (isset($check_membership) && $check_membership) ? true : false,  
            ];    
            }),
            ];
       });

    return response()->json([
        'result' => true,
        'data' => $data
    ]);
    }

    public function verify_gift_code(Request $request)
    {
        $coupon = DB::table('gift_codes')->where('code', $request->code)->where('type', 'car_wash')->first();
        if ($coupon == null) {
            return response()->json([
                'result' => false,
                'message' => 'Invalid gift code!'
            ]);
        }
        $coupon_is_used = GiftCodeUsage::where('gift_code_id',$coupon->id)->whereNotNull('redeem_by')->first();
        if ($coupon_is_used != null) {
            return response()->json([
                'result' => false,
                'message' => 'Sorry! this gift code is already used one time!'
            ]);
        }
        $in_range = strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date;

        if (!$in_range) {
            return response()->json([
                'result' => false,
                'message' => 'Gift code expired!'
            ]);
        }

        $record_update = GiftCodeUsage::where('gift_code_id', $coupon->id)->first();
        if($record_update){
            $record_update->redeem_by = $request->user_id;
            $record_update->redeem_date = now();
            $record_update->update();
        }
        else{
            $new_data = new GiftCodeUsage();
            $new_data->gift_code_id = $coupon->id;
            $new_data->redeem_by = $request->user_id;
            $new_data->redeem_date = now();
            $new_data->save();
        }

        $obj = array(
            'status' => 'Success',
        );

        $wallet = new Wallet();
        $wallet->user_id = $request->user_id;
        $wallet->charge_by = $request->user_id;
        $wallet->amount = $coupon->discount_amount;
        $wallet->remarks = 'Wallet recharge through using gift code';
        $wallet->payment_details = json_encode($obj);
        $wallet->status = 1;
        if($wallet->save()){
            $user = User::find($request->user_id);
            $user->balance += $coupon->discount_amount;
            $user->update();

         // Generate Notification to admin
         \App\Models\Notification::create([
            'user_id' => DB::table('users')->select('id')->where('user_type', 'admin')->first()->id,
            'is_admin' => 1,
            'type' => 'wallet_recharge',
            'body' => translate('New transaction received - Wallet recharge'),
            'wallet_id' => $wallet->id,
        ]);
        // Generate Notification to user
        \App\Models\Notification::create([
            'user_id' => $request->user_id,
            'is_admin' => 3,
            'type' => 'wallet_recharge',
            'body' => translate('Hurrah!!! Your wallet has been recharged'),
            'wallet_id' => $wallet->id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $request->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Hurrah!!! Your wallet has been recharged')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        } 
    }
        return response()->json([
            'result' => true,
            'message' => 'Congratulations!!! Coupon has been applied'
        ]);
    }

    public function gift_code_notification_details(Request $request)
    {
        $data = Notification::where('id', $request->id)->select('gift_codes')->first();
        if($data->gift_codes){
            $codes = json_decode($data->gift_codes);
        }
        else{
            $codes = [];
        }
        $codes = collect($codes);
        $data_arr = $codes->map(function($code){
            $code_data = GiftCode::where('id', $code)->select('code','start_date','end_date','discount_amount')->first();
             return [
                'code' => $code_data->code,
                'start_date' => date(env('DATE_FORMAT'), $code_data->start_date),
                'end_date' => date(env('DATE_FORMAT'), $code_data->end_date),
                'amount' => format_price($code_data->discount_amount)
             ];
        });
        
        return response()->json([
            'result' => true,
            'data' => $data_arr
        ]);
    }

}
