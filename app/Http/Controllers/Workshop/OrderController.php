<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shop = Shop::where('user_id', Auth::user()->id)->select('id')->first();
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $date = $request->date;
        $orders = Order::orderBy('id', 'desc')
            ->where('seller_id', $shop->id)->where('user_date_update', '!=', 1)
            ->where('order_type', 'N');

        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->done_status != null) {
            $orders = $orders->where('done_installation_status', 1)->orWhere('done_installation_status', 2);
        }
        if ($request->filled('search')) {
            $sort_search = $request->search;
            $orders = $orders->where(function ($query) use ($sort_search) {
                $query->where('code', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_plate', 'like', '%' . $sort_search . '%')
                    ->orWhere('model_name', 'like', '%' . $sort_search . '%');
            });
        }
        if ($date != null) {
            $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1] . ' +1 day')));
        }
        $orders = $orders->paginate(15);
        foreach ($orders as $key => $value) {
            $order = \App\Models\Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }
        return view('frontend.user.seller.orders', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'date'));
    }

    // Updated All Workshop Orders
    public function update_date_workshop_orders(Request $request)
    {
        $shop = Shop::where('user_id', Auth::user()->id)->select('id')->first();
        $approve_status = null;
        $sort_search = null;
        $orders = Order::orderBy('id', 'desc')
            ->where('seller_id', $shop->id)->where('user_date_update', 1)
            ->where('order_type', 'N');

        if ($request->approve_status != null) {
            $orders = $orders->where('workshop_date_approve_status', $request->approve_status);
            $approve_status = $request->approve_status;
        }
        if ($request->filled('search')) {
            $sort_search = $request->search;
            $orders = $orders->where(function ($query) use ($sort_search) {
                $query->where('code', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_plate', 'like', '%' . $sort_search . '%')
                    ->orWhere('model_name', 'like', '%' . $sort_search . '%');
            });
        }
        $orders = $orders->paginate(15);
        foreach ($orders as $key => $value) {
            $order = \App\Models\Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }
        return view('frontend.user.seller.update_date.orders', compact('orders', 'approve_status', 'sort_search'));
    }

    public function installation_list(Request $request)
    {
        $sort_search = null;
        $shop = DB::table('shops')->where('user_id', Auth::user()->id)->first();
        $orders = Order::where('order_type', 'N')->where('start_installation_status', 1)->where('seller_id', $shop->id)->orderBy('id', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders->where(function ($query) use ($sort_search) {
                    $query->where('code', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_plate', 'like', '%' . $sort_search . '%')
                    ->orWhere('model_name', 'like', '%' . $sort_search . '%');
                });
        }
        $orders = $orders->paginate(10);
        return view('frontend.user.seller.installation_list', compact('orders','sort_search'));
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.user.seller.order_details_seller', compact('order'));
    }

    public function notification_order_details($order_id, $notification_id)
    {
        DB::table('notifications')->where('id', $notification_id)->update(['is_viewed' => 1]);
        $order = Order::findOrFail($order_id);
        return view('frontend.user.seller.notification_order_details', compact('order'));
    }

    public function update_date_workshop_order_approved($id)
    {
        $order = Order::find($id);
        $order->workshop_date_approve_status = 1;
        $order->update();

        // Generate Notification
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'order_reschedule_approve',
            'body' => translate('Your request of order reschedule has been approved by workshop'),
            'order_id' => $id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Your request of order reschedule has been approved by workshop')
            );
            send_firebase_notification($array);
            } catch (\Exception $e) {
                // dd($e);
            }
        flash(translate('Reschedule request has been Approved Successfully!'))->success();
        return back();
    }

    public function notifyUserComeToWorkshop($id)
    {
        $order = Order::find($id);
        $order->notify_user_come_to_workshop_to_review_car = 1;
        $order->update();
        // Generate Notification
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'review_car',
            'body' => translate('Please come to workshop and review your car'),
            'order_id' => $id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Please come to workshop and review your car')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        flash(translate('User notified Successfully!'))->success();
        return back();
    }

}
