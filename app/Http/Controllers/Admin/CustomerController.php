<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\CarList;
use App\Models\CarWashMembership;
use App\Models\CarWashPayment;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Wallet;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $customers = Customer::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'customer')->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
            $customers = $customers->where(function ($customer) use ($user_ids) {
                $customer->whereIn('user_id', $user_ids);
            });
        }
        $customers = $customers->paginate(15);
        return view('backend.customer.customers.index', compact('customers', 'sort_search'));
    }

    public function create()
    {
        return view('backend.customer.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->phone2 = $request->phone2;
        $user->password = bcrypt($request->password);
        $user->verification_code = rand(100000, 999999);
        if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
        }
        $user->save();

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();

        flash(translate('Customer has been added successfully'))->success();
        return redirect()->route('customers.index');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail(decrypt($id));
        $user = $customer->user;
        return view('backend.customer.customers.edit', compact('customer', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail(decrypt($id));
        if (User::where('email', $request->email)->where('id','!=', $user->id)->first() != null) {
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->phone2 = $request->phone2;
        if ($user->save()) {
            flash(translate('Customer has been updated successfully'))->success();
            return redirect()->route('customers.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function destroy($id)
    {
        Order::where('user_id', Customer::findOrFail($id)->user->id)->delete();
        User::destroy(Customer::findOrFail($id)->user->id);
        if (Customer::destroy($id)) {
            flash(translate('Customer has been deleted successfully'))->success();
            return redirect()->route('customers.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function bulk_customer_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $customer_id) {
                $this->destroy($customer_id);
            }
        }

        return 1;
    }

    public function login($id)
    {
        $customer = Customer::findOrFail(decrypt($id));
        $user  = $customer->user;
        auth()->login($user, true);

        return redirect()->route('dashboard');
    }

    public function ban($id)
    {
        $customer = Customer::findOrFail($id);
        if ($customer->user->banned == 1) {
            $customer->user->banned = 0;
            flash(translate('Customer UnBanned Successfully'))->success();
        } else {
            $customer->user->banned = 1;
            flash(translate('Customer Banned Successfully'))->success();
        }
        $customer->user->save();

        return back();
    }

    public function wallet_history(Request $request, $user_id)
    {
        $data['type'] = null;
        $data['date'] = null;
        $data['sort_search'] = null;
        $added_pageNumber = 0;
        $deduct_o_pageNumber = 0;
        $deduct_m_pageNumber = 0;
        if(request()->type == 'added'){
            $data['type'] = 'added';
            $added_pageNumber = request()->page;
        }
        else if(request()->type == 'deduct_o'){
            $data['type'] = 'deduct_o';
            $deduct_o_pageNumber = request()->page;
        }
        else if(request()->type == 'deduct_m'){
            $data['type'] = 'deduct_m';
            $deduct_m_pageNumber = request()->page;
        }
        $user_id = decrypt($user_id);
        $data['user_data'] = User::where('id', $user_id)->select('name', 'balance')->first();

        $added_to_wallet = Wallet::where('wallets.type', 'add')->where('wallets.status', 1)->where('wallets.user_id', $user_id)
        ->leftJoin('users as recharger','recharger.id', 'wallets.charge_by');

        $deduct_from_wallet = CarWashPayment::where('car_wash_payments.user_id', $user_id)
        ->leftJoin('orders', 'orders.id', '=', 'car_wash_payments.order_id');

        $deduct_from_wallet_manually = Wallet::where('wallets.type', 'deduct')->where('wallets.user_id', $user_id)
        ->leftJoin('users as recharger','recharger.id', 'wallets.charge_by');

        if ($request->has('search')) {
            $data['sort_search'] = $request->search;
            $sort_search = $request->search;

            $added_to_wallet = $added_to_wallet->where(function ($query) use ($sort_search) {
                $query->where('recharger.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('recharger.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('wallets.staff_code', 'like', '%' . $sort_search . '%')
                    ->orWhere('wallets.payment_method', 'like', '%' . $sort_search . '%');
            });
            $deduct_from_wallet = $deduct_from_wallet->where(function ($query) use ($sort_search) {
                $query->where('orders.code', 'like', '%' . $sort_search . '%');
            });
            $deduct_from_wallet_manually = $deduct_from_wallet_manually->where(function ($query) use ($sort_search) {
                $query->where('recharger.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('recharger.email', 'like', '%' . $sort_search . '%');
            });
        }
        if ($request->date != null) {
            $exploded_date = explode(" to ", $request->date);
            $data['date'] = $request->date;
            $added_to_wallet = $added_to_wallet->whereDate('wallets.created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('wallets.created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
            $deduct_from_wallet = $deduct_from_wallet->whereDate('car_wash_payments.created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('car_wash_payments.created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
            $deduct_from_wallet_manually = $deduct_from_wallet_manually->whereDate('wallets.created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('wallets.created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }

        $added_to_wallet = $added_to_wallet->select('wallets.user_id', 'wallets.charge_by', 'recharger.name', 'recharger.email',
        'wallets.amount', 'wallets.payment_method', 'wallets.created_at', 'wallets.payment_details','wallets.staff_code', 'wallets.remarks')
        ->orderBy('wallets.id','desc')
        ->paginate(10, ['*'],'added_page', $added_pageNumber)->appends(request()->query());

        $deduct_from_wallet = $deduct_from_wallet->select('car_wash_payments.id', 'car_wash_payments.amount',
        'car_wash_payments.created_at', 'orders.code')
        ->orderBy('car_wash_payments.id','desc')
        ->paginate(10, ['*'],'deduct_o', $deduct_o_pageNumber)->appends(request()->query());

        $deduct_from_wallet_manually = $deduct_from_wallet_manually->select('wallets.user_id', 'wallets.charge_by', 'recharger.name',
        'recharger.email', 'wallets.amount','wallets.created_at', 'wallets.remarks')
        ->orderBy('wallets.id','desc')
        ->paginate(10, ['*'],'deduct_m', $deduct_m_pageNumber)->appends(request()->query());

        $data['added_to_wallet'] = $added_to_wallet;
        $data['deduct_from_wallet'] = $deduct_from_wallet;
        $data['deduct_from_wallet_manually'] = $deduct_from_wallet_manually;
        $data['timezone'] = user_timezone(Auth::id());
        $data['user_id'] = $user_id;
        return view('backend.customer.customers.wallet_history', $data);
    }

    public function wallet_adjustment(Request $request)
    {
        $obj = array(
            'status' => 'Success'
        );
        if($request->type == 'add'){
            $wallet = new Wallet();
            $wallet->user_id = $request->user_id;
            $wallet->charge_by = Auth::id();
            $wallet->amount = $request->amount;
            $wallet->payment_method = 'manually';
            $wallet->remarks = $request->remarks;
            $wallet->payment_details = json_encode($obj);
            $wallet->status = 1;
            if($wallet->save()){
                $user = User::find($request->user_id);
                $user->balance += $request->amount;
                $user->update();

            // Generate Notification to admin
            \App\Models\Notification::create([
                'user_id' => DB::table('users')->select('id')->where('user_type', 'admin')->first()->id,
                'is_admin' => 1,
                'type' => 'wallet_recharge',
                'body' => translate('New transaction received - Wallet recharge'),
                'wallet_id' => $wallet->id,
            ]);
            // Generate Notification to user
            \App\Models\Notification::create([
                'user_id' => $request->user_id,
                'is_admin' => 3,
                'type' => 'wallet_recharge',
                'body' => translate('Hurrah!!! Your wallet has been recharged'),
                'wallet_id' => $wallet->id,
            ]);
            try {
                // Send firebase notification
                $device_token = DB::table('device_tokens')->where('user_id', $request->user_id)->select('token')->get()->toArray();
                $array = array(
                    'device_token' => $device_token,
                    'title' => translate('Hurrah!!! Your wallet has been recharged')
                );
                send_firebase_notification($array);
            } catch (\Exception $e) {
                // dd($e);
            }
            }
        }
        else{
            $wallet = new Wallet();
            $wallet->user_id = $request->user_id;
            $wallet->charge_by = Auth::id();
            $wallet->amount = $request->amount;
            $wallet->payment_method = 'manually';
            $wallet->type = 'deduct';
            $wallet->remarks = $request->remarks;
            $wallet->payment_details = json_encode($obj);
            if($wallet->save()){
                $user = User::find($request->user_id);
                $user->balance -= $request->amount;
                $user->update();

            // Generate Notification to admin
            \App\Models\Notification::create([
                'user_id' => DB::table('users')->select('id')->where('user_type', 'admin')->first()->id,
                'is_admin' => 1,
                'type' => 'wallet_deduct',
                'body' => translate('New transaction received - Wallet deducted'),
                'wallet_id' => $wallet->id,
            ]);
            // Generate Notification to user
            \App\Models\Notification::create([
                'user_id' => $request->user_id,
                'is_admin' => 3,
                'type' => 'wallet_deduct',
                'body' => translate('Your wallet has been deducted'),
                'wallet_id' => $wallet->id,
            ]);
            try {
                // Send firebase notification
                $device_token = DB::table('device_tokens')->where('user_id', $request->user_id)->select('token')->get()->toArray();
                $array = array(
                    'device_token' => $device_token,
                    'title' => translate('Your wallet has been deducted')
                );
                send_firebase_notification($array);
            } catch (\Exception $e) {
                // dd($e);
            }
            }
        }

        flash(translate('Operation has been performed successfully'))->success();
        return back();
    }

    public function wallet_transactions(Request $request)
    {
        $data['type'] = null;
        $data['date'] = null;
        $added_pageNumber = 0;
        $deduct_o_pageNumber = 0;
        $deduct_m_pageNumber = 0;
        $data['sort_search'] = null;
        if(request()->type == 'added'){
            $data['type'] = 'added';
            $added_pageNumber = request()->page;
        }
        else if(request()->type == 'deduct_o'){
            $data['type'] = 'deduct_o';
            $deduct_o_pageNumber = request()->page;
        }
        else if(request()->type == 'deduct_m'){
            $data['type'] = 'deduct_m';
            $deduct_m_pageNumber = request()->page;
        }

        $added_to_wallet = Wallet::where('wallets.type', 'add')
        ->where('wallets.status', 1)
        ->leftJoin('users as receiver','receiver.id', 'wallets.user_id')
        ->leftJoin('users as recharger','recharger.id', 'wallets.charge_by');

        $deduct_from_wallet = CarWashPayment::leftJoin('users as receiver','receiver.id', 'car_wash_payments.user_id')
        ->leftJoin('orders', 'orders.id', '=', 'car_wash_payments.order_id');

        $deduct_from_wallet_manually = Wallet::where('wallets.type', 'deduct')
        ->leftJoin('users as receiver','receiver.id', 'wallets.user_id')
        ->leftJoin('users as recharger','recharger.id', 'wallets.charge_by');

        if ($request->has('search')) {
            $data['sort_search'] = $request->search;
            $sort_search = $request->search;

            $added_to_wallet = $added_to_wallet->where(function ($query) use ($sort_search) {
                $query->where('receiver.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('receiver.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('recharger.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('recharger.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('wallets.staff_code', 'like', '%' . $sort_search . '%')
                    ->orWhere('wallets.payment_method', 'like', '%' . $sort_search . '%');
            });
            $deduct_from_wallet = $deduct_from_wallet->where(function ($query) use ($sort_search) {
                $query->where('receiver.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('receiver.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('orders.code', 'like', '%' . $sort_search . '%');
            });
            $deduct_from_wallet_manually = $deduct_from_wallet_manually->where(function ($query) use ($sort_search) {
                $query->where('receiver.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('receiver.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('recharger.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('recharger.email', 'like', '%' . $sort_search . '%');
            });
        }
        if ($request->date != null) {
            $exploded_date = explode(" to ", $request->date);
            $data['date'] = $request->date;
            $added_to_wallet = $added_to_wallet->whereDate('wallets.created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('wallets.created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
            $deduct_from_wallet = $deduct_from_wallet->whereDate('car_wash_payments.created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('car_wash_payments.created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
            $deduct_from_wallet_manually = $deduct_from_wallet_manually->whereDate('wallets.created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('wallets.created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }

        $added_to_wallet = $added_to_wallet->select('wallets.user_id', 'wallets.charge_by', 'receiver.name as receiver_name', 'receiver.email as receiver_email',
        'recharger.name', 'recharger.email', 'wallets.amount',
        'wallets.payment_method', 'wallets.created_at', 'wallets.payment_details','wallets.staff_code','wallets.remarks')
        ->orderBy('wallets.id','desc')
        ->paginate(10, ['*'],'added_page', $added_pageNumber)->appends(request()->query());

        $deduct_from_wallet = $deduct_from_wallet->select('car_wash_payments.id', 'car_wash_payments.amount',
        'car_wash_payments.created_at', 'orders.code', 'receiver.name as receiver_name', 'receiver.email as receiver_email')
        ->orderBy('car_wash_payments.id','desc')
        ->paginate(10, ['*'],'deduct_o', $deduct_o_pageNumber)->appends(request()->query());

        $deduct_from_wallet_manually = $deduct_from_wallet_manually->select('wallets.user_id', 'wallets.charge_by', 'receiver.name as receiver_name', 'receiver.email as receiver_email', 'recharger.name','recharger.email', 'wallets.amount',
        'wallets.created_at', 'wallets.remarks')
        ->orderBy('wallets.id','desc')
        ->paginate(10, ['*'],'deduct_m', $deduct_m_pageNumber)->appends(request()->query());

        $data['added_to_wallet'] = $added_to_wallet;
        $data['deduct_from_wallet'] = $deduct_from_wallet;
        $data['deduct_from_wallet_manually'] = $deduct_from_wallet_manually;
        $data['timezone'] = user_timezone(Auth::id());
        return view('backend.customer.customers.wallet_transactions', $data);
    }

    public function car_lists(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->select('name')->first();
        $sort_search = null;
        $car_lists = DB::table('car_lists')
        ->leftJoin('brands', 'brands.id', '=', 'car_lists.brand_id')
        ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
        ->leftJoin('car_years', 'car_years.id', '=', 'car_lists.year_id')
        ->leftJoin('car_variants', 'car_variants.id', '=', 'car_lists.variant_id')
        ->leftJoin('size_alternatives', 'size_alternatives.id', '=', 'car_lists.size_alternative_id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $car_lists = $car_lists->where(function ($query) use ($sort_search) {
                $query->where('brands.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_models.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_years.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_variants.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_lists.car_plate', 'like', '%' . $sort_search . '%');
            });
        }
        $car_lists = $car_lists->select('brands.name as brand_name', 'car_models.name as model_name','car_years.name as year_name',
        'car_variants.name as variant_name','size_alternatives.name as size_alternative','car_lists.mileage','car_lists.chassis_number','car_lists.insurance','car_lists.created_at',
        'car_lists.id', 'car_lists.image','car_lists.car_plate', 'car_lists.user_id')
        ->where('car_lists.user_id', $user_id)
        ->paginate(15);
        $timezone = user_timezone(Auth::id());
        return view('backend.customer.customers.car_lists', compact('car_lists', 'sort_search', 'user','timezone'));
    }

    public function car_list_delete($id)
    {
        CarList::where('id', $id)->delete();
        flash(translate('Car list has been deleted successfully'))->success();
        return back();
    }

    public function bulk_carlist_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $list_id) {
                $this->car_list_delete($list_id);
            }
        }
        return 1;
    }

    public function buy_carlist_membership($car_id)
    {
        $carlist = DB::table('car_lists')
        ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
        ->select('car_lists.user_id', 'car_models.name as model', 'car_lists.car_plate')
        ->where('car_lists.id', $car_id)
        ->first();
        $user_id = $carlist->user_id;

        $check_membership = DB::table('car_wash_memberships')
        ->select('id')
        ->where('user_id', $user_id)
        ->where('car_plate', $carlist->car_plate)
        ->first();
        if($check_membership){
            flash(translate('This car has already purchased the memberhsip'))->warning();
            return back();
        }
        $membership_fee = env('MEMBERSHIP_AMOUNT');
        $user = DB::table('users')->where('id', $carlist->user_id)->select('id','name','balance')->first();
        if($membership_fee > $user->balance){  
            flash(translate('Sorry!! The user wallet balance is not enough to complete this'))->warning();
            return back();
        }
        $car_wash_memberships = new CarWashMembership();
        $car_wash_memberships->user_id = $carlist->user_id;
        $car_wash_memberships->car_plate = $carlist->car_plate;
        $car_wash_memberships->amount = $membership_fee;
        $car_wash_memberships->save();

        // Add record to wallet
        $obj = array(
            'status' => 'Success'
        );
        $wallet = new Wallet();
        $wallet->user_id = $carlist->user_id;
        $wallet->charge_by = $carlist->user_id;
        $wallet->amount = $membership_fee;
        $wallet->payment_method = 'wallet';
        $wallet->payment_details = json_encode($obj);
        $wallet->type = 'deduct';
        $wallet->remarks = 'Membership purchased for vehicle '.$carlist->car_plate;
        $wallet->save();

        // decrease user wallet balance
        $user = DB::table('users')->where('id', $carlist->user_id)->decrement('balance', $membership_fee);

        flash(translate('Membership has been purchased successfully!!'))->success();
        return back();
    }

    public function family_members(Request $request, $user_id)
    {
        $user_id = decrypt($user_id);
        $sort_search = null;
        $user_ids = User::where('parent_id', $user_id)->get()->pluck('id'); 
        // getting parent of login user if have
        $login_user = DB::table('users')->where('id', $user_id)->select('parent_id')->first();
        if($login_user->parent_id){
            $user_ids[] = $login_user->parent_id;
        }

        $users = User::whereIn('users.id', $user_ids)
        ->leftJoin('uploads','uploads.id','users.avatar_original');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $users = $users->where(function ($query) use ($sort_search) {
                $query->where('users.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('users.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('users.phone', 'like', '%' . $sort_search . '%');
            });
        }
        $users = $users->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'users.id','users.name', 'users.email', 'users.phone')
        ->paginate(15);
        $current_user = User::where('id', $user_id)->select('id','name')->first();
        return view('backend.customer.customers.family_members', compact('users', 'current_user', 'sort_search'));
    }

    public function show_user_emails(Request $request)
    {
     $emails = User::where('id', '!=', $request->user_id)->where('user_type', 'customer')->where('banned', 0)->where('parent_id', 0)->where('email', 'like', '%' . $request->email . '%')->select('email')->limit(10)->get();
     $list_items = '';
     foreach($emails as $email){
        $list_items.= '<li onclick="putvalue(this)">'.$email->email.'</li>';
     }
     return $list_items;
    }

    public function add_member(Request $request)
    {
        $user = User::where('email', $request->email)->where('user_type', 'customer')->where('banned', 0)->first();
        $login_user = User::where('id', $request->user_id)->select('parent_id')->first();
        if($user){
        if($user->parent_id == 0){
            if($login_user->parent_id != $user->id){
                $user->parent_id = $request->user_id;
                $user->update();
                flash(translate('Added successfully'))->success();
                return 1;
            }
            else{
                return [
                    'result' => false,
                    'message' => "Sorry! You can't add father as a child",
                ];
            }
        }
        else{
            return [
                'result' => false,
                'message' => 'Sorry! This email address is already added in other family',
            ];
        }
       }
       else{
        return [
            'result' => false,
            'message' => 'Sorry! User with this email address is not present in system',
        ];
       }
    }

    public function remove_member($id)
    {
        DB::table('users')->where('id', $id)->update(['parent_id' => 0]);
        flash(translate('User has been successfully removed from family'))->success();
        return back();
    }

    public function bulk_remove_member(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $user_id) {
                $this->remove_member($user_id);
            }
        }
        return 1;
    }
}
