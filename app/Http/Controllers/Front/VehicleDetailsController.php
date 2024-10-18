<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CarList;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleDetailsController extends Controller
{
    public function index(Request $request, $id)
    {
        $condition = null;
        $existing_car_lists = [];
        $list = CarList::where('id', $id)->first();
        $order = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('brand_id', $list->brand_id)->where('model_id', $list->model_id)
            ->where('details_id', $list->details_id)->where('year_id', $list->year_id)
            ->first();
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'asc')->where('brand_id', $list->brand_id)->where('model_id', $list->model_id)
            ->where('details_id', $list->details_id)->where('year_id', $list->year_id)->limit(2)
            ->get();
        return view('frontend.vehicle_details', compact('list', 'existing_car_lists', 'condition', 'order', 'orders'));
    }

}
