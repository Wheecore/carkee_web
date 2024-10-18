<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Battery;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QRController extends Controller
{
    public function downloadQRCode(Request $request, $type)
    {
        $imageName = 'qr-code-'.$request->order_id.'.png';
        if(!file_exists(public_path().'/qr-codes/'.$imageName)){
        $type  = $type == 'jpg' ? 'png' : $type;
        \QrCode::format($type)
            ->size(200)->errorCorrection('H')
            ->margin(2)
            ->generate($request->order_id, public_path().'/qr-codes/'.$imageName);
        }
        return response()->download(public_path('qr-codes/'.$imageName)); 
    }
    public function downloadBatteryQRCode($type, $order_id)
    {
        $imageName = 'qr-code-battery-'.$order_id.'.png';
        if(!file_exists(public_path().'/qr-codes/'.$imageName)){
        $type  = $type == 'jpg' ? 'png' : $type;
        \QrCode::format($type)
            ->size(200)->errorCorrection('H')
            ->margin(2)
            ->generate($order_id, public_path().'/qr-codes/'.$imageName);
        }
        return response()->download(public_path('qr-codes/'.$imageName)); 
    }
    public function downloadUserQrcode(Request $request, $type)
    {
        $order = Order::where('id', $request->order_id)->first();
        $imageName = 'qr-code-web-'.$order->user_id.'-'.$request->order_id.'.png';
        if(!file_exists(public_path().'/qr-codes/'.$imageName)){
        $type  = $type == 'jpg' ? 'png' : $type;
        $user_order = $order->user_id . '/' . $request->order_id;
        \QrCode::format($type)
            ->size(200)->errorCorrection('H')
            ->margin(2)
            ->generate($user_order, public_path().'/qr-codes/'.$imageName);
        }
        return response()->download(public_path('qr-codes/'.$imageName));
    }

    public function user_address($order_id)
    {
        $user_nf = 0;
        $user = User::where('id', Auth::id())->first();
        $order = Order::where('id', $order_id)->first();
        $shop = DB::table('shops')->where('id', $order->seller_id)->first();

        return view('frontend.user.user_shop_address', compact('user', 'order', 'shop', 'user_nf'));
    }
    public function user_notify($order_id)
    {
        $user_nf = 1;
        $user = User::where('id', Auth::id())->first();
        $order = Order::where('id', $order_id)->first();
        $shop = DB::table('shops')->where('id', $order->seller_id)->first();
        $cc = DB::table('user_car_conditions')->where('order_id', $order_id)->first();
        return view('frontend.user.user_shop_address_order_details', compact('user', 'order', 'shop', 'user_nf', 'cc'));
    }
    public function user_notify_carlist($order_id)
    {
        $user_nf = 1;
        $user = User::where('id', Auth::id())->first();
        $order = Order::where('id', $order_id)->first();
        $shop = DB::table('shops')->where('id', $order->seller_id)->first();
        $cc = DB::table('user_car_conditions')->where('order_id', $order_id)->first();
        return view('frontend.user.user_shop_address_order_details', compact('user', 'order', 'shop', 'user_nf', 'cc'));
    }
    public function day_alert($order_id)
    {
        $user_nf = 1;
        $user = User::where('id', Auth::id())->first();
        $order = Order::where('id', $order_id)->first();
        $shop = DB::table('shops')->where('id', $order->seller_id)->first();
        $cc = DB::table('user_car_conditions')->where('order_id', $order_id)->first();
        return view('frontend.user.user_shop_address', compact('user', 'order', 'shop', 'user_nf', 'cc'));
    }
    public function hour_alert($order_id)
    {
        $user_nf = 1;
        $user = User::where('id', Auth::id())->first();
        $order = Order::where('id', $order_id)->first();
        $shop = DB::table('shops')->where('id', $order->seller_id)->first();
        $cc = DB::table('user_car_conditions')->where('order_id', $order_id)->first();
        return view('frontend.user.user_shop_address', compact('user', 'order', 'shop', 'user_nf', 'cc'));
    }

}
