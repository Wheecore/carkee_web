<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\WorkshopAvailability;
use App\Mail\InvoiceEmailManager;
use App\Models\Addon;
use App\Models\Battery;
use App\Models\CarList;
use App\Models\CarModel;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shop;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function all_orders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;
        $orders = Order::orderBy('code', 'desc')->where('order_type', 'N')
        ->where('delivery_status', '!=', 'Done')
        ->where('user_date_update', '!=', 1)
        ->where('reassign_status', '!=', 2);
        if ($request->express_delivery != null) {
            $orders = $orders->where('express_delivery', '!=', null);
            $express_delivery = $request->express_delivery;
        }

        if ($request->filled('search')) {
            $sort_search = $request->search;
            $orders = $orders->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%')
                        ->orWhere('car_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }

        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $orders = $orders->paginate(15);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->admin_viewed = 1;
            $order->update();
        }
        return view('backend.sales.all_orders.index', compact('orders', 'sort_search', 'delivery_status', 'date'));
    }

    // Done Orders
    public function done_orders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;
        $orders = Order::where('order_type', 'N')->where('delivery_status', 'Done');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%')
                        ->orWhere('car_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->express_delivery != null) {
            $orders = $orders->where('express_delivery', '!=', null)->where('delivery_status', 'Done');
        }
        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $orders = $orders->orderBy('id','desc')->paginate(15);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->admin_viewed = 1;
            $order->update();
        }
        return view('backend.sales.all_orders.done_orders', compact('orders', 'sort_search', 'date'));
    }

    // Delivery Orders
    public function delivery_orders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;

        $orders = Order::where('order_type', 'N');
        // ->where('daily_delivery_status', 1)
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%')
                        ->orWhere('car_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->express_delivery != null) {
            $orders = $orders->where('express_delivery', '!=', null);
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $orders = $orders->whereDate('delivery_date', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('delivery_date', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $orders = $orders->orderBy('id','desc')->paginate(15);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->admin_viewed = 1;
            $order->update();
        }
        return view('backend.sales.all_orders.delivery_orders', compact('orders', 'sort_search', 'delivery_status', 'date'));
    }

    // updated date orders
    public function update_date_orders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;

        $orders = Order::where('order_type', 'N')->where('user_date_update', 1);
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%')
                        ->orWhere('car_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->express_delivery != null) {
            $orders = $orders->where('express_delivery', '!=', null);
            $express_delivery = $request->express_delivery;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $orders = $orders->orderBy('id', 'desc')->paginate(15);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->admin_viewed = 1;
            $order->update();
        }
        return view('backend.sales.all_orders.reshedule', compact('orders', 'sort_search', 'delivery_status', 'date'));
    }

    //reassign orders
    public function reassign_orders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;

        $orders = Order::where('order_type', 'N')->where('reassign_status', 2);
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('car_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->express_delivery != null) {
            $orders = $orders->where('express_delivery', '!=', null);
            $express_delivery = $request->express_delivery;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $orders = $orders->orderBy('id', 'desc')->paginate(15);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->admin_viewed = 1;
            $order->update();
        }

        return view('backend.sales.all_orders.reassign', compact('orders', 'sort_search', 'delivery_status', 'date'));
    }

    public function all_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        DB::table('notifications')->where('user_id', Auth::id())->where('order_id', decrypt($id))->update(['is_viewed' => 1]);
        $data['tyre_products'] = DB::table('order_details')
        ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
        ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
        ->leftJoin('users', 'users.id', '=', 'order_details.received_by')
        ->select('product_translations.name', 'products.slug', 'order_details.quantity', 'order_details.price', 'order_details.received_status', 'users.name as receiver', 'products.thumbnail_img')
        ->where('order_details.order_id', decrypt($id))
        ->where('order_details.type', 'T')
        ->get()->toArray();
        
        $data['package_products'] = DB::table('order_details')
        ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
        ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
        ->leftJoin('users', 'users.id', '=', 'order_details.received_by')
        ->select('product_translations.name', 'products.slug', 'order_details.quantity', 'order_details.price', 'order_details.received_status', 'users.name as receiver', 'products.thumbnail_img')
        ->where('order_details.order_id', decrypt($id))
        ->where('order_details.type', 'P')
        ->get()->toArray();

        $data['order'] = $order;
        $data['shop'] = DB::table('shops')->where('id', $order->seller_id)->select('name')->first();
        \QrCode::size(250)->generate(decrypt($id), public_path('images/' . decrypt($id) . '.png'));

        return view('backend.sales.all_orders.show', $data);
    }

    public function wallet_recharge_details($id)
    {
      DB::table('notifications')->where('id', decrypt($id))->update(['is_viewed' => 1]);
      $details = DB::table('notifications as n')->where('n.id', decrypt($id))
     ->leftJoin('wallets','wallets.id', 'n.wallet_id')
     ->leftJoin('users as receiver','receiver.id', 'wallets.user_id')
     ->leftJoin('users as recharger','recharger.id', 'wallets.charge_by')
     ->select('wallets.user_id','wallets.charge_by','recharger.name','recharger.email','wallets.amount', 'wallets.payment_method',
     'wallets.payment_details','wallets.created_at','wallets.type','wallets.remarks','receiver.name as receiver_name',
     'receiver.email as receiver_email')
     ->first();

    return view('backend.notifications.wallet_recharge_details', compact('details'));
    }

    // Emergency battery orders
    public function batteryOrders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;

        $orders = DB::table('orders')->where('orders.order_type', 'B')
            ->orderBy('orders.code', 'desc')
            ->select('id', 'username', 'code', 'created_at', 'battery_type', 'delivery_status', 'grand_total', 'model_name', 'arrival_minutes', 'order_schedule_time');
        if ($request->filled('search')) {
            $sort_search = $request->search;
            $orders = $orders
                ->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }

        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $orders = $orders->paginate(15);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->admin_viewed = 1;
            $order->update();
        }
        return view('backend.emergency_orders.battery_orders.index', compact('orders', 'sort_search', 'delivery_status', 'date'));
    }

    public function batteryOrderShow($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $activation_image = DB::table('battery_activation_images')->where('order_id', decrypt($id))->select('image','user_id')->first();
        DB::table('notifications')->where('user_id', Auth::id())->where('order_id', decrypt($id))->update(['is_viewed' => 1]);
        return view('backend.emergency_orders.battery_orders.show', compact('order','activation_image'));
    }

    // Emergency tyre orders
    public function tyreOrders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;

        $orders = DB::table('orders')->where('orders.order_type', 'T')
            ->orderBy('orders.code', 'desc')
            ->select('id', 'username', 'code', 'created_at', 'delivery_status', 'grand_total', 'model_name', 'arrival_minutes', 'order_schedule_time');
        if ($request->filled('search')) {
            $sort_search = $request->search;
            $orders = $orders
                ->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }

        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $orders = $orders->paginate(15);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->admin_viewed = 1;
            $order->update();
        }
        return view('backend.emergency_orders.tyre_orders.index', compact('orders', 'sort_search', 'delivery_status', 'date'));
    }

    public function tyreOrderShow($id)
    {
        $order = Order::findOrFail(decrypt($id));
        DB::table('notifications')->where('user_id', Auth::id())->where('order_id', decrypt($id))->update(['is_viewed' => 1]);
        return view('backend.emergency_orders.tyre_orders.show', compact('order'));
    }

    // Emergency petrol orders
    public function petrolOrders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;

        $orders = DB::table('orders')->where('orders.order_type', 'P')
            ->orderBy('orders.code', 'desc')
            ->select('id', 'username', 'code', 'created_at', 'delivery_status', 'grand_total', 'model_name', 'arrival_minutes', 'order_schedule_time');
        if ($request->filled('search')) {
            $sort_search = $request->search;
            $orders = $orders
                ->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }

        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $orders = $orders->paginate(15);
        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->admin_viewed = 1;
            $order->update();
        }
        return view('backend.emergency_orders.petrol_orders.index', compact('orders', 'sort_search', 'delivery_status', 'date'));
    }

    public function petrolOrderShow($id)
    {
        $order = Order::findOrFail(decrypt($id));
        DB::table('notifications')->where('user_id', Auth::id())->where('order_id', decrypt($id))->update(['is_viewed' => 1]);
        return view('backend.emergency_orders.petrol_orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $order = new Order;
        if (Auth::check()) {
            $login_user = Auth::user();
            $order->user_id = $login_user->id;
            $order->username = $login_user->name;
        }

        $carts = Cart::where('id', Session::get('session_cart_id'))
            ->where('user_id', $login_user->id)
            ->where('owner_id', $request->owner_id)
            ->get();

        //        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        //        $shipping_info->name = $login_user->name;
        //        $shipping_info->email = $login_user->email;
        $order->seller_id = $request->seller_id;
        $order->brand_id = Session::get('session_brand_id');
        $order->model_id = Session::get('session_model_id');
        $order->details_id = Session::get('session_details_id');
        $order->year_id = Session::get('session_year_id');
        $order->type_id = Session::get('session_type_id');
        $order->availability_id = $request->availability_id;

        $model = CarModel::where('id', Session::get('session_model_id'))->first();
        $carlist = '';
        if ($model && Session::get('session_details_id') && Session::get('session_year_id') && Session::get('session_type_id')) {
            $carlist = CarList::where('model_id', $model->id)->where('brand_id', $model->brand_id)->where('details_id', Session::get('session_details_id'))->where('year_id', Session::get('session_year_id'))->where('type_id', Session::get('session_type_id'))->where('user_id', Auth::id())->first();
        } else if ($model && Session::get('session_details_id') && Session::get('session_year_id')) {
            $carlist = CarList::where('model_id', $model->id)->where('brand_id', $model->brand_id)->where('details_id', Session::get('session_details_id'))->where('year_id', Session::get('session_year_id'))->where('user_id', Auth::id())->first();
        } else if ($model && Session::get('session_details_id')) {
            $carlist = CarList::where('model_id', $model->id)->where('brand_id', $model->brand_id)->where('details_id', Session::get('session_details_id'))->where('user_id', Auth::id())->first();
        } else if ($model) {
            $carlist = CarList::where('model_id', $model->id)->where('brand_id', $model->brand_id)->where('user_id', Auth::id())->first();
        }
        $order->car_plate = $carlist ? $carlist->car_plate : '';
        $order->model_name = $model ? $model->name : '';

        $order->workshop_date = $request->workshop_date;
        $order->workshop_time = $request->workshop_time;
        //        $order->shipping_address = json_encode($shipping_info);

        $order->payment_type = $request->payment_option;
        $order->code = date('Ymd-His') . rand(10, 99);
        $order->date = strtotime(date('Y-m-d H:i:s'));

        $express_delivery = Session::get('express_delivery');
        $order->express_delivery = $express_delivery;  

        if ($order->save()) {
            Session::forget('express_delivery');

            $subtotal = 0;
            $tax = 0;
            $shipping = 0;

            //calculate shipping is to get shipping costs of different types
            $admin_products = array();
            $seller_products = array();

            //Order Details Storing
            foreach ($carts as $key => $cartItem) {
                $product = Product::find($cartItem['product_id']);

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

                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];

                    if ($cartItem['quantity'] > $product->qty) {
                        flash(translate('The requested quantity is not available for ') . $product->getTranslation('name'))->warning();
                        $order->delete();
                        return redirect()->route('cart')->send();
                    } else{
                        $product->qty -= $cartItem['quantity'];
                        $product->save();
                    }

                $shop = Shop::where('id', $request->seller_id)->first();

                $order_detail = new OrderDetail();
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

                $shipping += $order_detail->shipping_cost;

                if ($cartItem['shipping_type'] == 'pickup_point') {
                    $order_detail->pickup_point_id = $cartItem['pickup_point'];
                }
                //End of storing shipping cost

                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();

                $product->num_of_sale++;
                $product->save();
            }

            $order->grand_total = $subtotal + $express_delivery + $tax + $shipping;

            if ($carts->first()->coupon_code != '') {
                $order->grand_total -= $carts->sum('discount');
                $order->coupon_discount = $carts->sum('discount');
                $limit_coupon = Coupon::where('code', $carts->first()->coupon_code)->first();
                if ($limit_coupon->limit > 0) {
                    $limit_coupon->update([
                        'limit' => $limit_coupon->limit - 1
                    ]);
                }

                $coupon_usage = new CouponUsage();
                $coupon_usage->user_id = $login_user->id;
                $coupon_usage->coupon_id = Coupon::where('code', $carts->first()->coupon_code)->first()->id;
                $coupon_usage->save();
            }

            $order->save();
            if ($request->availability_id) {
                //now update the shop availability
                $shop = WorkshopAvailability::where('id', $request->availability_id)->first();
                $shop->booked_appointments += 1;
                $shop->save();
            }
            $array['view'] = 'emails.invoice';
            $array['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['order'] = $order;

            foreach ($seller_products as $key => $seller_product) {
                try {
                    Mail::to(\App\User::find($key)->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {
                }
            }

            //sends email to customer with the invoice pdf attached
            if (env('MAIL_USERNAME') != null) {
                try {
                    Mail::to($login_user->email)->queue(new InvoiceEmailManager($array));
                    Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {
                }
            }

            $request->session()->put('order_id', $order->id);
        }
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
        if($order->order_type == 'N'){
        if($order->delivery_status != 'Done'){
            foreach ($order->orderDetails as $key => $orderDetail) {
                try {
                    $product = Product::where('id', $orderDetail->product_id)->first();
                    if ($product != null) {
                        $product->qty += $orderDetail->quantity;
                        $product->update();
                    }
                } catch (\Exception $e) {
                }
            }
        }
        DB::table('rating_orders')->where('order_id', $id)->delete();
        DB::table('reviews')->where('order_id', $id)->delete();
        DB::table('user_car_conditions')->where('order_id', $id)->delete();
        }
        else{
            if($order->order_type == 'B'){
                if($order->delivery_status != 'completed'){
                if($order->battery_type == 'N'){
                    foreach ($order->orderDetails as $orderDetail) {
                        try {
                            $battery_stock = Battery::where('id', $orderDetail->product_id)->first();
                            if ($battery_stock != null) {
                                $battery_stock->stock += $orderDetail->quantity;
                                $battery_stock->update();
                            }
                        } catch (\Exception $e) {
                        }
                    }
                }
            }
            }
        }

        $order->delete();
        DB::table('order_details')->where('order_id', $id)->delete();
        DB::table('notifications')->where('order_id', $id)->delete();
        flash(translate('Order has been deleted successfully'))->success();
        }
        else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function bulk_order_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $order_id) {
                $this->destroy($order_id);
            }
        }

        return 1;
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::find($request->order_id);
        if($request->status){
            $order->delivery_status = $request->status;
        }
        $order->arrival_minutes = $request->minutes;
        if($request->delivery_type){
            $order->delivery_type = $request->delivery_type;
        }
        $order->update();
        if ($request->status == 'cancelled') {
        foreach ($order->orderDetails as $orderDetail) {
            $product = Product::where('id', $orderDetail->product_id)->first();
            if ($product != null) {
                $product->qty += $orderDetail->quantity;
                $product->update();
            }
        }
        }
           
        // Generate Notification to customer
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'order',
            'body' => translate('Your order status has been updated') . ' - ' . $request->status,
            'order_id' => $order->id,
        ]);
        try {
            // Send firebase notification to customer
            $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Your order status has been updated') . ' - ' . $request->status
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        
        if($order->order_type == "N")
        {
        // Generate Notification to workshop
        $shop = Shop::where('id',$order->seller_id)->select('user_id')->first();
        \App\Models\Notification::create([
            'user_id' => $shop->user_id,
            'is_admin' => 2,
            'type' => 'order',
            'body' => translate('Your order status has been updated') . ' - ' . $request->status,
            'order_id' => $order->id,
        ]);
         try {
            // Send firebase notification to workshop
            $device_token = DB::table('device_tokens')->where('user_id', $shop->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Your order status has been updated') . ' - ' . $request->status
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        }
        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status = 'paid';
        $order->save();
        return 1;
    }

    public function delivery_type(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->update([
            $order->delivery_type = $request->status
        ]);
        return 1;
    }

    public function assign_delivery_boy(Request $request)
    {
        if (
            Addon::where('unique_identifier', 'delivery_boy')->first() != null &&
            Addon::where('unique_identifier', 'delivery_boy')->first()->activated
        ) {

            $order = Order::findOrFail($request->order_id);
            $order->assign_delivery_boy = $request->delivery_boy;
            $order->delivery_history_date = date("Y-m-d H:i:s");
            $order->save();

            if (env('MAIL_USERNAME') != null && get_setting('delivery_boy_mail_notification') == '1') {
                $array['view'] = 'emails.invoice';
                $array['subject'] = translate('You are assigned to delivery an order. Order code') . ' - ' . $order->code;
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['order'] = $order;

                try {
                    Mail::to($order->delivery_boy->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {
                }
            }
        }

        return 1;
    }

    public function updateNofityWorkshopOrder($order_id)
    {
        $user_nf = 1;
        $user = User::where('id', Auth::id())->first();
        $order = Order::where('id', $order_id)->first();
        DB::table('orders')->where('id', $order_id)->update([
            'notify_user_come_to_workshop_to_review_car' => 2
        ]);
        $shop = DB::table('shops')->where('id', $order->seller_id)->first();
        $cc = DB::table('user_car_conditions')->where('order_id', $order_id)->first();
        return view('frontend.user.user_shop_address', compact('user', 'order', 'shop', 'user_nf', 'cc'));
    }

    public function payment_charges(Request $request, $id)
    {
        $order = OrderDetail::where('order_id', $id)->first();
        $product = Product::find($order->product_id);
        Session::put('order_id', $order->order_id);
        Session::put('product_id', $product->id);
        Session::put('wdate', $request->wdate);
        Session::put('wtime', $request->wtime);
        Session::put('availability_id', $request->availability_id);
        Session::put('date_change_request', 1);
        return view('frontend.payment_charges', compact('product'));
    }
}
