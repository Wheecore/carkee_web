<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;


class HomeController extends Controller
{
  /* Dashboard */
  public function dashboard(Request $request)
  {
    $stats['customers'] = DB::table('customers')->where('user_id', $request->id)->count();
    $stats['orders'] = DB::table('orders')->where('user_id', $request->id)->count();
    return response()->json($stats, 200);
  }

  /* Profile */
  public function update_profile(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $request->id,
    ]);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    User::where('id', $request->id)->update([
      'name' => $request->name,
      'email' => $request->email,
    ]);
    return response()->json(['message' => 'Profile updated successfully'], 200);
  }

  public function change_password(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'old_password' => 'required',
      'password' => 'required|min:8',
      'password_confirmation' => 'required|same:password',
    ]);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    $user = User::where('id', $request->id)->first();
    if (!Hash::check($request->old_password, $user->password)) {
      return response()->json(['errors' => ['old_password' => 'Old password is incorrect']], 422);
    }
    $user->update(['password' => bcrypt($request->password)]);
    return response()->json(['message' => 'Password changed successfully'], 200);
  }

  /* Orders */
  public function get_orders(Request $request)
  {
    $orders = DB::table('orders')
      ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
      ->select('orders.id', 'orders.code', 'customers.name', 'customers.company_phone', 'customers.pic_name', 'customers.pic_phone', 'orders.payment_term', 'payment_due_date', 'orders.total', 'orders.status', DB::raw('DATE_FORMAT(`orders`.created_at, "%Y-%m-%d") as created_at'))
      ->when($request->search, function ($q) {
        return $q->where('orders.code', 'like', '%' . request('search') . '%')
          ->orWhere('customers.phone', 'like', '%' . request('search') . '%')
          ->orWhere('payment_term', 'like', '%' . request('search') . '%')
          ->orWhere('payment_due_date', 'like', '%' . request('search') . '%')
          ->orWhere('total', 'like', '%' . request('search') . '%');
      })
      ->where('orders.user_id', $request->id)
      ->simplePaginate(15);
    return response()->json($orders, 200);
  }

  public function order_store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'customer_id' => 'required',
      'payment_term' => 'required',
      'payment_due_date' => 'required',
      'products' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    $order = Order::create([
      'user_id' => $request['id'],
      'customer_id' => $request['customer_id'],
      'payment_term' => $request['payment_term'],
      'payment_due_date' => $request['payment_due_date'],
      'customer_po_no' => $request['customer_po_no'],
      'do_no' => $request['do_no'],
    ]);
    $total = 0;
    $products = $request['products'];
    foreach ($products as $product) {
      $amount = $product['amount'] * $product['qty'];
      $discountAmount = ($product['disc'] / 100) * $amount;
      $amount = $amount - $discountAmount;
      OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product['id'],
        'qty' => $product['qty'],
        'foc' => $product['foc'],
        'uom' => $product['uom'],
        'disc' => $product['disc'],
        'amount' => $product['amount'],
      ]);
      $total += $amount;
      // decrement stock
      DB::table('products')->where('id', $product['id'])->decrement('stock', $product['qty']);
    }
    $order->code = sprintf('%d2020%03d', date('ym'), $order->id);
    $order->total = $total;
    $order->save();
    if ($request['payment_term'] == 'Credit Note') {
      Transaction::create([
        'order_id' => $order->id,
        'customer_id' => $request['customer_id'],
        'amount' => $total,
      ]);
    }
    return response()->json(['message' => 'Order placed successfully'], 200);
  }

  public function order_show(Request $request)
  {
    $data['order'] = DB::table('orders')
      ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
      ->leftJoin('users as staff', 'staff.id', '=', 'orders.user_id')
      ->select('customers.code as customer_code', 'customers.name', 'staff.name as staff', 'customers.company_phone', 'customers.pic_name', 'customers.pic_phone', 'customers.address', 'orders.id', 'orders.user_id', 'orders.customer_id', 'orders.code', 'orders.payment_term', 'orders.payment_due_date', 'orders.customer_po_no', 'orders.do_no', 'orders.total', 'orders.status', DB::raw('DATE_FORMAT(`orders`.created_at, "%Y-%m-%d") as created_at'))
      ->where('orders.id', $request->id)
      ->first();
    $data['user_id'] = $data['order']->user_id;
    $data['order_items'] = DB::table('order_items')
      ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
      ->select('order_items.product_id as id', 'products.name', 'order_items.qty', 'order_items.foc', 'order_items.uom', 'order_items.disc', 'order_items.amount')
      ->where('order_items.order_id', $request->id)
      ->get()->toArray();
    return response()->json($data, 200);
  }

  public function order_delete(Request $request)
  {
    Order::find($request->id)->delete();
    DB::table('order_items')->where('order_id', $request->id)->delete();
    DB::table('transactions')->where('order_id', $request->id)->delete();
    DB::table('transaction_histories')->where('order_id', $request->id)->delete();
    return response()->json(['message' => 'Order deleted successfully'], 200);
  }

  /* Products */
  public function get_products()
  {
    $products = DB::table('products')->select('id', 'name', 'stock', 'amount', 'disc')->where('stock', '>', 0)->get()->toArray();
    return response()->json($products, 200);
  }

  /* Customers */
  public function get_customers(Request $request)
  {
    $customers = DB::table('customers')
      ->leftJoin('users', 'users.id', '=', 'customers.user_id')
      ->select('users.name as staff', 'customers.*', DB::raw('DATE_FORMAT(`customers`.created_at, "%Y-%m-%d") as created_at'))
      ->when($request->search, function ($q) {
        return $q->where('users.name', 'like', '%' . request('search') . '%')
          ->orWhere('code', 'like', '%' . request('search') . '%')
          ->orWhere('customers.name', 'like', '%' . request('search') . '%')
          ->orWhere('customers.company_phone', 'like', '%' . request('search') . '%')
          ->orWhere('customers.company_number', 'like', '%' . request('search') . '%')
          ->orWhere('customers.pic_name', 'like', '%' . request('search') . '%')
          ->orWhere('customers.pic_phone', 'like', '%' . request('search') . '%')
          ->orWhere('customers.pic_address', 'like', '%' . request('search') . '%')
          ->orWhere('customers.email', 'like', '%' . request('search') . '%');
      })
      ->when($request->id, function ($q) {
        return $q->where('customers.user_id', request('id'));
      })
      ->simplePaginate(15);
    return response()->json($customers, 200);
  }

  public function get_order_customers(Request $request)
  {
    $customers = DB::table('customers')
      ->leftJoin('users', 'users.id', '=', 'customers.user_id')
      ->select('users.name as staff', 'customers.*', DB::raw('DATE_FORMAT(`customers`.created_at, "%Y-%m-%d") as created_at'))
      ->when($request->id, function ($q) {
        return $q->where('customers.user_id', request('id'));
      })
      ->get()->toArray();
    return response()->json($customers, 200);
  }

  public function customer_store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'code' => 'nullable|string',
      'name' => 'required',
      'company_phone' => 'required|unique:customers,company_phone',
      'company_number' => 'nullable|string',
      'pic_name' => 'required',
      'pic_phone' => 'required',
      'email' => 'nullable|email',
      'address' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    $customer = Customer::create([
      'user_id' => $request->id,
      'name' => $request->name,
      'address' => $request->address,
      'company_phone' => $request->company_phone,
      'company_number' => $request->company_number,
      'pic_name' => $request->pic_name,
      'pic_phone' => $request->pic_phone,
      'email' => $request->email,
    ]);
    if (isset($request->code) && trim($request->code) !== '') {
      $customer->code = $request->code;
    } else {
      $name = $request->name;
      // get first character of name
      $first_char = substr($name, 0, 1);
      $existings = Customer::where('code', 'like', $first_char . '%')->get();
      $number = 0;
      foreach ($existings as $item) {
        $code = $item->code;
        $appended = substr($code, 1);
        if (is_numeric($appended)) {
          $number = max($number, intval($appended));
        }
      }
      $customer->code = sprintf('%s%03d', strtoupper($first_char), $number + 1);
    }
    $customer->save();
    return response()->json(['message' => 'Customer created successfully'], 200);
  }

  public function customer_show(Request $request)
  {
    $customer = Customer::find($request->id);
    return response()->json(['user' => $customer], 200);
  }

  public function check_customer_due(Request $request)
  {
    if (DB::table('transactions')->where('customer_id', $request->id)->where(DB::raw('DATEDIFF(DATE_ADD(updated_at, INTERVAL 60 DAY), NOW())'), '<=', 0)->whereRaw('amount <> paid')->first()) {
      return response()->json(['status' => 1, 'message' => 'The customer has pending due'], 200);
    } else {
      return response()->json(['status' => 0], 200);
    }
  }

  public function customer_update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'code' => 'required',
      'name' => 'required',
      'company_phone' => 'required|unique:customers,company_phone,' . $request->id,
      'company_number' => 'nullable|string',
      'pic_name' => 'required',
      'pic_phone' => 'required',
      'email' => 'nullable|email',
      'address' => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    Customer::where('id', $request->id)->update([
      'code' => $request->code,
      'name' => $request->name,
      'address' => $request->address,
      'company_phone' => $request->company_phone,
      'company_number' => $request->company_number,
      'pic_name' => $request->pic_name,
      'pic_phone' => $request->pic_phone,
      'email' => $request->email,
    ]);
    return response()->json(['message' => 'Customer updated successfully'], 200);
  }

  public function customer_delete(Request $request)
  {
    Customer::find($request->id)->delete();
    return response()->json(['message' => 'Customer deleted successfully'], 200);
  }

  public function pdf($id, $type = null, $download = true)
  {
    // Fetch the order and related information
    $data['order'] = DB::table('orders')
      ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
      ->leftJoin('users as staff', 'staff.id', '=', 'orders.user_id')
      ->select(
        'customers.code as customer_code',
        'customers.name',
        'staff.name as staff',
        'customers.company_phone',
        'customers.pic_name',
        'customers.pic_phone',
        'customers.address',
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
      ->where('orders.id', $id)
      ->first();

    // Fetch the order items
    $data['order_items'] = DB::table('order_items')
      ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
      ->select(
        'products.name',
        'order_items.qty',
        'order_items.foc',
        'order_items.uom',
        'order_items.disc',
        'order_items.amount'
      )
      ->where('order_items.order_id', $id)
      ->get()->toArray();

    // Generate the QR code in SVG format
    $qrCodeData = [
      'order_code' => $data['order']->code,
      'customer_name' => $data['order']->name,
      'total_amount' => $data['order']->total,
      'payment_due_date' => $data['order']->payment_due_date,
    ];

    $qrCode = QrCode::format('svg')->size(100)->generate(json_encode($qrCodeData));
    // put the qr code at public folder
    // unix timestamp
    $qrCodePath = public_path('/qr-codes/' . $data['order']->code .  time() . '.svg');
    file_put_contents($qrCodePath, $qrCode);
    // $qrCodePath = public_path('/images/qr_codes/' . $data['order']->code . '.svg');

    $data['qrCode'] = $qrCodePath;

    $data['type'] = $type;

    // Create PDF using DomPDF
    $pdf = PDF::loadView('pdf.pdf', $data, [
      'orientation' => 'portrait', // You can change this to 'landscape' if needed
      'page-size' => 'A4',         // Page size, changeable
      'zoom' => 1.0,
      'title' => 'Order #' . $data['order']->code,
      'dpi' => 300,                // High resolution for printing
    ]);
    // if $download is true, download the PDF,else open it in the browser
    if ($download) {
      return $pdf->download('Order #' . $data['order']->code . '.pdf');
    } else {
      return $pdf->stream('Order #' . $data['order']->code . '.pdf');
    }
    // return $pdf->download('Order #' . $data['order']->code . '.pdf');
  }
}
