<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Battery;
use App\Models\BrowseHistory;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmergencyServicesController extends Controller
{
    /*
    * List all cars added in the car list
    */
    public function select_your_carlist(Request $request)
    {
        $car_lists = DB::table('car_lists')->join('car_models', 'car_models.id', '=', 'car_lists.model_id')->join('brands', 'brands.id', '=', 'car_lists.brand_id')->select('car_lists.id as list_id', 'car_lists.model_id', 'car_lists.brand_id', 'car_lists.year_id', 'car_lists.variant_id', 'brands.name as brand', 'car_models.name as model', 'car_models.type', 'car_lists.car_plate')->where('car_lists.user_id', $request->user_id)->orderBy('car_lists.id', 'desc')->get()->toArray();
        return response()->json(['data' => $car_lists, 'status' => 200], 200);
    }

    /*
    * Delete car from the carlist
    */
    public function delete_select_your_carlist(Request $request)
    {
        DB::table('car_lists')->where('id', $request->list_id)->delete();
        return response()->json(['data' => [], 'msg' => translate('Car has been deleted from the list'), 'status' => 200], 200);
    }

    /*
    * List batteries based on service selected
    */
    public function list_selected_battery_products(Request $request)
    {
        if ($request->service == 'new_battery') {
            $car = DB::table('car_lists')->select('brand_id', 'model_id', 'year_id', 'variant_id')->where('id', $request->carlist_id)->first();
            $batteries = DB::table('batteries')
                ->leftJoin('uploads', 'uploads.id', '=', 'batteries.attachment_id')
                ->leftJoin('brand_datas', 'brand_datas.id', '=', 'batteries.battery_brand_id')
                ->leftJoin('uploads as battery_brand_img', 'battery_brand_img.id', '=', 'brand_datas.photo')
                ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"), DB::raw("CONCAT('" . url('/') . "/public/', battery_brand_img.file_name) AS battery_brand_img"), 'batteries.name', 'batteries.warranty', 'batteries.model', 'batteries.amount', 'batteries.discount', 'batteries.id as product_id', 'batteries.rating',)
                ->where('batteries.stock', '>', 0)->where('batteries.service_type', 'N')
                ->when(($car->brand_id), function ($q) use ($car) {
                    return $q->whereJsonContains('batteries.car_brand_id', (string) $car->brand_id);
                })
                ->when(($car->model_id), function ($q) use ($car) {
                    return $q->whereJsonContains('batteries.car_model_id', (string) $car->model_id);
                })
                ->when(($car->year_id), function ($q) use ($car) {
                    return $q->whereJsonContains('batteries.car_year_id', (string) $car->year_id);
                })
                ->when(($car->variant_id), function ($q) use ($car) {
                    return $q->whereJsonContains('batteries.car_variant_id', (string) $car->variant_id);
                })
                ->where('batteries.service_type', '!=', 'J')
                ->get()->toArray();
        } else {
            $batteries = DB::table('batteries')
                ->leftJoin('uploads', 'uploads.id', '=', 'batteries.attachment_id')
                ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"), 'batteries.name', 'batteries.warranty', 'batteries.model', 'batteries.amount', 'batteries.discount', 'batteries.id as product_id')
                ->where('batteries.stock', '>', 0)
                ->where('batteries.service_type', 'J')
                ->get()->toArray();
        }
        return response()->json(['data' => $batteries, 'status' => 200], 200);
    }

    /*
    * Check battery specifications
    */
    public function check_battery_specifications(Request $request)
    {
        $battery_browse_histoy = DB::table('browse_histories')->where('user_id', $request->user_id)->where('product_id', $request->product_id)->where('product_type', 'battery')->first();
        if (!$battery_browse_histoy && $request->user_id != 0) {
            $b_histoy = new BrowseHistory();
            $b_histoy->user_id = $request->user_id;
            $b_histoy->product_id = $request->product_id;
            $b_histoy->product_type = 'battery';
            $b_histoy->save();
        }
        $data['product'] = DB::table('batteries')->leftJoin('uploads', 'uploads.id', '=', 'batteries.attachment_id')->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"), 'batteries.name', 'batteries.warranty', 'batteries.model', 'batteries.capacity', 'batteries.cold_cranking_amperes', 'batteries.mileage_warranty', 'batteries.reserve_capacity', 'batteries.height', 'batteries.length', 'batteries.start_stop_function', 'batteries.width', 'batteries.jis', 'batteries.absorbed_glass_mat', 'batteries.rating', 'batteries.amount', 'batteries.discount', 'batteries.user_id', 'batteries.description')->where('batteries.id', $request->product_id)->first();
        $reviews = DB::table('reviews')->join('users', 'users.id', '=', 'reviews.user_id')->select('users.name', 'reviews.rating', 'reviews.comment')->where('reviews.battery_id', $request->product_id)->where('reviews.status', 1)->orderBy('reviews.id', 'desc')->limit(4)->get()->toArray();
        $data['reviews'] = [];
        foreach ($reviews as $review) {
            $data['reviews'][] = array(
                'name' => $review->name,
                'rating' => number_format($review->rating, 1),
                'review' => $review->comment,
            );
        }
        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    /*
    * Add battery to cart 
    */
    public function battery_add_to_cart(Request $request)
    {
        DB::table('carts')->insert([
            'owner_id' => $request->owner_id,
            'user_id' => $request->user_id,
            'carlist_id' => $request->carlist_id,
            'battery_id' => $request->battery_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'discount' => $request->discount,
        ]);

        return response()->json(['data' => [], 'msg' => translate('Added successfully'), 'status' => 200], 200);
    }

    /*
    * Add qty to battery to cart 
    */
    public function update_battery_qty_in_cart(Request $request)
    {
        if ($request->type == 'add') {
            DB::table('carts')->where('id', $request->cart_id)->update(['quantity' => DB::raw('quantity + 1')]);
        } else {
            DB::table('carts')->where('id', $request->cart_id)->update(['quantity' => DB::raw('quantity - 1')]);
        }

        return response()->json(['data' => [], 'msg' => translate('Updated successfully'), 'status' => 200], 200);
    }

    /*
    * List jumpstart battery
    */
    public function jumpstart_battery()
    {
        $product = DB::table('batteries')
            ->select('id as product_id', 'name', 'amount', 'rating')
            ->where('service_type', 'J')
            ->first();

        return response()->json(['data' => $product, 'status' => 200], 200);
    }

    /* Review battery */
    public function review_battery(Request $request)
    {
        $review = new Review();
        $review->battery_id = $request->battery_id;
        $review->user_id = $request->user_id;
        $review->rating = $request->rating;
        $review->comment = $request->review;
        $review->save();

        $battery = Battery::find($request->battery_id);
        $battery->rating = (DB::table('reviews')->where('battery_id', $request->battery_id)->sum('rating') / DB::table('reviews')->where('battery_id', $request->battery_id)->count());
        $battery->update();

        return response()->json([
            'result' => true
        ]);
    }

    /*
    * Spare Tyre Change
    */
    public function spareTyreChange()
    {
        $product = DB::table('tyres')
            ->select('id as product_id', 'name', 'amount')
            // ->where('service_type', 'J')
            ->first();

        return response()->json(['data' => $product, 'status' => 200], 200);
    }

    /*
    * I need petrol
    */
    public function emergencyPetrol()
    {
        $product = DB::table('petrols')
            ->select('id as product_id', 'name', 'amount')
            // ->where('service_type', 'J')
            ->first();

        return response()->json(['data' => $product, 'status' => 200], 200);
    }

    /*
    * Emergency order confirmation and checking
    */
    public function emergencyConfirmAndCheck(Request $request)
    {
        switch ($request->service) {
            case 'battery':
                $product = DB::table('batteries')->select('id as product_id', 'name', 'amount', 'warranty', 'model')->where('id', $request->product_id)->first();
                break;
        }
        return response()->json(['data' => $product, 'status' => 200], 200);
    }

    /*
    * Confirm emergency order
    */
    public function confirmEmergencyOrder(Request $request)
    {
        if($request->service == 'battery' && $request->battery_type == 'N'){
            $car = DB::table('car_lists')->select('brand_id', 'model_id', 'year_id', 'variant_id')->where('id', $request->car_id)->first();
            $battery = DB::table('batteries')->where('id', $request->product_id)
                ->when(($car->brand_id), function ($q) use ($car) {
                    return $q->whereJsonContains('car_brand_id', (string) $car->brand_id);
                })
                ->when(($car->model_id), function ($q) use ($car) {
                    return $q->whereJsonContains('car_model_id', (string) $car->model_id);
                })
                ->when(($car->year_id), function ($q) use ($car) {
                    return $q->whereJsonContains('car_year_id', (string) $car->year_id);
                })
                ->when(($car->variant_id), function ($q) use ($car) {
                    return $q->whereJsonContains('car_variant_id', (string) $car->variant_id);
                })
                ->first();
          if(!$battery){
                return response()->json([
                    'result' => false,
                    'message' => "Sorry! The battery is not related to your selected vehicle.",
                ]);
          }
        $orders = Order::where('user_id', $request->user_id)->where('order_type', 'B')->where('battery_type', 'N')->where('carlist_id', $request->car_id)->whereIn('delivery_status', ['pending','on_the_way'])->count();
        if($orders >= 1){
            return response()->json([
                'result' => false,
                'message' => "Sorry! Due to your existing uncomplete battery order You can't place a new battery order",
            ]);
        }
        }
        $orderController = new OrderController;
        $response = $orderController->emergencyOrderstore($request);

        if ($response['issue'] == 'quantity_issue') {
            return response()->json([
                'result' => false,
                'message' => $response['message'],
            ]);
        }
        $order = Order::findOrFail($response['order_id']);
        if ($order->grand_total > 1) {
            // ipay88
            $ipay = new Ipay88Controller();
            return $ipay->getCheckout($response['order_id']);
        } else {
            // Bypass the payment
            $ipay = new Ipay88Controller();
            return $ipay->byPassPayment($response['order_id'], 'bypass_payment');
        }
    }

    /*
    * Emergency order coupon apply
    */
    public function allCoupons(Request $request)
    {
        $coupons = DB::table('coupons')->where('type', 'emergency_coupon')
            ->where('start_date', '<=', strtotime(date('d-m-Y')))
            ->where('end_date', '>=', strtotime(date('d-m-Y')))
            ->where('limit', '>', 0)
            ->select('id', 'discount', 'code')
            ->get();

        $coupons_arr = $coupons->map(function ($coupon) use ($request) {
            if (DB::table('coupon_usages')->where('coupon_id', $coupon->id)->where('user_id', $request->user_id)->first() == null) {
                return [
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $coupon->code,
                    'calculatable_discount' => $coupon->discount,
                    'discount' => format_price($coupon->discount)
                ];
            } else {
                return false;
            }
        })->reject(function ($value) {
            return $value === false;
        });

        return response()->json([
            'result' => true,
            'coupons' => $coupons_arr
        ]);
    }
}
