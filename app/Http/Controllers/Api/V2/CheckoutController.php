<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\V2\OrderController;
use App\Http\Controllers\Api\V2\Ipay88Controller;
use App\Http\Controllers\Admin\AffiliateController;
use App\Mail\InvoiceEmailManager;
use App\Models\Battery;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CouponUsage;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CarWashPayment;
use App\Models\Payment;
use App\Models\Shop;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Models\PointsAdjustment;
use App\Models\Customer;


class CheckoutController
{
    public function apply_coupon_code(Request $request)
    {
        $cart_items = Cart::where('is_checkout', 1)->where('user_id', $request->user_id)->get();
        $coupon = Coupon::where('code', $request->coupon_code)->where('type','!=','emergency_coupon')->first();

        if ($cart_items->isEmpty()) {
            return response()->json([
                'result' => false,
                'message' => 'Cart is empty'
            ]);
        }

        if ($coupon == null) {
            return response()->json([
                'result' => false,
                'message' => 'Invalid coupon code!'
            ]);
        }

        $in_range = strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date;

        if (!$in_range) {
            return response()->json([
                'result' => false,
                'message' => 'Coupon expired!'
            ]);
        }

        if ($coupon->limit <= 0) {
            return response()->json([
                'result' => false,
                'message' => 'Coupon usage limit already exceeded!'
            ]);
        }

        if ($coupon->type == 'cart_base' || $coupon->type == 'warranty_reward') {
            $is_used = CouponUsage::where('user_id', $request->user_id)->where('coupon_id', $coupon->id)->first();
            if ($is_used) {
                return response()->json([
                    'result' => false,
                    'message' => 'You already used this coupon!'
                ]);
            }
        } elseif ($coupon->type == 'product_base') {
            foreach ($cart_items as $cartItem) {
            if ($cartItem['product_id']) {
                if (CouponUsage::where('user_id', $request->user_id)->where('product_id', $cartItem['product_id'])->where('coupon_id', $coupon->id)->first() != null) {
                    return response()->json([
                        'result' => false,
                        'message' => 'You already used this coupon for this tyre product!'
                    ]);
                }
            }
            elseif ($cartItem['package_id']) {
                $package_products = DB::table('cart_package_products')->where('package_id', $cartItem['package_id'])->where('cart_id',$cartItem['cart_id'])->select('product_id')->get();
                foreach($package_products as $package_product){
                    if (CouponUsage::where('user_id', $request->user_id)->where('product_id', $package_product->product_id)->where('coupon_id', $coupon->id)->first() != null) {
                        return response()->json([
                            'result' => false,
                            'message' => 'You already used this coupon for this package product!'
                        ]);
                    }
                }
            }
            }
        }

        $coupon_details = json_decode($coupon->details);
        
        if ($coupon->type == 'cart_base' || $coupon->type == 'warranty_reward') {
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            foreach ($cart_items as $key => $cartItem) {
                if ($cartItem['product_id']) {
                    $subtotal += $cartItem['price'] * $cartItem['quantity'];
                    $tax += $cartItem['tax'] * $cartItem['quantity'];
                    $shipping += $cartItem['shipping_cost'] * $cartItem['quantity'];
                }
                elseif ($cartItem['package_id']) {
                    $subtotal += $cartItem['price'];
                    $tax += $cartItem['tax'];
                    $shipping += $cartItem['shipping_cost'];
                }
            }
            $sum = $subtotal + $tax + $shipping;

            if ($sum >= $coupon_details->min_buy) {
                if ($coupon->discount_type == 'percent') {
                    $coupon_discount = ($sum * $coupon->discount) / 100;
                    if ($coupon_details->max_discount) {
                        if ($coupon_discount > $coupon_details->max_discount) {
                            $coupon_discount = $coupon_details->max_discount;
                        }
                    }
                } elseif ($coupon->discount_type == 'amount') {
                    $coupon_discount = $coupon->discount;
                }

                $cart_update = Cart::where('user_id', $request->user_id)->where('is_checkout', 1)->first();
                $cart_update->discount = $coupon_discount;
                $cart_update->coupon_code = $request->coupon_code;
                $cart_update->coupon_applied = 1;
                $cart_update->update();

                return response()->json([
                    'result' => true,
                    'message' => 'Coupon Applied'
                ]);
            } else {
                return response()->json([
                    'result' => false,
                    'message' => 'You need to buy atleast ' . $coupon_details->min_buy . ' to avail this coupon'
                ]);
            }
        } elseif ($coupon->type == 'product_base') {
            $coupon_discount = 0;
            $loop = false;
            $coupon_applied_product = 0;
            foreach ($cart_items as $key => $cartItem) {
                foreach ($coupon_details as $key => $coupon_detail) {
                if ($cartItem['product_id'] && $coupon_applied_product == 0) {
                if ($coupon_detail->product_id == $cartItem['product_id']) {
                    $loop = true;
                    if ($coupon->discount_type == 'percent') {
                        $coupon_discount += (($cartItem['price'] * $cartItem['quantity']) * $coupon->discount) / 100;
                    } elseif ($coupon->discount_type == 'amount') {
                        $coupon_discount += $coupon->discount;
                    }
                    $coupon_applied_product = $cartItem['product_id'];
                   }
                 }
                elseif ($cartItem['package_id'] && $coupon_applied_product == 0) {
                    $package_products = DB::table('cart_package_products')->where('package_id', $cartItem['package_id'])->where('cart_id',$cartItem['cart_id'])->select('product_id','price')->get();
                    foreach($package_products as $package_product){
                    if($coupon_detail->product_id == $package_product->product_id) {
                    $loop = true;
                    if ($coupon->discount_type == 'percent') {
                        $coupon_discount += ($package_product->price * $coupon->discount) / 100;
                    } elseif ($coupon->discount_type == 'amount') {
                        $coupon_discount += $coupon->discount;
                    }
                    $coupon_applied_product = $package_product->product_id;
                  }
                }
                }
              }           
            }

            if ($loop) {
                $cart_update = Cart::where('user_id', $request->user_id)->where('is_checkout', 1)->first();
                $cart_update->discount = $coupon_discount;
                $cart_update->coupon_code = $request->coupon_code;
                $cart_update->coupon_applied = 1;
                $cart_update->coupon_applied_product = $coupon_applied_product;
                $cart_update->update();

                return response()->json([
                    'result' => true,
                    'message' => 'Coupon Applied'
                ]);
            } else {
                return response()->json([
                    'result' => false,
                    'message' => 'This coupon is not available for this product'
                ]);
            }
        }
    }

