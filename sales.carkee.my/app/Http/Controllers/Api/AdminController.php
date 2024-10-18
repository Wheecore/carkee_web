<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
	// Dashboard
	public function dashboard(Request $request)
	{
		$stats['products']  = DB::table('products')->count();
		$stats['customers'] = DB::table('customers')->count();
		$stats['orders']    = DB::table('orders')->count();
		$stats['staff']     = DB::table('users')->where('id', '>', 1)->count();
		return response()->json($stats, 200);
	}

	public function update_profile(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'  => 'required|string|max:255',
			'email' => 'required|email|unique:users,email,' . $request->id,
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}
		User::where('id', $request->id)->update([
			'name'  => $request->name,
			'email' => $request->email,
		]);
		return response()->json(['message' => 'Profile updated successfully'], 200);
	}

	public function change_password(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'old_password'          => 'required',
			'password'              => 'required|min:8',
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

	// Products
	public function sync_products(Request $request)
	{
		$products = DB::connection('mysql_secondary')->table('products')->select('name', 'qty', 'cost_price')->whereIn('category_id', [1, 4])->get()->toArray();
		foreach ($products as $product) {
			$synced_product = Product::where('name', $product->name)->first();
			if ($synced_product) {
				$synced_product->update([
					'amount' => ($product->cost_price + ($product->cost_price * 5 / 100)),
					'stock'  => ($product->qty * 60 / 100),
				]);
			} else {
				Product::create([
					'name'   => $product->name,
					'amount' => ($product->cost_price + ($product->cost_price * 5 / 100)),
					'stock'  => ($product->qty * 60 / 100),
				]);
			}
		}
		return response()->json(['message' => 'Products synced successfully'], 200);
	}

	public function update_product(Request $request)
	{
		$product = $request->product;
		Product::where('id', $product['id'])->update([
			'stock'  => $product['stock'],
			'amount' => $product['amount'],
			'disc'   => $product['disc'],
		]);
		return response()->json(['message' => 'Products updated successfully'], 200);
	}

	public function get_products(Request $request)
	{
		$products = DB::table('products')
			->select('id', 'name', 'stock', 'amount', 'disc')
			->when($request->search, function ($q) {
				return $q->where('name', 'like', '%' . request('search') . '%')->orWhere('amount', 'like', '%' . request('search') . '%');
			})
			->simplePaginate(15);
		return response()->json($products, 200);
	}

	/* Users */
	public function get_users(Request $request)
	{
		$users = DB::table('users')
			->select('id', 'name', 'email', DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_at'), 'status')
			->when($request->search, function ($q) {
				return $q->where('name', 'like', '%' . request('search') . '%')
					->orWhere('email', 'like', '%' . request('search') . '%');
			})
			->where('role_id', '!=', 1)
			->simplePaginate(15);
		return response()->json($users, 200);
	}

	public function user_store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'                  => 'required|string|max:255',
			'email'                 => 'required|email|unique:users,email',
			'password'              => 'required|min:8',
			'password_confirmation' => 'required|same:password',
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}
		User::create([
			'role_id'  => 2,
			'name'     => $request->name,
			'email'    => $request->email,
			'password' => bcrypt($request->password),
			'status'   => 1,
		]);
		return response()->json(['message' => 'User created successfully'], 200);
	}

	public function user_show(Request $request)
	{
		$user = User::find($request->id);
		return response()->json(['user' => $user], 200);
	}

	public function user_update(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'   => 'required|string|max:255',
			'email'  => 'required|email|unique:users,email,' . $request->id,
			'status' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}
		User::where('id', $request->id)->update([
			'name'   => $request->name,
			'email'  => $request->email,
			'status' => $request->status,
		]);
		return response()->json(['message' => 'User updated successfully'], 200);
	}

	public function user_delete(Request $request)
	{
		$user = User::find($request->id);
		$user->tokens()->delete();
		$user->delete();
		return response()->json(['message' => 'User deleted successfully'], 200);
	}

	// Orders
	public function get_orders(Request $request)
	{
		$orders = DB::table('orders')
			->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
			->select('orders.id', 'orders.code', 'customers.name as name', 'customers.company_phone', 'customers.pic_name', 'orders.payment_term', 'customers.pic_phone', 'payment_due_date', 'orders.total', 'orders.status', DB::raw('DATE_FORMAT(`orders`.created_at, "%Y-%m-%d") as created_at'))
			->when($request->search, function ($q) {
				return $q->where('orders.code', 'like', '%' . request('search') . '%')
					->orWhere('customers.phone', 'like', '%' . request('search') . '%')
					->orWhere('payment_term', 'like', '%' . request('search') . '%')
					->orWhere('payment_due_date', 'like', '%' . request('search') . '%')
					->orWhere('total', 'like', '%' . request('search') . '%');
			})
			->simplePaginate(15);
		return response()->json($orders, 200);
	}

	public function order_update(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'customer_id'      => 'required',
			'payment_term'     => 'required',
			'payment_due_date' => 'required',
			'products'         => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}
		$order = Order::find($request['id']);
		$order->update([
			'customer_id'      => $request['customer_id'],
			'payment_term'     => $request['payment_term'],
			'payment_due_date' => $request['payment_due_date'],
			'status'           => $request['status'],
		]);
		$total    = 0;
		$products = $request['products'];
		foreach ($products as $product) {
			$is_deleted     = $product['isDeleted'] ?? FALSE;
			$amount         = $product['amount'] * $product['qty'];
			$discountAmount = ($product['disc'] / 100) * $amount;
			$amount         = $amount - $discountAmount;
			$data           = [
				'order_id'   => $order->id,
				'product_id' => $product['id'],
				'qty'        => $product['qty'],
				'foc'        => $product['foc'],
				'uom'        => $product['uom'],
				'disc'       => $product['disc'],
				'amount'     => $product['amount'],
			];
			$order_item     = OrderItem::where('order_id', $order->id)->where('product_id', $product['id'])->first();
			if ($order_item) {
				if(!$is_deleted) {
					$order_item->update($data);
				} else {
					$order_item->delete();
				}
			} else {
				if(!$is_deleted) {
					OrderItem::create($data);
				}
			}
			if(!$is_deleted) {
				$total += $amount;
			}
		}
		$order->total = $total;
		$order->save();
		return response()->json(['message' => 'Order updated successfully'], 200);
	}

	/* Credit Notes */
	public function get_credit_notes(Request $request)
	{
		$notes = DB::table('transactions')
			->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
			->leftJoin('orders', 'orders.id', '=', 'transactions.order_id')
			->select('transactions.id', 'customers.name', 'orders.code', DB::raw('`transactions`.amount - paid as due'), 'transactions.amount', 'transactions.paid', DB::raw('DATEDIFF(DATE_ADD(`transactions`.updated_at, INTERVAL 60 DAY), NOW()) AS days_remaining'))
			->when($request->search, function ($q) {
				return $q->where('customers.name', 'like', '%' . request('search') . '%')
					->orWhere('orders.code', 'like', '%' . request('search') . '%')
					->orWhere('transactions.due', 'like', '%' . request('search') . '%')
					->orWhere('transactions.paid', 'like', '%' . request('search') . '%');
			})
			->orderBy(DB::raw('`transactions`.amount - paid'), 'desc')
			->simplePaginate(15);
		return response()->json($notes, 200);
	}

	public function update_credit_notes(Request $request)
	{
		if ($request->amount > 0) {
			$transaction = Transaction::find($request->id);
			$transaction->increment('paid', $request->amount);
			TransactionHistory::create([
				'transaction_id' => $transaction->id,
				'order_id'       => $transaction->order_id,
				'amount'         => $request->amount,
			]);
			return response()->json(['status' => 1, 'message' => 'Credit note updated successfully'], 200);
		} else {
			return response()->json(['status' => 0, 'message' => 'Credit note amount should be atleast RM 1'], 200);
		}
	}

	public function get_transaction_histrory(Request $request)
	{
		$transactions = DB::table('transaction_histories')
			->leftJoin('orders', 'orders.id', '=', 'transaction_histories.order_id')
			->select('transaction_histories.amount', DB::raw('DATE_FORMAT(`transaction_histories`.created_at, "%Y-%m-%d") as created_at'), 'orders.code')
			->get()
			->toArray();
		return response()->json($transactions, 200);
	}
}
