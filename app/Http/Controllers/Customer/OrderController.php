<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  public function submitReview(Request $request)
  {
    DB::table('orders')->where('id', $request->order_id)->update([
      'done_installation_status' => 2
    ]);

    $chk_order = DB::table('rating_orders')->where('order_id', $request->order_id)->first();
    if ($chk_order) {
      DB::table('rating_orders')->where('order_id', $request->order_id)->update([
        'score' => $request->score,
        'workshop_enviornment' => $request->workshop_enviornment,
        'job_done_on_time' => $request->job_done_on_time,
        'description' => $request->description,
        'features' => json_encode($request->features),
        'website_use' => $request->website_use,
        'money_of_product' => $request->money_of_product,
        'buy_again' => $request->buy_again,
        'purchasing_concern' => json_encode($request->purchasing_concern),
        'specification_of_products' => $request->specification_of_products
      ]);
    } else {
      DB::table('rating_orders')->insert([
        'user_id' => Auth::id(),
        'order_id' => $request->order_id,
        'score' => $request->score,
        'workshop_enviornment' => $request->workshop_enviornment,
        'job_done_on_time' => $request->job_done_on_time,
        'description' => $request->description,
        'features' => json_encode($request->features),
        'website_use' => $request->website_use,
        'money_of_product' => $request->money_of_product,
        'buy_again' => $request->buy_again,
        'purchasing_concern' => json_encode($request->purchasing_concern),
        'specification_of_products' => $request->specification_of_products
      ]);
    }
    flash(translate('Order review has been submitted successfully'))->success();
    return back();
  }

  public function confirmOrder($orderId)
  {
      // Check if the order exists
      $order = DB::table('orders')->where('id', $orderId)->first();
  
      if (!$order) {
          return response()->json(['error' => 'Order not found.'], 404);
      }
  
      // Update the order status to 'Received'
      DB::table('orders')
          ->where('id', $orderId)
          ->update(['status' => 'Received']);
  
      return response()->json(['message' => 'Order status updated successfully.']);
  }
}
