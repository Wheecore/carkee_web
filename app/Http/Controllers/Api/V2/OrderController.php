<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\WorkshopAvailability;
use Illuminate\Support\Facades\DB;
use App\Models\CarWashMembership;
use App\Models\CarWashPayment;
use Illuminate\Http\Request;
use App\Models\CouponUsage;
use App\Models\OrderDetail;
use App\Models\Battery;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Petrol;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CarWashUsage;
use App\Models\Shop;
use App\Models\Tyre;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function emergencyOrderstore(Request $request)
    {
        $user = DB::table('users')->where('id', $request->user_id)->first();
        $carlist = DB::table('car_lists')
        ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
        ->select('car_lists.id', 'car_models.name as model', 'car_lists.car_plate', 'car_lists.model_id', 'car_lists.brand_id')
        ->where('car_lists.id', $request->car_id)
        ->where('car_lists.user_id', $user->id)
        ->first();
        $service_type = '';
        switch ($request->service) {
            case 'battery':
                $product = Battery::select('user_id', 'id', 'stock', 'name', 'warranty', 'service_type')->find($request->product_id);
                $order_type = 'B';
                $service_type = $product->service_type;
                break;
            case 'tyre':
                $product = Tyre::select('user_id', 'id', 'name')->find($request->product_id);
                $order_type = 'T';
                break;
            case 'petrol':
                $product = Petrol::select('user_id', 'id', 'name')->find($request->product_id);
                $order_type = 'P';
                break;
        }

        // order
        $order = new Order;
        $order->user_id = $user->id;
        $order->username = $user->name;
        $order->carlist_id = $carlist->id;
        $order->brand_id = $carlist->brand_id;
        $order->model_id = $carlist->model_id;
        $order->order_type = $order_type;
        $order->battery_type = $service_type;
        $order->seller_id = $product->user_id;
        $order->model_name = $carlist->model;
        $order->car_plate = $carlist->car_plate;
        $order->location = json_encode(['lat' => $request->latitude, 'long' => $request->longitude, 'loc' => $request->location]);
        $order->payment_type = 'ipay88';
        $order->code = date('Ymd-His') . rand(10, 99);
        $order->date = strtotime(date('Y-m-d H:i:s'));
        $order->order_schedule_time = $request->preferred_time;
        if ($order->save()) {
            $subtotal   = 0;
            $tax        = 0;
            $shipping   = 0;

            // calculate shipping is to get shipping costs of different types
            $admin_products     = array();
            
            // order details
            array_push($admin_products, $product->id);

            $subtotal   += $request->amount * 1;
            $tax        += 0 * 1;

            // stock
            if ($order_type == 'B' && $service_type != 'J' && isset($product->stock) && $product->stock <= 0) {
                $order->delete();
                return [
                    'issue' => 'quantity_issue',
                    'message' => 'The requested quantity is not available for ' . $product->name,
                ];
            } elseif (!in_array($request->service, array('tyre', 'petrol')) && $service_type != 'J') {
                if (isset($product->stock)) {
                    $product->stock -= 1;
                }
                $product->save();
            }

            $order_detail = new OrderDetail;
            $order_detail->order_id = $order->id;
            $order_detail->seller_id = $product->user_id;
            $order_detail->product_id = $product->id;

            $current_date = Carbon::now();
            $expiry_d = (isset(($product->warranty)) && is_numeric($product->warranty)) ? $current_date->addDays($product->warranty * 30) : '';
            if ($service_type == 'N') {
                $order->battery_expiry_months = (isset($product->warranty) ? $product->warranty : 0);
            }

            $order_detail->warranty_period  = date('Y-m-d', strtotime($expiry_d));
            $order_detail->price = $request->amount;
            $order_detail->tax = 0;
            $order_detail->shipping_type = 'Delivery';
            $order_detail->shipping_cost = 0;

            $shipping += $order_detail->shipping_cost;

            $order_detail->quantity = 1;
            $order_detail->type = 'E';

            $order_detail->save();
            $product->save();

            $order->grand_total = $subtotal + $tax + $shipping;

            // apply coupon 
            if ($request->coupon_id != 0) {
                $order->grand_total -= $request->calculatable_discount;
                $order->coupon_discount = $request->calculatable_discount;
                $limit_coupon = Coupon::where('id', $request->coupon_id)->select('id','limit')->first();
                if ($limit_coupon->limit > 0) {
                    $limit_coupon->update([
                        'limit' => $limit_coupon->limit - 1
                    ]);
                }
                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = $user->id;
                $coupon_usage->coupon_id = $request->coupon_id;
                $coupon_usage->save();
            }
            $order->save();

            return [
                'issue' => '',
                'order_id' => $order->id,
            ];
        }
    }

    public function carWashOrderstore(Request $request)
    {
        $carlist = DB::table('car_lists')
        ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
        ->select('car_lists.id', 'car_lists.user_id', 'car_models.name as model', 'car_lists.car_plate', 'car_lists.model_id', 'car_lists.brand_id')
        ->where('car_lists.id', $request->car_id)
        ->first();
        $user = DB::table('users')->where('id', $carlist->user_id)->select('id','name','balance')->first();
        if($request->amount > $user->balance){      
            return [
                'issue' => 'yes',
                'message' => 'The wallet balance is not enough to complete this order. Please recharge the wallet first.'
            ];
        }
        $product = DB::table('car_wash_products')->select('id', 'user_id', 'ptype', 'membership_fee', 'warranty', 'usage_limit')->where('id', $request->id)->first();

        // check membership
        if ($request->check_membership == 1) {
            $car_wash_memberships = new CarWashMembership();
            $car_wash_memberships->user_id = $carlist->user_id;
            $car_wash_memberships->car_plate = $carlist->car_plate;
            $car_wash_memberships->amount = $product->membership_fee;
            $car_wash_memberships->save();
        }

        // order
        $order = new Order();
        $order->user_id = $user->id;
        $order->username = $user->name;
        $order->carlist_id = $carlist->id;
        $order->brand_id = $carlist->brand_id;
        $order->model_id = $carlist->model_id;
        $order->order_type = 'CW';
        $order->battery_type = '';
        $order->seller_id = $product->user_id;
        $order->model_name = $carlist->model;
        $order->car_plate = $carlist->car_plate;
        $order->location = json_encode(['lat' => $request->latitude, 'long' => $request->longitude, 'loc' => $request->location]);
        $order->workshop_date = now();
        $order->workshop_time = now();
        $order->payment_type = 'Wallet';
        $order->code = date('Ymd-His') . rand(10, 99);
        $order->date = strtotime(date('Y-m-d H:i:s'));
        if ($order->save()) {
            $subtotal   = 0;
            $tax        = 0;
            $shipping   = 0;
            $subtotal   += $request->amount * 1;
            $tax        += 0 * 1;

            $order_detail = new OrderDetail;
            $order_detail->order_id = $order->id;
            $order_detail->seller_id = $product->user_id;
            $order_detail->product_id = $product->id;
            $order_detail->price = $request->amount;
            $order_detail->tax = 0;
            $order_detail->shipping_type = 'Car Wash';
            $order_detail->shipping_cost = 0;
            $shipping += $order_detail->shipping_cost;
            $order_detail->quantity = 1;
            $order_detail->type = 'C';

            $order_detail->save();
            $order->grand_total = $subtotal + $tax + $shipping;
            $order->coupon_discount = $request->discount;

            // Car wash payments
            $car_wash_payment = new CarWashPayment();
            $car_wash_payment->car_wash_product_id = $product->id;
            $car_wash_payment->carlist_id = $request->car_id;
            $car_wash_payment->order_id = $order->id;
            $car_wash_payment->user_id = $carlist->user_id;
            $car_wash_payment->usage_limit = $product->usage_limit;
            $car_wash_payment->amount = $request->amount;
            $car_wash_payment->membership_fee = ($request->check_membership == 1)?$product->membership_fee:0;
            $car_wash_payment->warranty = $product->warranty;
            $car_wash_payment->car_plate = $carlist->car_plate;
            $car_wash_payment->model_name = $carlist->model;
            $car_wash_payment->status = 0;
            $car_wash_payment->save();

            $order->save();
            // decrease user wallet balance
            $user = DB::table('users')->where('id', $carlist->user_id)->decrement('balance', $request->amount);

            // data entry to car wash usages
            $payment = CarWashPayment::find($car_wash_payment->id);
            $payment->technician_id = $request->technician_id;
            $payment->update();

            // Usage Log
            $car_wash_usage = new CarWashUsage();
            $car_wash_usage->carlist_id = $payment->carlist_id;
            $car_wash_usage->car_wash_payment_id = $payment->id;
            $car_wash_usage->car_wash_product_id = $payment->car_wash_product_id;
            $car_wash_usage->user_id = $carlist->user_id;
            $car_wash_usage->technician_id = $request->technician_id;
            $car_wash_usage->save();
        
            return [
                'issue' => '',
                'order_id' => $order->id,
            ];
        }
    }

    public function store_tyre_package_order(Request $request, $user)
    {
        $carts = Cart::where('is_checkout', 1)->where('user_id', $user->id)->get();
        if ($carts->count() > 0) {
            $carlist = DB::table('car_lists')
            ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
            ->select('car_lists.id', 'car_lists.car_plate', 'car_models.name as model')
            ->where('car_lists.id', $request->car_id)
            ->where('car_lists.user_id', $user->id)
            ->first();
            
            $order = new Order;
            $order->user_id = $user->id;
            $order->seller_id = $request->shop_id;
            $order->username = $user->name;
            $order->carlist_id = $carlist->id;
            $order->brand_id = $request->brand_id;
            $order->model_id = $request->model_id;
            $order->year_id = $request->year_id;
            $order->variant_id = $request->variant_id;
            $order->availability_id = $request->availability_id;
            $order->location = json_encode(['lat' => $request->latitude, 'long' => $request->longitude, 'loc' => $request->location]);
            $order->car_plate = ($carlist->car_plate ?? '');
            $order->model_name = ($carlist->model ?? '');
            $order->workshop_date = date('Y-m-d', strtotime($request->workshop_date));
            $order->workshop_time = $request->workshop_time;
            $order->payment_type = $request->payment_option;
            $order->code = date('Ymd-His') . rand(10, 99);
            $order->date = strtotime(date('Y-m-d H:i:s'));
            $order->express_delivery = $request->express_delivery;

            if ($order->save()) {
                $package_ids = [];
                $subtotal = 0;
                $tax = 0;
                $shipping = 0;
                $package_expiry_months_flag = true;
                //calculate shipping is to get shipping costs of different types
                $admin_products = array();
                $seller_products = array();
                //Order Details Storing
                $shop = Shop::where('id', $request->shop_id)->select('user_id')->first();
                foreach ($carts as $cartItem) {
                    // tyre items
                    if ($cartItem['product_id']) {
                        $product = Product::select('id', 'added_by', 'user_id', 'warranty_period', 'num_of_sale', 'qty')->find($cartItem['product_id']);
                        if ($product->added_by == 'admin') {
                            array_push($admin_products, $cartItem['product_id']);
                        } else {
                            $product_ids = array();
                            if (array_key_exists($product->user_id, $seller_products)) {
                                $product_ids = $seller_products[$product->user_id];
                            }
                            array_push($product_ids, $cartItem['product_id']);
                            $seller_products[$product->user_id] = $product_ids;
                        }
                        // subtotal calculation
                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                        $tax += $cartItem['tax'] * $cartItem['quantity'];
                        // product stock
                            if ($cartItem['quantity'] > $product->qty) {
                                $order->delete();
                                return [
                                    'issue' => 'quantity_issue',
                                    'message' => 'The requested quantity is not available for ' . $product->getTranslation('name'),
                                ];
                            } else {
                                $product->qty -= $cartItem['quantity'];
                                $product->save();
                            }

                        // order details
                        $order_detail = new OrderDetail;
                        $order_detail->order_id  = $order->id;
                        $order_detail->seller_id = $shop->user_id;
                        $order_detail->product_id = $product->id;
                        $current_date = Carbon::now();
                        $expiry_d = (is_numeric($product->warranty_period)) ? $current_date->addDays($product->warranty_period * 30) : '';
                        $order_detail->warranty_period =  date('Y-m-d', strtotime($expiry_d));
                        $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                        $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                        $order_detail->shipping_type = $cartItem['shipping_type'];
                        $order_detail->shipping_cost = $cartItem['shipping_cost'];
                        // shipping
                        $shipping += $order_detail->shipping_cost;
                        if ($cartItem['shipping_type'] == 'pickup_point') {
                            $order_detail->pickup_point_id = $cartItem['pickup_point'];
                        }
                        $order_detail->quantity = $cartItem['quantity'];
                        $order_detail->save();
                        $product->num_of_sale++;
                        $product->save();
                        // package items
                    } elseif ($cartItem['package_id']) {
                        $package_ids[] = $cartItem['package_id'];
                        if ($package_expiry_months_flag) {
                            $package = DB::table('packages')->select('expiry_month')->where('id', $cartItem['package_id'])->first();
                            $order->package_expiry_months = $package->expiry_month;
                            $package_expiry_months_flag = false;
                        }
                        $pps = DB::table('cart_package_products')->select('id', 'product_id', 'price', 'tax', 'shipping_cost', 'discount', 'quantity')->where('package_id', $cartItem['package_id'])->where('cart_id', $cartItem['id'])->get()->toArray();
                        foreach ($pps as $pp) {
                            $product = Product::select('id', 'added_by', 'user_id', 'warranty_period', 'num_of_sale', 'qty')->find($pp->product_id);
                            if ($product->added_by == 'admin') {
                                array_push($admin_products, $pp->product_id);
                            } else {
                                $product_ids = array();
                                if (array_key_exists($product->user_id, $seller_products)) {
                                    $product_ids = $seller_products[$product->user_id];
                                }
                                array_push($product_ids, $pp->product_id);
                                $seller_products[$product->user_id] = $product_ids;
                            }
                            // subtotal calculation
                            $subtotal += $pp->price;
                            $tax += ($pp->tax * $pp->quantity);
                            // product stock
                                if ($pp->quantity > $product->qty) {
                                    $order->delete();
                                    return [
                                        'issue' => 'quantity_issue',
                                        'message' => 'The requested quantity is not available for ' . $product->getTranslation('name'),
                                    ];
                                } else {
                                    $product->qty -= $pp->quantity;
                                    $product->save();
                                }
                            // order details
                            $order_detail = new OrderDetail;
                            $order_detail->order_id  = $order->id;
                            $order_detail->seller_id = $shop->user_id;
                            $order_detail->product_id = $product->id;
                            $current_date = Carbon::now();
                            $expiry_d = (is_numeric($product->warranty_period)) ? $current_date->addDays($product->warranty_period * 30) : '';
                            $order_detail->warranty_period =  date('Y-m-d', strtotime($expiry_d));
                            $order_detail->price = $pp->price;
                            $order_detail->tax = ($pp->tax * $pp->quantity);
                            $order_detail->shipping_type = $cartItem['shipping_type'];
                            $order_detail->shipping_cost = $cartItem['shipping_cost'];
                            // shipping
                            $shipping += $order_detail->shipping_cost;
                            if ($cartItem['shipping_type'] == 'pickup_point') {
                                $order_detail->pickup_point_id = $cartItem['pickup_point'];
                            }
                            $order_detail->quantity = $pp->quantity;
                            $order_detail->type = 'P';
                            $order_detail->package_id = $cartItem['package_id'];
                            $order_detail->save();
                            $product->num_of_sale++;
                            $product->save();
                        }
                    }
                }

                $order->grand_total = ($subtotal + $request->express_delivery + $tax + $shipping);

                // apply coupon 
                $cart_first_record = $carts->first();
                if ($cart_first_record->coupon_code != '') {
                    $order->grand_total -= $cart_first_record->discount;
                    $order->coupon_discount = $cart_first_record->discount;
                    $limit_coupon = Coupon::where('code', $cart_first_record->coupon_code)->first();
                    if ($limit_coupon->limit > 0) {
                        $limit_coupon->update([
                            'limit' => $limit_coupon->limit - 1
                        ]);
                    }
                    $coupon_usage = new CouponUsage;
                    $coupon_usage->user_id = $user->id;
                    $coupon_usage->coupon_id = $limit_coupon->id;
                    if ($limit_coupon->type == 'product_base') {
                        $coupon_usage->product_id = $cart_first_record->coupon_applied_product;
                    }
                    $coupon_usage->save();
                }
                // apply gift coupon if have
                if ($cart_first_record->is_gift_discount_applied) {
                    $order->grand_total -= $cart_first_record->gift_discount;
                    $discount_data = array();
                    $discount_data['title'] = $cart_first_record->discount_title;
                    $discount_data['discount'] = $cart_first_record->gift_discount;
                    $order->gift_discount_data = json_encode($discount_data);
                    $order->is_gift_discount_applied = 1;
                $coupon_ids = json_decode($cart_first_record->coupon_id, true); 
                foreach($coupon_ids as $coupon_id){
                    $gift_coupon = Coupon::where('id', $coupon_id)->first();
                    if ($gift_coupon->limit > 0) {
                        $gift_coupon->update([
                            'limit' => $gift_coupon->limit - 1
                        ]);
                    }
                    $products = json_decode($cart_first_record->gift_discount_coupon_applied_product, true);
                    $coupon_usage = new CouponUsage;
                    $coupon_usage->user_id = $user->id;
                    $coupon_usage->coupon_id = $gift_coupon->id;
                    $coupon_usage->product_id = $products[$coupon_id];
                    $coupon_usage->save();
                    }
                }
                // apply gift products if have
                if ($request->gift_coupon_id) {
                    $gift_product_data                     = array();
                    $gift_product_data['discount_title']          = $request->gift_title;
                    $gift_product_data['gift_name']          = $request->gift_name;
                    $gift_product_data['gift_image']          = $request->gift_image_id;
                    $order->gift_product_data          = json_encode($gift_product_data);
                    $order->is_gift_product_availed = 1;
                    $gift_coupon = Coupon::where('id', $request->gift_coupon_id)->first();
                    if ($gift_coupon->limit > 0) {
                        $gift_coupon->update([
                            'limit' => $gift_coupon->limit - 1
                        ]);
                    }
                    $coupon_usage = new CouponUsage;
                    $coupon_usage->user_id = $user->id;
                    $coupon_usage->coupon_id = $gift_coupon->id;
                    $coupon_usage->product_id = $request->gift_coupon_applied_product;
                    $coupon_usage->save();
                }

                $order->save();
                //now update the shop availability
                if ($request->availability_id) {
                    $shop = WorkshopAvailability::where('id', $request->availability_id)->first();
                    $shop->booked_appointments += 1;
                    $shop->save();
                }

                return [
                    'issue' => '',
                    'order_id' => $order->id,
                ];
            }
        }
    }

}
