<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class QRController extends Controller
{
  public function scanQrcode()
  {
    return view('frontend.user.scan_qrcode');
  }

  public function showOrder($id)
  {
    $order = Order::where('id', $id)->first();
    return view('frontend.user.order', compact('order'));
  }

  public function showUserOrder($user_id, $order_id)
  {
    $chk_shop = DB::table('shops')->where('user_id', Auth::id())->first();
    $order = Order::where('id', $order_id)->first();
    if ($chk_shop->id == $order->seller_id) {
      $tyre_products = DB::table('order_details')
        ->where('order_details.order_id', $order_id)
        ->where('order_details.type', 'T')
        ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
        ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
        ->select('product_translations.name', 'order_details.quantity', 'products.thumbnail_img')
        ->get();
      $package_products = DB::table('order_details')
        ->where('order_details.order_id', $order_id)
        ->where('order_details.type', 'P')
        ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
        ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
        ->select('product_translations.name', 'order_details.quantity', 'products.thumbnail_img')
        ->get();
      return view('frontend.user.match_order', compact('order', 'tyre_products', 'package_products'));
    } else {
      // Generate Notification
      \App\Models\Notification::create([
        'user_id' => $order->user_id,
        'is_admin' => 3,
        'type' => 'notify_address',
        'body' => translate('The order address has been changed'),
        'order_id' => $order_id,
      ]);
      try {
        // Send firebase notification
        $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
        $array = array(
          'device_token' => $device_token,
          'title' => translate('The order address has been changed')
        );
        send_firebase_notification($array);
      } catch (\Exception $e) {
        // dd($e);
      }
      flash(translate('User Not Matched To Workshop!'))->info();
      return back();
    }
  }

  public function viewOrder($id, $notification_id = 0)
  {
    if ($notification_id != 0) {
      DB::table('notifications')->where('id', $notification_id)->update([
        'is_viewed' => 1
      ]);
    }
    $order = Order::where('id', $id)->first();
    return view('frontend.user.order', compact('order'));
  }

  public function receivedOrder($id)
  {
    OrderDetail::where('id', $id)->update(['received_status' => 'Received']);
    flash(translate('Product has been received successfully'))->success();
    return back();
  }

  public function confirmOrder($id)
  {
    $order = Order::where('id', $id)->first();
    // Generate Notification
    \App\Models\Notification::create([
      'user_id' => $order->user_id,
      'is_admin' => 3,
      'type' => 'notify_user',
      'body' => translate('The order has reached to workshop'),
      'order_id' => $id,
    ]);
    try {
      // Send firebase notification
      $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
      $array = array(
        'device_token' => $device_token,
        'title' => translate('The order has reached to workshop')
      );
      send_firebase_notification($array);
    } catch (\Exception $e) {
      // dd($e);
    }
    $order->delivery_status = 'Confirmed';
    $order->save();

    flash(translate('User notified successfully'))->success();
    return redirect()->back();
  }

  public function rejectOrder(Request $request, $id)
  {
    $order = Order::where('id', $id)->first();
    $order->delivery_status = 'Rejected';
    $order->reason = $request->reason;
    $order->save();
    flash(translate('Order rejected successfully'))->success();
    return redirect()->back();
  }

  public function showDO($id)
  {
    // use second database to get order details
    $data['order'] = DB::connection('mysql_secondary')->table('orders')
      ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
      ->leftJoin('users as staff', 'staff.id', '=', 'orders.user_id')
      ->select(
        // all columns
        // 'orders.*',
        'customers.code as customer_code',
        'customers.name',
        'staff.name as staff',
        'customers.company_phone',
        'customers.pic_name',
        'customers.pic_phone',
        'customers.address',
        'orders.id',
        'orders.user_id',
        'orders.customer_id',
        'orders.code',
        'orders.payment_term',
        'orders.payment_due_date',
        'orders.customer_po_no',
        'orders.do_no',
        'orders.total',
        'orders.status',
        DB::raw('DATE_FORMAT(`orders`.created_at, "%Y-%m-%d") as created_at')
      )
      ->where('orders.code', $id)
      ->first();  // Assign the result to $data['order']
      
      // Check if order exists
      if (!$data['order']) {
        return response()->json(['error' => 'Order not found'], 404);
      }
      
      // Fetch the order items
      $data['order_items'] =  DB::connection('mysql_secondary')->table('order_items')
      ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
      ->select(
        'products.name',
        'order_items.qty',
        'order_items.foc',
        'order_items.uom',
        'order_items.disc',
        'order_items.amount',
        'order_items.order_id',
        )
        ->where('order_items.order_id', $data['order']->id)
        ->get()
        ->toArray();
        // print_r($data['order_items']);
        
    // Generate the QR code in SVG format
    $qrCodeData = [
      'order_code' => $data['order']->code,
      'customer_name' => $data['order']->name,
      'total_amount' => $data['order']->total,
      'payment_due_date' => $data['order']->payment_due_date,
    ];

    $qrCode = QrCode::format('svg')->size(100)->generate(json_encode($qrCodeData));
    // put the qr code at public folder
    $qrCodePath = public_path('/qr-codes/' . $data['order']->code .  time() . '.svg');
    file_put_contents($qrCodePath, $qrCode);

    $data['qrCode'] = $qrCodePath;
    // Create PDF using DomPDF
    $pdf = PDF::loadView('pdf.pdf', $data, [
      'orientation' => 'portrait', // You can change this to 'landscape' if needed
      'page-size' => 'A4',         // Page size, changeable
      'zoom' => 1.0,
      'title' => 'Order #' . $data['order']->code,
      'dpi' => 300,                // High resolution for printing
    ]);

    return $pdf->stream('Order #' . $data['order']->code . '.pdf');
  }

  public function updateDO($id)
  {
    $data['order'] = DB::connection('mysql_secondary')->table('orders')
    ->where('orders.id', $id)
    ->update([
        'status' => '2',
    ]);
    
    return redirect('dashboard');
  }
}