    public function remove_coupon_code(Request $request)
    {
        Cart::where('user_id', $request->user_id)->where('is_checkout', 1)->update([
            'discount' => 0.00,
            'coupon_code' => "",
            'coupon_applied' => 0,
            'coupon_applied_product' => 0
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Coupon Removed'
        ]);
    }

    public function store_delivery_info(Request $request)
    {
        $carts = Cart::where('user_id', $request->user_id)->where('carlist_id', $request->carlist_id)->where('is_checkout', 1)->get();
        if ($carts && count($carts) > 0) {
            foreach ($carts as $cart) {
                if ($cart['is_gift_discount_applied'] == 1) {
                    // remove the discount coupon data if have
                    Cart::where('id', $cart->id)->update([
                        'gift_discount' => 0,
                        'is_gift_discount_applied' => 0,
                        'coupon_id' => null,
                        'discount_title' => null,
                        'gift_discount_coupon_applied_product' => 0
                    ]);
                }
            }
            $cart_summary = $this->cartSummary($carts, $request->user_id);
            return response()->json([
                'result' => true,
                'owner_id' => $carts[0]['owner_id'],
                'cart_summary' => $cart_summary
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Your cart is empty',
            ]);
        }
    }

    public function cartSummary($carts, $user_id)
    {
        $shipping_info['city'] = '';
        if (isset($carts[0])) {
            $shipping_info = DB::table('addresses')->select('city')->where('id', $carts[0]['address_id'])->first();
        }
        $currency_symbol = Currency::select('symbol')->findOrFail(get_setting('system_default_currency'))->symbol;
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;
        $quantity = 0;
        $tyre_subtotal = 0;
        $package_subtotal = 0;
        $products_items = [];
        $packages_items = [];
        $product_name_with_choice = '';
        if ($carts && count($carts) > 0) {
            foreach ($carts as $key => $cartItem) {
                if ($cartItem['product_id']) {
                    $product = Product::select('id', 'added_by', 'user_id', 'is_quantity_multiplied')
                        ->where('id', $cartItem['product_id'])
                        ->first();
                    $product_name_with_choice = $product->getTranslation('name');
                    $quantity += $cartItem['quantity'];
                    $tax += $cartItem['tax'] * $cartItem['quantity'];
                    $subtotal += $cartItem['price'] * $cartItem['quantity'];
                    $tyre_subtotal += ($cartItem['price'] * $cartItem['quantity']);
                    $cartItem['shipping_type'] = 'home_delivery';
                    $cartItem['shipping_cost'] = 0;
                    if ($cartItem['shipping_type'] == 'home_delivery') {
                        $cartItem['shipping_cost'] = get_shipping_cost($carts, $key, $product, $shipping_info);
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
                        if (!$cartItem['shipping_cost'] || $cartItem['shipping_cost'] == null || $cartItem['shipping_cost'] == 'null') {
                            $cartItem['shipping_cost'] = 0;
                        }
                    }
                    if ($product->is_quantity_multiplied == 1 && get_setting('shipping_type') == 'product_wise_shipping') {
                        $cartItem['shipping_cost'] =  $cartItem['shipping_cost'] * $cartItem['quantity'];
                    }
                    $shipping += $cartItem['shipping_cost'];
                    $cartItem->save();
                    $products_items[] = [
                        'cart_id' => $cartItem['id'],
                        'product_id' => $cartItem['product_id'],
                        'product_name_with_choice' => $product_name_with_choice,
                        'quantity' => $cartItem['quantity'],
                    ];
                } elseif ($cartItem['package_id']) {
                    $package = DB::table('packages')->where('id', $cartItem['package_id'])->select('id')->first();
                    if ($package) {
                        $pps = DB::table('cart_package_products')->select('id', 'product_id', 'price', 'tax', 'shipping_cost', 'discount', 'quantity')->where('package_id', $cartItem['package_id'])->where('cart_id',$cartItem['id'])->get()->toArray();
                        $packages_items[$key] = [
                            'cart_id' => $cartItem['id'],
                            'package_id' => $cartItem['package_id'],
                            'package' => translate('Package'),
                        ];
                        foreach ($pps as $pp) {
                            $package_product_arr = [];
                            $product = Product::select('id', 'added_by', 'user_id', 'is_quantity_multiplied')->where('id', $pp->product_id)->first();
                            if ($product) {
                                $product_name_with_choice = $product->getTranslation('name');
                                $quantity += $pp->quantity;
                                $tax += $pp->tax * $pp->quantity;
                                $subtotal += $pp->price;
                                $package_subtotal += $pp->price;
                                $package_product_arr['shipping_cost'] = get_shipping_cost($carts, $key, $product, $shipping_info);
                                if (isset($package_product_arr['shipping_cost']) && is_array(json_decode($package_product_arr['shipping_cost'], true))) {
                                    foreach (json_decode($package_product_arr['shipping_cost'], true) as $shipping_region => $val) {
                                        if ($shipping_info['city'] == $shipping_region) {
                                            $package_product_arr['shipping_cost'] = (float)($val);
                                            break;
                                        } else {
                                            $package_product_arr['shipping_cost'] = 0;
                                        }
                                    }
                                } else {
                                    if (!$package_product_arr['shipping_cost'] || $package_product_arr['shipping_cost'] == null || $package_product_arr['shipping_cost'] == 'null') {
                                        $cartItem['shipping_cost'] = 0;
                                    }
                                }
                                if ($product->is_quantity_multiplied == 1 && get_setting('shipping_type') == 'product_wise_shipping') {
                                    $package_product_arr['shipping_cost'] =  $package_product_arr['shipping_cost'] * $pp->quantity;
                                }
                                $shipping += $cartItem['shipping_cost'];
                                DB::table('cart_package_products')->where('id', $pp->product_id)->update($package_product_arr);
                                $packages_items[$key]['products'][] = [
                                    'product_id' => $product->id,
                                    'product_name_with_choice' => $product_name_with_choice,
                                    'quantity' => $pp->quantity,
                                ];
                            }
                        }
                    }
                }
            }
            $total = $subtotal + $tax + $shipping;

            // check for coupons as gift base
            $discount_title = '';
            $gift_coupon_discount = 0;
            $is_gift_discount_apply = false;
            $coupon_ids = [];
            $gift_discount_applied_products = [];
            $discount_base_giftCoupons = Coupon::where('type', 'gift_base')->where('gift_type', 'discount')->get();
            foreach ($discount_base_giftCoupons as $d_g_coupon) {
                // check for product is valid or not
                $products = json_decode($d_g_coupon->product_ids);
                $coupon_details = json_decode($d_g_coupon->details);
                foreach ($carts as $key => $cartItem) {
                if ($cartItem['product_id']) {
                if (in_array($cartItem['product_id'], $products)) {
                    // check minimum buy critiria
                    if ($total >= (int) $coupon_details->min_buy) {
                        // check that not used by this user before
                        $is_used = CouponUsage::where('user_id', $user_id)->where('product_id', $cartItem['product_id'])->where('coupon_id', $d_g_coupon->id)->first();
                        if (!$is_used) {
                            // check date ranges
                            $in_range = strtotime(date('d-m-Y')) >= $d_g_coupon->start_date && strtotime(date('d-m-Y')) <= $d_g_coupon->end_date;
                            if ($in_range) {
                                // check limit
                                if ($d_g_coupon->limit > 0) {
                                    // apply coupon
                                    if ($d_g_coupon->discount_type == 'percent') {
                                        $gift_coupon_discount += ($total * $d_g_coupon->discount) / 100;
                                    } elseif ($d_g_coupon->discount_type == 'amount') {
                                        $gift_coupon_discount += $d_g_coupon->discount;
                                    }
                                    $is_gift_discount_apply = true;
                                    $coupon_ids[] = $d_g_coupon->id;
                                    if($discount_title == ''){
                                        $discount_title = $d_g_coupon->discount_title;
                                    }
                                    else{
                                        $discount_title .= ' ,'.$d_g_coupon->discount_title;
                                    }
                                    $gift_discount_applied_products[$d_g_coupon->id] = $cartItem['product_id'];
                                }
                            }
                        }
                        }
                        }
                    }
                    elseif ($cartItem['package_id']) {
                        $package_products = DB::table('cart_package_products')->where('package_id', $cartItem['package_id'])->where('cart_id',$cartItem['cart_id'])->select('product_id')->get();
                        foreach($package_products as $package_product){
                        if (in_array($package_product->product_id, $products)) {
                            // check minimum buy critiria
                                if ($total >= (int) $coupon_details->min_buy) {
                                    // check that not used by this user before
                                    $is_used = CouponUsage::where('user_id', $user_id)->where('product_id', $package_product->product_id)->where('coupon_id', $d_g_coupon->id)->first();
                                    if (!$is_used) {
                                    // check date ranges
                                    $in_range = strtotime(date('d-m-Y')) >= $d_g_coupon->start_date && strtotime(date('d-m-Y')) <= $d_g_coupon->end_date;
                                    if ($in_range) {
                                        // check limit
                                        if ($d_g_coupon->limit > 0) {
                                            // apply coupon
                                            if ($d_g_coupon->discount_type == 'percent') {
                                                $gift_coupon_discount += ($total * $d_g_coupon->discount) / 100;
                                            } elseif ($d_g_coupon->discount_type == 'amount') {
                                                $gift_coupon_discount += $d_g_coupon->discount;
                                            }
                                            $is_gift_discount_apply = true;
                                            $coupon_ids[] = $d_g_coupon->id;
                                            if($discount_title == ''){
                                                $discount_title = $d_g_coupon->discount_title;
                                            }
                                            else{
                                                $discount_title .= ' ,'.$d_g_coupon->discount_title;
                                            }
                                            $gift_discount_applied_products[$d_g_coupon->id] = $package_product->product_id;
                                        }
                                    }
                                  }
                              }
                            }
                          }
                        }
                    }
            }
            
        if($is_gift_discount_apply){
            $cart_update = Cart::where('user_id', $user_id)->where('is_checkout', 1)->first();
            $cart_update->gift_discount = $gift_coupon_discount;
            $cart_update->is_gift_discount_applied = 1;
            $cart_update->coupon_id = json_encode($coupon_ids);
            $cart_update->discount_title = $discount_title;
            $cart_update->gift_discount_coupon_applied_product = json_encode($gift_discount_applied_products);
            $cart_update->update();
        }
            // check for gifts
            $product_base_gifts = Coupon::where('type', 'gift_base')->where('gift_type', 'gift')->get();
            $gifts_arr = [];
            foreach ($product_base_gifts as $g_g_coupon) {
                // check for product is valid or not
                $products = json_decode($g_g_coupon->product_ids);
                $coupon_details = json_decode($g_g_coupon->details);
                foreach ($carts as $key => $cartItem) {
                if ($cartItem['product_id']) {
                if (in_array($cartItem['product_id'], $products)) {
                    // check minimum buy critiria
                    if ($total >= (int) $coupon_details->min_buy) {
                        // check that not used by this user before
                        $is_used = CouponUsage::where('user_id', $user_id)->where('product_id', $cartItem['product_id'])->where('coupon_id', $g_g_coupon->id)->first();
                        if (!$is_used) {
                            // check date ranges
                            $in_range = strtotime(date('d-m-Y')) >= $g_g_coupon->start_date && strtotime(date('d-m-Y')) <= $g_g_coupon->end_date;
                            if ($in_range) {
                                // check limit
                                if ($g_g_coupon->limit > 0) {
                                    // apply coupon
                                    $gifts = json_decode($g_g_coupon->gifts, true);
                                    foreach ($gifts as $key => $gift) {
                                        $data = [
                                            'gift_coupon_id' => $g_g_coupon->id,
                                            'gift_image_id' => $key,
                                            'gift_image' => ($key) ? api_asset($key) : '',
                                            'gift_name' => $gift,
                                            'gift_title' => $g_g_coupon->discount_title,
                                            'gift_coupon_applied_product' => $cartItem['product_id']
                                        ];
                                        array_push($gifts_arr, $data);
                                    }
                                }
                            }
                        }
                    }
                }
                }
                else if ($cartItem['package_id']) {
                    $package_products = DB::table('cart_package_products')->where('package_id', $cartItem['package_id'])->where('cart_id',$cartItem['cart_id'])->select('product_id')->get();
                    foreach($package_products as $package_product){
                        if (in_array($package_product->product_id, $products)) {
                            // check minimum buy critiria
                            if ($total >= (int) $coupon_details->min_buy) {
                                // check that not used by this user before
                                $is_used = CouponUsage::where('user_id', $user_id)->where('product_id', $package_product->product_id)->where('coupon_id', $g_g_coupon->id)->first();
                                if (!$is_used) {
                                    // check date ranges
                                    $in_range = strtotime(date('d-m-Y')) >= $g_g_coupon->start_date && strtotime(date('d-m-Y')) <= $g_g_coupon->end_date;
                                    if ($in_range) {
                                        // check limit
                                        if ($g_g_coupon->limit > 0) {
                                            // apply coupon
                                            $gifts = json_decode($g_g_coupon->gifts, true);
                                            foreach ($gifts as $key => $gift) {
                                                $data = [
                                                    'gift_coupon_id' => $g_g_coupon->id,
                                                    'gift_image_id' => $key,
                                                    'gift_image' => ($key) ? api_asset($key) : '',
                                                    'gift_name' => $gift,
                                                    'gift_title' => $g_g_coupon->discount_title,
                                                    'gift_coupon_applied_product' => $package_product->product_id
                                                ];
                                                array_push($gifts_arr, $data);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                }
            }

            if ($carts[0]->gift_discount > 0) {
                $total -= $carts[0]->gift_discount;
            }
            if ($carts[0]->discount > 0) {
                $total -= $carts[0]->discount;
            }
            return [
                'products' => $products_items,
                'packages' => array_values($packages_items),
                'sub_total' => single_price($subtotal),
                'tyre_subtotal' => single_price($tyre_subtotal),
                'package_subtotal' => single_price($package_subtotal),
                'tax' => single_price($tax),
                'shipping_cost' => single_price($shipping),
                'discount' => single_price($carts[0]->discount),
                'gifts' => $gifts_arr,
                'gift_discount_title' => $discount_title,
                'gift_discount' => single_price($carts[0]->gift_discount),
                'grand_total' => single_price($total),
                'calculatable_sub_total' => $subtotal,
                'calculatable_tax' => $tax,
                'calculatable_shipping_cost' => $shipping,
                'calculatable_discount' => $carts[0]->discount,
                'gift_calculatable_discount' => (int) $carts[0]->gift_discount,
                'calculatable_grand_total' => $total,
                'calculatable_express_delivery' => get_setting('express_delivery'),
                'express_delivery' => single_price(get_setting('express_delivery')),
                'currency_sysmbol' => $currency_symbol,
            ];
        } else {
            return [];
        }
    }

    public function checkout(Request $request)
    {
        if ($request->payment_option != null) {
            $user = DB::table('users')->where('id', $request->user_id)->first();
            if (!$user->email) {
                return response()->json([
                    'result' => false,
                    'message' => 'Please verify your email address before placing an order',
                ]);
            }
            if (get_setting('email_verification') == 1 && !$user->hasVerifiedEmail()) {
                return response()->json([
                    'result' => false,
                    'message' => 'Your email should be verified before placing an order',
                ]);
            }

            $orderController = new OrderController;
            $response = $orderController->store_tyre_package_order($request, $user);
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
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Please select payment option first',
            ]);
        }
    }

    public function checkout_done($order_id, $payment_details)
    {
        $order = Order::findOrFail($order_id);
        if ($order->order_type == 'CW') {
            $car_wash_payment = CarWashPayment::where('order_id', $order->id)->where('status', 0)->first();
            $car_wash_payment->status = 1;
            $car_wash_payment->save();
            $order->delivery_status = 'delivered';
            $order->delivery_type = 'self delivery';
        }
        $order->payment_status = 'paid';
        $order->payment_details = $payment_details;
        $order->save();

        // Affiliate code
        $login_user = User::find($order->user_id);
        if ($login_user->referred_by != null && $login_user->referral_status == 0) {
            $affiliateController = new AffiliateController;
            $affiliateController->processAffiliateAmount($login_user, $order->grand_total);
        }

        if($order->order_type == 'N'){
        $carts = Cart::select('id','product_id', 'package_id')->where('is_checkout', 1)->where('user_id', $order->user_id)->get();
        foreach ($carts as $cart) {
            if ($cart->package_id) {
                DB::table('carts')->where('user_id', $order->user_id)->where('package_id', $cart->package_id)->delete();
                DB::table('cart_package_products')->where('cart_id', $cart->id)->where('package_id', $cart->package_id)->delete();
            }
            else{
                $cart->delete();
            }
        }
        }
        
        // Generate Notification to admin
        \App\Models\Notification::create([
            'user_id' => DB::table('users')->select('id')->where('user_type', 'admin')->first()->id,
            'is_admin' => 1,
            'type' => 'order',
            'body' => translate('New order has been placed') . ' - ' . $order->code,
            'order_id' => $order->id,
        ]);
        // Generate Notification to user
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'order',
            'body' => translate('New order has been placed') . ' - ' . $order->code,
            'order_id' => $order->id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('New order has been placed') . ' - ' . $order->code
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }

        // sends email to customer with the invoice pdf attached
        if (Session::has('currency_code')) {
            $currency_code = Session::get('currency_code');
        } else {
            $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        }
        $language_code = Session::get('locale', Config::get('app.locale'));

        if (\App\Models\Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $text_align = 'right';
            $not_text_align = 'left';
        } else {
            $direction = 'ltr';
            $text_align = 'left';
            $not_text_align = 'right';
        }

        if ($currency_code == 'BDT' || $language_code == 'bd') {
            // bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        } elseif ($currency_code == 'KHR' || $language_code == 'kh') {
            // khmer font
            $font_family = "'Hanuman','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
        } elseif ($currency_code == 'ILS') {
            // Israeli font
            $font_family = "'Varela Round','sans-serif'";
        } elseif ($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD') {
            // middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        } else {
            // general for all
            $font_family = "'Roboto','sans-serif'";
        }

        $array['view'] = 'emails.invoice';
        $array['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['order'] = $order;
        $array['font_family'] = $font_family;
        $array['direction'] = $direction;
        $array['text_align'] = $text_align;
        $array['not_text_align'] = $not_text_align;

        if (env('MAIL_USERNAME') != null) {
            $user = DB::table('users')->where('id', $order->user_id)->select('email')->first();
            try {
                Mail::to($user->email)->queue(new InvoiceEmailManager($array));
                Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
            } catch (\Exception $e) {
                // echo $e;
            }
        }

        // update customer point, 1 point = 1 currency unit, if have decimal point then floor it
        $adjustment = new PointsAdjustment();
        $adjustment->user_id = $order->user_id;
        $adjustment->points = floor($order->grand_total);
        $adjustment->remark = 'Order (' . $order->code . ') placed';
        $adjustment->save();

        // update customes.point_balance
        $customer = Customer::where('user_id', $order->user_id)->first();
        $customer->point_balance = PointsAdjustment::sumPointsForUser($order->user_id);
        $customer->save();
        return 1;
    }

    public function checkout_failed($order_id)
    {
        $order = Order::findOrFail($order_id);
        if ($order->order_type == 'CW') {
            CarWashPayment::where('order_id', $order->id)->delete();
        }
        if($order->order_type == 'N'){  
            foreach($order->orderDetails as $detail){
                $product = Product::where('id', $detail->product_id)->select('id','qty')->first();
                $product->qty += $detail->quantity;
                $product->update();
            }
           
        DB::table('workshop_availabilities')->where('id', $order->availability_id)->decrement('booked_appointments', 1);
        } 
        if($order->order_type == 'B' && $order->battery_type == 'N'){
            $order_detail = DB::table('order_details')->where('order_id', $order->id)->select('product_id','quantity')->first(); 
            $product = Battery::where('id', $order_detail->product_id)->select('id','stock')->first();
            $product->stock += $order_detail->quantity;
            $product->update();
        }
        DB::table('orders')->where('id',$order_id)->delete();
        DB::table('order_details')->where('order_id',$order_id)->delete();
        return 1;
    }
  
    public function reschedule_done($order_id, $data_arr, $payment_details)
    {
        $order = Order::findOrFail($order_id);
        $order->update([
            'old_workshop_date' => $order->workshop_date,
            'old_workshop_time' => $order->workshop_time,
            'workshop_date' => $data_arr['workshop_date'],
            'workshop_time' => $data_arr['workshop_time'],
            'availability_id' => $data_arr['availability_id'],
            'user_date_update' => 1
        ]);
        $payment = new Payment();
        $payment->user_id = $order->user_id;
        $payment->order_id = $order->id;
        $payment->amount = env('RESCHEDULE_FEE');
        $payment->details = $payment_details;
        $payment->type = 'reshedule';
        $payment->save();

        if($order->workshop_date_approve_status == 1){
            $order->workshop_date_approve_status = 0;
            $order->update();
        }
        // Generate Notification
    $shop = Shop::where('id',$order->seller_id)->select('user_id')->first();
    \App\Models\Notification::create([
        'user_id' => $shop->user_id,
        'is_admin' => 2,
        'type' => 'order_reschedule',
        'body' => translate('Order has been rescheduled by user'),
        'order_id' => $order_id,
    ]);
    try {
        // Send firebase notification
        $device_token = DB::table('device_tokens')->where('user_id', $shop->user_id)->select('token')->get()->toArray();
        $array = array(
            'device_token' => $device_token,
            'title' => translate('Order has been rescheduled by user')
        );
        send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        return 1;
    }
    
    public function invoice_download($order_id)
    {
        $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        $language_code = Session::get('locale', Config::get('app.locale'));

        if (\App\Models\Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $text_align = 'right';
            $not_text_align = 'left';
        } else {
            $direction = 'ltr';
            $text_align = 'left';
            $not_text_align = 'right';
        }

        if ($currency_code == 'BDT' || $language_code == 'bd') {
            // bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        } elseif ($currency_code == 'KHR' || $language_code == 'kh') {
            // khmer font
            $font_family = "'Hanuman','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
        } elseif ($currency_code == 'ILS') {
            // Israeli font
            $font_family = "'Varela Round','sans-serif'";
        } elseif ($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD') {
            // middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        } else {
            // general for all
            $font_family = "'Roboto','sans-serif'";
        }

        $order = Order::findOrFail($order_id);
        $html = view('backend.invoices.invoice', [
            'order' => $order,
            'font_family' => $font_family,
            'direction' => $direction,
            'text_align' => $text_align,
            'not_text_align' => $not_text_align
        ])->render();

        return response()->json([
            'result' => true,
            'pdf_name' => 'order-' . $order->code,
            'htmlCode' => $html,
        ]);
    }

}
