<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarWashPayment;
use App\Models\CarWashProduct;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarWashesController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $car_washes = CarWashProduct::leftJoin('uploads', 'uploads.id', '=', 'car_wash_products.upload_id')->orderBy('car_wash_products.created_at', 'desc');
        if ($request->search != null) {
            $car_washes = $car_washes->where('car_wash_products.name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        $car_washes = $car_washes->select('uploads.file_name', 'car_wash_products.*')->paginate(15);

        return view('backend.product.car_washes.index', compact('car_washes', 'sort_search'));
    }

    public function create()
    {
        $data['categories'] = DB::table('car_wash_categories')->select('id', 'name')->get()->toArray();
        return view('backend.product.car_washes.create', $data);
    }

    public function store(Request $request)
    {
        $car_wash = new CarWashProduct;
        $car_wash->user_id = Auth::user()->id;
        $car_wash->category_id = $request->category_id;
        // $car_wash->ptype = $request->ptype;
        $car_wash->type = json_encode($request->type);
        $car_wash->name = $request->name;
        $car_wash->upload_id = $request->upload_id;
        $car_wash->description = $request->description;
        $car_wash->amount = $request->amount;
        $car_wash->membership_fee = $request->membership_fee;
        $car_wash->usage_limit = $request->usage_limit;
        $car_wash->warranty = $request->warranty;
        $car_wash->save();

        flash(translate('Car Wash product has been inserted successfully'))->success();
        return redirect(route('car-washes.index'));
    }

    public function show($id)
    {
        $car_wash = CarWashProduct::find($id);
        if ($car_wash->delete()) {
            flash(translate('Product has been deleted successfully'))->success();
            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function edit($id)
    {
        $car_wash = CarWashProduct::findOrFail(decrypt($id));
        $data['categories'] = DB::table('car_wash_categories')->select('id', 'name')->get()->toArray();
        $data['car_wash'] = $car_wash;

        return view('backend.product.car_washes.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $car_wash = CarWashProduct::findOrFail($id);
        $car_wash->user_id = Auth::user()->id;
        $car_wash->category_id = $request->category_id;
        // $car_wash->ptype = $request->ptype;
        $car_wash->type = json_encode($request->car_type);
        $car_wash->name = $request->name;
        $car_wash->upload_id = $request->upload_id;
        $car_wash->description = $request->description;
        $car_wash->amount = $request->amount;
        $car_wash->membership_fee = $request->membership_fee;
        $car_wash->usage_limit = $request->usage_limit;
        $car_wash->warranty = $request->warranty;
        $car_wash->save();

        flash(translate('Car Wash product has been updated successfully'))->success();
        return redirect(route('car-washes.index'));
    }

    public function memberships(Request $request)
    {
        $data['sort_search'] = null;
        $memberships = DB::table('car_wash_memberships as m')
            ->join('users as u', 'u.id', '=', 'm.user_id');
        if ($request->filled('search')) {
            $sort_search = $request->search;
            $data['sort_search'] = $request->search;
            $memberships = $memberships->where(function ($query) use ($sort_search) {
                $query->where('u.name', 'like', '%' . $sort_search . '%')->orWhere('u.email', 'like', '%' . $sort_search . '%')->orWhere('m.car_plate', 'like', '%' . $sort_search . '%')->orWhere('u.phone', 'like', '%' . $sort_search . '%');
            });
        }
        $data['memberships'] = $memberships->select('m.id', 'u.name', 'u.email', 'u.phone', 'm.car_plate', 'm.amount', 'm.created_at')
            ->orderBy('m.id', 'desc')
            ->paginate(15);
        return view('backend.product.car_washes.memberships.index', $data);
    }

    public function membership_details($id)
    {
        $data['membership'] = DB::table('car_wash_memberships as m')
            ->join('users as u', 'u.id', '=', 'm.user_id')
            ->select('m.id', 'm.user_id', 'u.name', 'u.email', 'u.phone', 'm.car_plate', 'm.amount', 'm.created_at')
            ->where('m.id', decrypt($id))
            ->first();
        if ($data['membership']) {
            $data['payments'] = DB::table('car_wash_payments as p')
                ->leftJoin('car_wash_products as wp', 'wp.id', 'p.car_wash_product_id')
                ->select('p.id', 'wp.name as product', 'wp.ptype', 'p.usage_limit', 'p.used_usage_limit', 'p.amount', 'p.membership_fee', 'p.car_plate', 'p.model_name', 'p.warranty', 'p.status', 'p.updated_at', 'p.created_at')
                ->where('p.user_id', $data['membership']->user_id)
                ->where('p.car_plate', $data['membership']->car_plate)
                ->where('p.status', 1)
                ->orderBy('p.id', 'desc')
                ->get()
                ->toArray();
            return view('backend.product.car_washes.memberships.show', $data);
        } else {
            return abort(404);
        }
    }

    public function get_carwash_usage_update(Request $request)
    {
        DB::table('car_wash_payments')->where('id', $request->id)->update(['usage_limit' => $request->usage_limit]);
        flash(translate('Car Wash subscription updated successfully'))->success();
        return back();
    }

    public function payments(Request $request)
    {
        $data['sort_search'] = null;
        $payments = DB::table('car_wash_payments as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->leftJoin('car_wash_products as wp', 'wp.id', 'p.car_wash_product_id');
    
        if ($request->has('search')) {
            $sort_search = $request->search;
            $data['sort_search'] = $sort_search;
            $payments = $payments->where(function ($query) use ($sort_search) {
                $query->where('u.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('u.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('p.model_name', 'like', '%' . $sort_search . '%')
                    ->orWhere('wp.name', 'like', '%' . $sort_search . '%');
            });
        }
        $payments = $payments->select('p.id', 'u.name', 'u.email', 'wp.name as product', 'wp.ptype', 'p.usage_limit',
        'p.used_usage_limit', 'p.amount', 'p.membership_fee', 'p.car_plate', 'p.model_name', 'p.warranty', 'p.status',
        'p.updated_at', 'p.created_at')
        ->orderBy('p.id', 'desc')
        ->paginate(15);
        $data['payments'] = $payments;
        return view('backend.product.car_washes.payments.index', $data);
    }

    public function warranty_card($id)
    {
        $data['payment'] = DB::table('car_wash_payments as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->leftJoin('car_wash_products as wp', 'wp.id', 'p.car_wash_product_id')
            ->select('p.id', 'p.car_plate', 'u.name', 'u.email', 'p.model_name', 'p.warranty', 'p.updated_at')
            ->orderBy('p.id', 'desc')
            ->where('p.id', decrypt($id))
            ->first();
        return view('backend.product.car_washes.payments.warranty-card', $data);
    }

    public function usages(Request $request)
    {
        $rating = $request->rating;
        $search = $request->search;
        $data['rating'] = $rating;
        $data['search'] = $search;
        $data['usages'] = DB::table('car_wash_usages as wu')
            ->join('users as u', 'u.id', '=', 'wu.user_id')
            ->join('car_wash_payments as p', 'p.id', 'wu.car_wash_payment_id')
            ->leftJoin('car_wash_products as wp', 'wp.id', 'p.car_wash_product_id')
            ->select('wu.id', 'u.name', 'u.email', 'wp.name as product', 'p.car_plate', 'p.model_name', 'wu.rating', 'wu.review', 'wu.created_at')
            ->when(($rating), function ($q) use ($rating) {
                return $q->orderBy('wu.rating', ($rating == 5 ? 'desc' : 'asc'));
            })
            ->when(($search), function ($q) use ($search) {
                return $q->where('wp.name', 'LIKE', $search . '%')->orWhere('p.car_plate', 'LIKE', $search . '%')->orWhere('u.name', 'LIKE', $search . '%');
            })
            ->orderBy('u.id', 'desc')
            ->paginate(10);
        return view('backend.product.car_washes.usages.index', $data);
    }

    public function orders(Request $request)
    {
        $date = $request->date;
        $sort_search = null;

        $orders = DB::table('orders')->where('orders.order_type', 'CW')
            ->orderBy('orders.code', 'desc')
            ->select('id', 'username', 'code', 'created_at', 'battery_type', 'payment_status', 'grand_total', 'model_name');
        if ($request->filled('search')) {
            $sort_search = $request->search;
            $orders = $orders
                ->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                        ->orWhere('username', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
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
        return view('backend.product.car_washes.orders.index', compact('orders', 'sort_search', 'date'));
    }

    public function ordersShow($id)
    {
        $data['order'] = Order::findOrFail(decrypt($id));
        DB::table('notifications')->where('user_id', Auth::id())->where('order_id', decrypt($id))->update(['is_viewed' => 1]);
        return view('backend.product.car_washes.orders.show', $data);
    }

    public function add_order()
    {
        $data['users'] = DB::table('users')->select('id', 'name', 'email')->where('user_type', 'customer')->get()->toArray();
        return view('backend.product.car_washes.orders.add-new-order', $data);
    }

    public function get_user_carlist(Request $request)
    {
        $car_lists = DB::table('car_lists')->select('id', 'car_plate', 'brand_id', 'model_id')->where('user_id', $request->user_id)->get()->toArray();
        $html = '<option value="">' . translate('Choose') . '</option>';
        foreach ($car_lists as $car_list) {
            $html .= '<option value="' . $car_list->id . '" data-brand="' . $car_list->brand_id . '" data-model="' . $car_list->model_id . '">' . $car_list->car_plate . '</option>';
        }
        return $html;
    }

    public function get_carwash_products_on_carlist(Request $request)
    {
        $products = DB::table('car_wash_products')->select('id', 'name', 'ptype', 'amount', 'membership_fee', 'usage_limit')->whereJsonContains('car_brand_id', $request->brand_id)->whereJsonContains('car_model_id', $request->model_id)->get()->toArray();
        $html = '<option value="">' . translate('Choose') . '</option>';
        foreach ($products as $product) {
            $html .= '<option value="' . $product->id . '" data-ptype="' . $product->ptype . '" data-amount="' . $product->amount . '" data-membership="' . $product->membership_fee . '" data-usage="' . $product->usage_limit . '">' . $product->name . '</option>';
        }
        return $html;
    }

    public function store_order(Request $request)
    {
        $user = DB::table('users')->select('name')->where('id', $request->user_id)->first();
        $carlist = DB::table('car_lists')->select('id', 'brand_id', 'model_id', 'car_plate')->where('id', $request->carlist_id)->first();
        $product = DB::table('car_wash_products')->select('id', 'warranty')->where('id', $request->car_wash_product_id)->first();
        $car_model = DB::table('car_models')->select('name')->where('id', $carlist->model_id)->first();

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->username = $user->name;
        $order->carlist_id = $carlist->id;
        $order->brand_id = $carlist->brand_id;
        $order->model_id = $carlist->model_id;
        $order->order_type = 'CW';
        $order->seller_id = $request->user_id;
        $order->model_name = $car_model->name;
        $order->car_plate = $carlist->car_plate;
        $order->location = json_encode(['lat' => $request->latitude, 'long' => $request->longitude, 'loc' => $request->location]);
        $order->delivery_status = 'delivered';
        $order->payment_status = 'paid';
        $order->payment_status = 'paid';
        $order->payment_details = '{"status":"Success"}';
        $order->delivery_type = 'self delivery';
        $order->workshop_date = now();
        $order->workshop_time = now();
        $order->payment_type = 'FREE';
        $order->code = date('Ymd-His') . rand(10, 99);
        $order->date = strtotime(date('Y-m-d H:i:s'));
        if ($order->save()) {
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            $subtotal += 0;
            $tax += 0;

            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->seller_id = $request->user_id;
            $order_detail->product_id = $product->id;
            $order_detail->price = 0;
            $order_detail->tax = 0;
            $order_detail->shipping_type = 'Car Wash';
            $order_detail->shipping_cost = 0;
            $shipping += $order_detail->shipping_cost;
            $order_detail->quantity = 1;
            $order_detail->type = 'C';

            $order_detail->save();
            $order->grand_total = $subtotal + $tax + $shipping;

            // Car wash payments
            $car_wash_payment = new CarWashPayment();
            $car_wash_payment->car_wash_product_id = $product->id;
            $car_wash_payment->carlist_id = $carlist->id;
            $car_wash_payment->order_id = $order->id;
            $car_wash_payment->user_id = $request->user_id;
            $car_wash_payment->usage_limit = $request->usage_limit;
            $car_wash_payment->amount = 0;
            $car_wash_payment->membership_fee = 0;
            $car_wash_payment->warranty = $product->warranty;
            $car_wash_payment->car_plate = $carlist->car_plate;
            $car_wash_payment->model_name = $car_model->name;
            $car_wash_payment->status = 1;
            $car_wash_payment->save();

            $order->save();
        }

        flash(translate('Car Wash subsciprtion added successfully'))->success();
        return back();
    }
}
