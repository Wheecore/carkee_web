<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function reschedule(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $categories = Category::all();
        $shops          =       DB::table("shops");
        $latitude = $shops->count() ? $shops->average('latitude') : 51.5073509;
        $longitude = $shops->count() ? $shops->average('longitude') : -0.12775829999998223;
        $shops          =       $shops->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                                + sin(radians(" . $latitude . ")) * sin(radians(latitude))) AS distance"));
        $shops          =       $shops->having('distance', '<', 25);
        $shops          =       $shops->orderBy('distance', 'asc');
        $mapShops          =       $shops->get();
        
        $order_items = DB::table('order_details')->where('order_id', $order_id)->select('product_id')->get();
        Session::put('reassign_status', 'yes');
        Session::put('order_items', $order_items);
        return view('frontend.reschedule', compact('categories', 'mapShops', 'latitude', 'longitude', 'order_id'));
    }

    public function rescheduleUpdate(Request $request, $id)
    {
        $order = Order::find($id);
        $newPost = $order->replicate();
        $newPost->reassign_date = Carbon::now();
        $newPost->save();

        $newPost->update([
            'seller_id' => $request->shop_id,
            'reassign_status' => 2,
            'old_workshop_id' => $order->seller_id,
            'workshop_date' => $request->selected_date,
            'workshop_time' => $request->selected_time,
            'availability_id' => $request->availability_id,
            'old_workshop_date' => $order->workshop_date,
            'old_workshop_time' => $order->workshop_time
        ]);
        // Generate Notification
        $shop_user_id = DB::table('shops')->where('id', $request->shop_id)->first()->user_id;
        \App\Models\Notification::create([
            'user_id' => $shop_user_id,
            'is_admin' => 2,
            'type' => 'return_products',
            'body' => translate('Please return order products to Warehouse'),
            'order_id' => $newPost->id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $shop_user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Please return order products to Warehouse')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        OrderDetail::where('order_id', $id)->update(['order_id' => $newPost->id]);
        $order->delete();
        Session::forget('reassign_status');
        Session::forget('order_items');
        flash(translate("Order Reschedule Successfully!"))->success();
        return redirect('/');
    }
}
