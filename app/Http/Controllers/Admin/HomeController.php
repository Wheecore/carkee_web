<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function admin_dashboard()
    {
        $verified_sellers = verified_sellers_id();
        $data['user'] = Auth::user();
        $data['permissions'] = ($data['user']->staff) ? $data['user']->staff->role->permissions : [];
        $data['products_count'] = DB::table('products')->where('published', 1)->selectRaw("COUNT(*) AS published_products, COUNT(CASE added_by WHEN 'admin' THEN 1 END) AS admin_products")->first();
        $data['categories'] = DB::table('categories')->join('category_translations', 'category_translations.category_id', '=', 'categories.id')->select('categories.name')->select('categories.id', 'category_translations.name')->get()->toArray();
        $data['top_products'] = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
            ->join('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('products.id', 'product_translations.name', 'uploads.file_name', 'products.rating')
            ->where('products.published', 1)
            ->where('products.added_by', 'admin')
            ->orWhere(function ($q) use ($verified_sellers) {
                $q->whereIn('products.user_id', $verified_sellers);
            })
            ->orderBy('products.num_of_sale', 'desc')
            ->limit(12)->get();
        $data['months'] = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $data['months_in_numbers'] = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        return view('backend.dashboard', $data);
    }

    public function get_sales_data_by_year(Request $request)
    {
        $months_in_numbers = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $sales_data = [];
        foreach ($months_in_numbers as $month)
        {
        $data = DB::table('orders')->whereYear('created_at', $request->year)->whereMonth('created_at', $month)->where('payment_status', 'paid')->sum('grand_total');
        $sales_data[] = str_replace(',', '', number_format($data, 2));
        }
        return $sales_data;
    }

    public function get_wallet_topup_data_by_year(Request $request)
    {
        $months_in_numbers = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $wallet_data = [];
        foreach ($months_in_numbers as $month)
        {
        $data = DB::table('wallets')->whereYear('created_at', $request->year)->whereMonth('created_at', $month)->where('type', 'add')->where('status', 1)->sum('amount');
        $wallet_data[] = str_replace(',', '', number_format($data, 2));
        }
        return $wallet_data;
    }

    public function notifications()
    {
        $notifications = DB::table('notifications')
            ->leftJoin('orders', 'orders.id', '=', 'notifications.order_id')
            ->select('notifications.body', 'notifications.created_at', 'orders.id', 'notifications.is_viewed',
            'orders.order_type', 'notifications.id as notification_id')
            ->where('notifications.is_admin', 1)
            ->whereIn('notifications.type', ['order','wallet_recharge','wallet_deduct'])
            ->orderBy('notifications.id', 'DESC')
            ->get()
            ->toArray();

        return view('backend.notifications.index', compact('notifications'));
    }

    public function reschedule_payments(Request $request)
    {
        $sort_search = null;
        $payments = DB::table('payments')->where('payments.type', 'reshedule')
        ->leftJoin('orders', 'orders.id','payments.order_id')
        ->leftJoin('users', 'users.id','payments.user_id')
        ->select('payments.*','orders.code','users.name');
        if($request->has('search')) {
            $sort_search = $request->search;
            $payments = $payments->where('orders.code', '%'.$sort_search.'%');
        }
        $payments = $payments->orderBy('payments.id', 'desc')->paginate(15);
        return view('backend.payments.reschedule_payments', compact('payments', 'sort_search'));
    }

    public function reschedule_payment_delete($id)
    {
        Payment::destroy($id);
        flash(translate('Payment record has been deleted successfully'))->success();
        return redirect()->back();
    }

}
