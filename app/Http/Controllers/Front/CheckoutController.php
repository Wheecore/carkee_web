<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Cart;
use App\Models\WorkshopAvailability;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\User;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\InvoiceEmailManager;
use App\Models\Addon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        if ($request->payment_option != null) {
            flash(translate('Your email should be verified before order'))->warning();
            return redirect()->route('cart')->send();

            if (get_setting('email_verification') == 1 && !Auth::user()->hasVerifiedEmail()) {
                flash(translate('Your email should be verified before order'))->warning();
                return redirect()->route('cart')->send();
            }

            $orderController = new OrderController;
            $orderController->store($request);

            $request->session()->put('payment_type', 'cart_payment');
            $order = Order::findOrFail($request->session()->get('order_id'));
            if ($request->session()->get('order_id') != null) {
                if ($request->payment_option == 'ipay88') {
                    if ($order->grand_total > 1) {
                        $ipay = new Ipay88Controller();
                        return $ipay->getCheckout();
                    } else {
                        $start_date = date('d-m-Y', strtotime(Carbon::now()));
                        $end_date_format = Carbon::now()->addDays(30);
                        $end_date = date('d-m-Y', strtotime($end_date_format));

                        $coupon = new Coupon;
                        if (Auth::user()->referred_by && Auth::user()->referral_status == 0) {
                            $coupon->user_id = Auth::user()->referred_by;
                            $coupon->type             = 'cart_base';
                            $coupon->code             = Str::random(11);
                            $coupon->discount         = 10;
                            $coupon->discount_type    = 'amount';
                            $coupon->start_date       = strtotime($start_date);
                            $coupon->end_date         = strtotime($end_date);
                            $coupon->details = '{"min_buy":"3","max_discount":"5"}';
                            $coupon->limit         = 1;
                            $coupon->save();
                            DB::table('users')->where('id', Auth::id())->update([
                                'referral_status' => 1
                            ]);
                        }

                        $array['view'] = 'emails.invoice';
                        $array['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
                        $array['from'] = env('MAIL_FROM_ADDRESS');
                        $array['order'] = $order;

                        //sends email to customer with the invoice pdf attached
                        if (env('MAIL_USERNAME') != null) {
                            try {
                                Mail::to(Auth::user()->email)->queue(new InvoiceEmailManager($array));
                                Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                            } catch (\Exception $e) {
                            }
                        }
                        Cart::where('id', Session::get('session_cart_id'))->delete();
                        try {
                            $payment = ["status" => "Success"];
                            $payment_type = Session::get('payment_type');
                            if ($payment_type == 'cart_payment') {
                                return $this->checkout_done(session()->get('order_id'), json_encode($payment));
                            }
                        } catch (\Exception $e) {
                            flash(translate('Payment failed'))->error();
                            return redirect()->route('home');
                        }
                    }
                    flash(translate("Your order has been placed successfully"))->success();
                    return redirect()->route('order_confirmed');
                } elseif ($request->payment_option == 'stripe') {
                    if ($order->grand_total >= 4) {
                        $stripe = new StripePaymentController;
                        return $stripe->stripe();
                    } else {
                        $start_date = date('d-m-Y', strtotime(Carbon::now()));
                        $end_date_format = Carbon::now()->addDays(30);
                        $end_date = date('d-m-Y', strtotime($end_date_format));

                        $coupon = new Coupon;
                        if (Auth::user()->referred_by && Auth::user()->referral_status == 0) {
                            $coupon->user_id = Auth::user()->referred_by;
                            $coupon->type             = 'cart_base';
                            $coupon->code             = Str::random(11);
                            $coupon->discount         = 10;
                            $coupon->discount_type    = 'amount';
                            $coupon->start_date       = strtotime($start_date);
                            $coupon->end_date         = strtotime($end_date);
                            $coupon->details = '{"min_buy":"3","max_discount":"5"}';
                            $coupon->limit         = 1;
                            $coupon->save();
                            DB::table('users')->where('id', Auth::id())->update([
                                'referral_status' => 1
                            ]);
                        }

                        $array['view'] = 'emails.invoice';
                        $array['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
                        $array['from'] = env('MAIL_FROM_ADDRESS');
                        $array['order'] = $order;

                        //sends email to customer with the invoice pdf attached
                        if (env('MAIL_USERNAME') != null) {
                            try {
                                Mail::to(Auth::user()->email)->queue(new InvoiceEmailManager($array));
                                Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                            } catch (\Exception $e) {
                            }
                        }
                        Cart::where('id', Session::get('session_cart_id'))->delete();
                        try {
                            $payment = ["status" => "Success"];
                            $payment_type = Session::get('payment_type');
                            if ($payment_type == 'cart_payment') {
                                return $this->checkout_done(session()->get('order_id'), json_encode($payment));
                            }
                        } catch (\Exception $e) {
                            flash(translate('Payment failed'))->error();
                            return redirect()->route('home');
                        }
                        flash(translate("Your order has been placed successfully"))->success();
                        return redirect()->route('order_confirmed');
                    }
                } elseif ($request->payment_option == 'cash_on_delivery') {
                    flash(translate("Your order has been placed successfully"))->success();
                    return redirect()->route('order_confirmed');
                } else {
                    $order = Order::findOrFail($request->session()->get('order_id'));
                    $order->manual_payment = 1;
                    $order->save();
                    flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
                    return redirect()->route('order_confirmed');
                }
            }
        } else {
            flash(translate('Select Payment Option.'))->warning();
            return back();
        }
    }

    public function checkout_charges(Request $request)
    {
        if ($request->payment_option != null) {
            $request->session()->put('payment_type', 'cart_payment');
            if ($request->session()->get('order_id') != null) {
                if ($request->payment_option == 'ipay88') {
                    $ipay = new Ipay88Controller();
                    return $ipay->getCheckout();
                } elseif ($request->payment_option == 'stripe') {
                    $stripe = new StripePaymentController;
                    return $stripe->stripe();
                } else {
                    flash(translate('Select Payment Option.'))->warning();
                    return back();
                }
            }
        }
    }

    public function checkout_done($order_id, $payment)
    {
        $order = Order::findOrFail($order_id);
        $order->payment_status = 'paid';
        $order->payment_details = $payment;
        $order->save();

        if (Addon::where('unique_identifier', 'affiliate_system')->first() != null && Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
            $affiliateController = new AffiliateController;
            $affiliateController->processAffiliatePoints($order);
        }

        Cart::where('id', Session::get('session_cart_id'))
            ->where('owner_id', $order->seller_id)
            ->where('user_id', $order->user_id)
            ->delete();

        Session::forget('shop_name');
        Session::forget('sdate');
        Session::forget('time_slot');
        Session::forget('session_cart_id');
        Session::forget('tyre_product_id');

        flash(translate('Payment completed'))->success();
        return view('frontend.order_confirmed', compact('order'));
    }

    public function getShopDateTime(Request $request)
    {
        $shop = WorkshopAvailability::where('shop_id', $request->shop_id)->where('date', '=', $request->selected_date)->first();
        if ($shop && $shop->from_time && $shop->to_time) {
            $shop_details = Shop::where('id', $request->shop_id)->select('availability_duration')->first();
            $from_time = $shop->from_time;
            $to_time = $shop->to_time;
            $diff = abs(strtotime($from_time) - strtotime($to_time));
            // Convert $diff to minutes
            $tmins = $diff / 60;
            // Get hours
            $duration = ($shop_details->availability_duration) ? $shop_details->availability_duration : 60;
            $total_appointments = round(floor($tmins / $duration));
            if ($shop->booked_appointments < $total_appointments) {
                $from_time = $shop->date . ' ' . $from_time;
                $time_array = [];
                for ($i = 0; $i < $total_appointments; $i++) {
                    $order = DB::table('orders')->where('availability_id', $shop->id)->whereDate('workshop_date', date('Y-m-d', strtotime($from_time)))->whereTime('workshop_time', date('h:i A', strtotime($from_time)))->first();
                    if (!$order) {
                        array_push($time_array, $from_time);
                    }
                    $from_time = strtotime($from_time . ' + ' . $duration . ' minute');
                    $from_time = date('Y-m-d H:i:00', $from_time);
                }
                return array('code' => 200, 'time_array' => $time_array, 'availability_id' => $shop->id);
            } else {
                return array('code' => 400, 'message' => 'Slots are already booked on this date for this workshop. Please select another date');
            }
        } else {
            return array('code' => 400, 'message' => 'Workshop is not available on this date. Please select another date');
        }
    }

    public function get_shipping_info(Request $request, $query, $radius = 25)
    {
        Session::put('category_id', $request->category_id);
        Session::put('session_brand_id', $request->brand_id);
        Session::put('session_model_id', $request->model_id);
        Session::put('session_details_id', $request->details_id);
        Session::put('session_year_id', $request->year_id);
        Session::put('session_type_id', $request->type_id);
        Session::put('session_cart_id', $request->cart_id);

        $cart = Cart::where('id', $request->cart_id)->where('user_id', Auth::user()->id)->first();
        $product = DB::table('products')->where('id', $cart->product_id)->first();
        $product_brands = $product->brand_id;
        if ($product_brands && $product_brands != 'null') {
            $brands_arr = json_decode($product_brands);
            if (!in_array($request->brand_id, $brands_arr)) {
                $brands = DB::table('brands')->whereIn('id', $brands_arr)->select('name')->get();
                $brand_names = '';
                $i = 1;
                foreach ($brands as $brand) {
                    if ($i == 1) {
                        $brand_names .= $brand->name;
                    } else {
                        $brand_names .= ', ' . $brand->name;
                    }
                    $i++;
                }
                flash(translate('Please choose related brand for this product, related brands are: ' . $brand_names))->warning();
                return back();
            }
        }
        $product_models = $product->model_id;
        if ($product_models && $product_models != 'null') {
            $models_arr = json_decode($product_models);
            if (!in_array($request->model_id, $models_arr)) {
                $models = DB::table('car_models')->whereIn('id', $models_arr)->select('name')->get();
                $model_names = '';
                $i = 1;
                foreach ($models as $model) {
                    if ($i == 1) {
                        $model_names .= $model->name;
                    } else {
                        $model_names .= ', ' . $model->name;
                    }
                    $i++;
                }
                flash(translate('Please choose related model for this product, related models are: ' . $model_names))->warning();
                return back();
            }
        }
        $product_details = $product->details_id;
        if ($product_details && $product_details != 'null') {
            $details_arr = json_decode($product_details);
            if ($request->details_id) {
                if (!in_array($request->details_id, $details_arr)) {
                    $details = DB::table('car_details')->whereIn('id', $details_arr)->select('name')->get();
                    $detail_names = '';
                    $i = 1;
                    foreach ($details as $detail) {
                        if ($i == 1) {
                            $detail_names .= $detail->name;
                        } else {
                            $detail_names .= ', ' . $detail->name;
                        }
                        $i++;
                    }
                    flash(translate('Please choose related year for this product, related years are: ' . $detail_names))->warning();
                    return back();
                }
            }
        }
        $product_years = $product->year_id;
        if ($product_years && $product_years != 'null') {
            $years_arr = json_decode($product_years);
            if ($request->year_id) {
                if (!in_array($request->year_id, $years_arr)) {
                    $years = DB::table('car_years')->whereIn('id', $years_arr)->select('name')->get();
                    $year_names = '';
                    $i = 1;
                    foreach ($years as $year) {
                        if ($i == 1) {
                            $year_names .= $year->name;
                        } else {
                            $year_names .= ', ' . $year->name;
                        }
                        $i++;
                    }
                    flash(translate('Please choose related CC for this product, related CC are: ' . $year_names))->warning();
                    return back();
                }
            }
        }
        $product_types = $product->type_id;
        if ($product_types && $product_types != 'null') {
            $types_arr = json_decode($product_types);
            if ($request->type_id) {
                if (!in_array($request->type_id, $types_arr)) {
                    $types = DB::table('car_types')->whereIn('id', $types_arr)->select('name')->get();
                    $type_names = '';
                    $i = 1;
                    foreach ($types as $type) {
                        if ($i == 1) {
                            $type_names .= $type->name;
                        } else {
                            $type_names .= ', ' . $type->name;
                        }
                        $i++;
                    }
                    flash(translate('Please choose related variant for this product, related variants are: ' . $type_names))->warning();
                    return back();
                }
            }
        }

        $carlist_exists = DB::table('car_lists')->where('user_id', Auth::id())
            ->where('brand_id', $request->brand_id)
            ->where('model_id', $request->model_id)
            ->where('details_id', $request->details_id)
            ->where('year_id', $request->year_id)
            ->where('type_id', $request->type_id)
            ->first();
        if (!$carlist_exists) {
            flash(translate('Please add this record into your vehicle first.'))->warning();
            return back();
        }
        if (!$carlist_exists->car_plate) {
            flash(translate('Please add car plate for this list from your dashboard first.'))->warning();
            return back();
        }

        if (Session::has('reassign_status')) {
            Session::forget('reassign_status');
            Session::forget('order_items');
        }
        $carts = Cart::where('id', $request->cart_id)->where('user_id', Auth::user()->id)->get();
        //        if (Session::has('cart') && count(Session::get('cart')) > 0) {
        if ($carts && count($carts) > 0) {
            $categories = Category::all();
            $shops = DB::table("shops");
            //            $mapShops = $shops->makeHidden(['created_at', 'updated_at', 'deleted_at', 'logo']);
            $latitude = $shops->count() ? $shops->average('latitude') : 51.5073509;
            $longitude = $shops->count() ? $shops->average('longitude') : -0.12775829999998223;

            $shops          =       $shops->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                                + sin(radians(" . $latitude . ")) * sin(radians(latitude))) AS distance"));
            $shops          =       $shops->having('distance', '<', 25);
            $shops          =       $shops->orderBy('distance', 'asc');

            $mapShops          =       $shops->get();

            //          $mapShops = $shops->makeHidden(['created_at', 'updated_at', 'deleted_at', 'logo']);
            return view('frontend.shipping_info', compact('categories', 'carts', 'mapShops', 'latitude', 'longitude'));
        }
        flash(translate('Your cart is empty'))->success();
        return back();
    }

    public function store_shipping_info(Request $request)
    {
        if ($request->address_id == null) {
            flash(translate("Please add shipping address"))->warning();
            return back();
        }

        $carts = Cart::where('id', Session::get('session_cart_id'))->where('user_id', Auth::user()->id)->get();

        foreach ($carts as $key => $cartItem) {
            $cartItem->address_id = $request->address_id;
            $cartItem->save();
        }

        return view('frontend.delivery_info', compact('carts'));
        // return view('frontend.payment_select', compact('total'));
    }

    public function store_delivery_info(Request $request)
    {
        Session::forget('express_delivery');
        $sdate = $request->selected_date;
        $time_slot = $request->selected_time;
        $availability_id = $request->availability_id;
        $shop_id = $request->shop_id;
        $shop_name = Shop::where('id', $shop_id)->select('name')->first();
        Session::put('shop_name', $shop_name);
        Session::put('time_slot', $time_slot);
        Session::put('sdate', $sdate);

        $carts = Cart::where('id', Session::get('session_cart_id'))->where('user_id', Auth::user()->id)->get();
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;

        if ($carts && count($carts) > 0) {
            foreach ($carts as $key => $cartItem) {
                $product = Product::find($cartItem['product_id']);
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $subtotal += $cartItem['price'] * $cartItem['quantity'];

                if ($request['shipping_type_' . $request->owner_id] == 'pickup_point') {
                    $cartItem['shipping_type'] = 'pickup_point';
                    $cartItem['pickup_point'] = $request['pickup_point_id_' . $request->owner_id];
                } else {
                    $cartItem['shipping_type'] = 'home_delivery';
                }
                $cartItem['shipping_cost'] = 0;
                if ($cartItem['shipping_type'] == 'home_delivery') {
                    $cartItem['shipping_cost'] = getShippingCost($carts, $key);
                }

                if (isset($cartItem['shipping_cost']) && is_array(json_decode($cartItem['shipping_cost'], true))) {

                    foreach (json_decode($cartItem['shipping_cost'], true) as $shipping_region => $val) {
                        if ($shipping_info['city'] == $shipping_region) {
                            $cartItem['shipping_cost'] = (float)($val);
                            break;
                        } else {
                            $cartItem['shipping_cost'] = 0;
                        }
                    }
                } else {
                    if (
                        !$cartItem['shipping_cost'] ||
                        $cartItem['shipping_cost'] == null ||
                        $cartItem['shipping_cost'] == 'null'
                    ) {

                        $cartItem['shipping_cost'] = 0;
                    }
                }

                if ($product->is_quantity_multiplied == 1 && get_setting('shipping_type') == 'product_wise_shipping') {
                    $cartItem['shipping_cost'] =  $cartItem['shipping_cost'] * $cartItem['quantity'];
                }

                $shipping += $cartItem['shipping_cost'];
                $cartItem->save();
            }
            $total = $subtotal + $tax + $shipping;
            return view('frontend.payment_select', compact('carts', 'shipping_info', 'total', 'shop_id', 'availability_id', 'sdate', 'time_slot'));
        } else {
            flash(translate('Your Cart was empty'))->warning();
            return redirect()->route('home');
        }
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();
        $carts = Cart::where('id', Session::get('session_cart_id'))->where('user_id', Auth::user()->id)
            ->where('owner_id', $request->owner_id)
            ->get();
        $response_message = array();

        if ($coupon != null) {

            if ($coupon->limit > 0) {
                if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                    if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null) {
                        $coupon_details = json_decode($coupon->details);

                        if ($coupon->type == 'cart_base') {
                            $subtotal = 0;
                            $tax = 0;
                            $shipping = 0;
                            foreach ($carts as $key => $cartItem) {
                                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                                $tax += $cartItem['tax'] * $cartItem['quantity'];
                                $shipping += $cartItem['shipping_cost'];
                            }
                            $sum = $subtotal + $tax + $shipping;

                            if ($sum >= $coupon_details->min_buy) {
                                if ($coupon->discount_type == 'percent') {
                                    $coupon_discount = ($sum * $coupon->discount) / 100;
                                    if ($coupon_discount > $coupon_details->max_discount) {
                                        $coupon_discount = $coupon_details->max_discount;
                                    }
                                } elseif ($coupon->discount_type == 'amount') {
                                    $coupon_discount = $coupon->discount;
                                }
                            }

                            Cart::where('id', Session::get('session_cart_id'))
                                ->where('user_id', Auth::user()->id)
                                ->where('owner_id', $request->owner_id)
                                ->update(
                                    [
                                        'discount' => $coupon_discount / count($carts),
                                        'coupon_code' => $request->code,
                                        'coupon_applied' => 1
                                    ]
                                );
                        } elseif ($coupon->type == 'product_base') {
                            $coupon_discount = 0;
                            foreach ($carts as $key => $cartItem) {
                                foreach ($coupon_details as $key => $coupon_detail) {
                                    if ($coupon_detail->product_id == $cartItem['product_id']) {
                                        if ($coupon->discount_type == 'percent') {
                                            $coupon_discount += $cartItem['price'] * $coupon->discount / 100;
                                        } elseif ($coupon->discount_type == 'amount') {
                                            $coupon_discount = $coupon->discount;
                                        }

                                        Cart::where('id', Session::get('session_cart_id'))
                                            ->where('user_id', Auth::user()->id)
                                            ->where('owner_id', $request->owner_id)->where('product_id', $cartItem['product_id'])
                                            ->update(
                                                [
                                                    'discount' => ($coupon->discount_type == 'amount') ? $coupon_discount : $coupon_discount / count($carts),
                                                    'coupon_code' => $request->code,
                                                    'coupon_applied' => 1
                                                ]
                                            );
                                    }
                                }
                            }
                        }

                        $response_message['response'] = 'success';
                        $response_message['message'] = translate('Coupon has been applied');
                    } else {
                        $response_message['response'] = 'warning';
                        $response_message['message'] = translate('You already used this coupon!');
                    }
                } else {
                    $response_message['response'] = 'warning';
                    $response_message['message'] = translate('Coupon expired!');
                }
            } else {
                $response_message['response'] = 'danger';
                $response_message['message'] = translate('Invalid coupon!');
            }
        } else {
            $response_message['response'] = 'danger';
            $response_message['message'] = translate('Invalid coupon!');
        }
        $carts = Cart::where('id', Session::get('session_cart_id'))->where('user_id', Auth::user()->id)
            ->where('owner_id', $request->owner_id)
            ->get();
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();

        $returnHTML = view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info'))->render();
        return response()->json(array('response_message' => $response_message, 'html' => $returnHTML));
    }

    public function remove_coupon_code(Request $request)
    {
        Cart::where('id', Session::get('session_cart_id'))->where('user_id', Auth::user()->id)
            ->where('owner_id', $request->owner_id)
            ->update(
                [
                    'discount' => 0.00,
                    'coupon_code' => '',
                    'coupon_applied' => 0
                ]
            );

        $coupon = Coupon::where('code', $request->code)->first();
        $carts = Cart::where('id', Session::get('session_cart_id'))->where('user_id', Auth::user()->id)
            ->where('owner_id', $request->owner_id)
            ->get();
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        return view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info'));
    }

    public function order_confirmed()
    {
        $order = Order::findOrFail(Session::get('order_id'));
        Cart::where('id', Session::get('session_cart_id'))
            ->where('owner_id', $order->seller_id)
            ->where('user_id', $order->user_id)
            ->delete();
        Session::forget('session_cart_id');
        Session::forget('tyre_product_id');
        return view('frontend.order_confirmed', compact('order'));
    }

    public function checkTimings(Request $request)
    {
        $data = WorkshopAvailability::select('date')->where('shop_id', $request->shop_id)->where('from_time', '!=', '')->where('to_time', '!=', '')->whereDate('date', '>', date('Y-m-d'))->get();
        if (count($data) > 0) {
            return $data;
        } else {
            return 'empty';
        }
    }

    public function express_delivery(Request $request)
    {
        $carts = Cart::where('id', Session::get('session_cart_id'))->where('user_id', Auth::user()->id)
            ->get();
        $response_message['response'] = 'success';
        if ($request->input_value == 1) {
            Session::put('express_delivery', get_setting('express_delivery'));
            $response_message['message'] = translate('Express delivery has been applied');
        } else {
            Session::forget('express_delivery');
            $response_message['message'] = translate('Express delivery has been removed');
        }
        $returnHTML = view('frontend.partials.cart_summary', compact('carts'))->render();
        return response()->json(array('response_message' => $response_message, 'html' => $returnHTML));
    }
}
