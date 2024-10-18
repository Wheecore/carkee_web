<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CarWashPayment;
use App\Http\Controllers\Api\V2\Ipay88Controller;
use App\Models\Deal;

class WalletController extends Controller
{
    public function vehicles_data(Request $request)
    {
        $data['available_balance'] = User::where('id', $request->user_id)->first()->balance;
         // car lists
        $car_lists = DB::table('car_lists')
         ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
         ->leftJoin('brands', 'brands.id', '=', 'car_lists.brand_id')
         ->select('car_lists.id', 'brands.name as brand', 'car_models.name as model', 'car_lists.car_plate', 'car_lists.image')
        ->where('car_lists.user_id', $request->user_id)
        ->orderBy('car_lists.id', 'desc')
        ->get();

     $carlists_arr = [];
     if (count($car_lists) > 0) {
              $carlists_arr = $car_lists->map(function($carlist) use($request){
              $check_membership = DB::table('car_wash_memberships')
             ->select('id')
             ->where('user_id', $request->user_id)
             ->where('car_plate', $carlist->car_plate)
             ->first();
                return [
                    'id' => $carlist->id,
                    'car_plate' => $carlist->car_plate,
                    'brand_name' => $carlist->brand,
                    'model_name' => $carlist->model,
                    'year_name' => '',
                    'variant_name' => '',
                    'image' => api_asset($carlist->image),
                    'is_membership' => (isset($check_membership) && $check_membership) ? true : false
                ];
             });
     }
        $data['carlists_arr'] = $carlists_arr;

        $car_wash_deals = Deal::where('type', 'car_wash')->where('status', 1)->select('id', 'start_date', 'end_date', 'text_color', 'banner')->get();
        $data['car_wash_deals'] = [];
        foreach ($car_wash_deals as $deal) {
            $data['car_wash_deals'][] = [
                'id' => $deal->id,
                'title' => $deal->getTranslation('title'),
                'text_color' => $deal->text_color,
                'banner' => api_asset($deal->banner)
            ];
        }
        return response()->json([
            'result' => true,
            'data' => $data,
        ], 200);
    }

    public function transaction_history(Request $request)
    {
        $added_to_wallet = Wallet::where('wallets.type', 'add')->where('wallets.status', 1)->where('wallets.user_id', $request->user_id)
        ->leftJoin('users as recharger','recharger.id', 'wallets.charge_by')
        ->select('wallets.user_id', 'wallets.charge_by', 'recharger.name', 'recharger.email', 'wallets.amount',
        'wallets.payment_method', 'wallets.created_at', 'wallets.payment_details','wallets.remarks')
        ->orderBy('wallets.id', 'desc')
        ->get();
        $timezone = user_timezone($request->user_id);
        $data['added_to_wallet'] = $added_to_wallet->map(function($data) use($timezone){
            $payment_data = json_decode($data->payment_details);
            return [
                'recharge_by' => ($data->user_id != $data->charge_by)?$data->name.' ('.$data->email.')':'self',
                'order_code' => '',
                'amount' => format_price($data->amount),
                'payment_method' => $data->payment_method,
                'transaction_id' => (isset($payment_data->transid))?$payment_data->transid:'',
                'remarks' => $data->remarks,
                'type' => '',
                'created_at' => $data->created_at ? convert_datetime_to_local_timezone($data->created_at, $timezone) : '',
            ];
         });

        $deduct_from_wallet = CarWashPayment::where('car_wash_payments.user_id', $request->user_id)
        ->leftJoin('orders', 'orders.id', '=', 'car_wash_payments.order_id')
        ->select('car_wash_payments.id', 'car_wash_payments.amount', 'car_wash_payments.created_at', 'orders.code')
        ->orderBy('car_wash_payments.id', 'desc')
        ->get();
        $data['deduct_from_wallet'] = $deduct_from_wallet->map(function($data) use($timezone){
            return [
                'recharge_by' => '',
                'order_code' => $data->code,
                'amount' => format_price($data->amount),
                'payment_method' => 'Wallet',
                'transaction_id' => (string) $data->id,
                'remarks' => '',
                'type' => '',
                'created_at' => $data->created_at ? convert_datetime_to_local_timezone($data->created_at, $timezone) : '',
            ];
         });

        $deduct_from_wallet_manually = Wallet::where('wallets.type', 'deduct')->where('wallets.user_id', $request->user_id)
        ->leftJoin('users as recharger','recharger.id', 'wallets.charge_by')
        ->select('wallets.user_id', 'wallets.charge_by', 'recharger.name', 'recharger.email', 'wallets.amount',
        'wallets.payment_method', 'wallets.created_at', 'wallets.payment_details','wallets.remarks')
        ->orderBy('wallets.id', 'desc')
        ->get();
        $data['deduct_from_wallet_manually'] = $deduct_from_wallet_manually->map(function($data) use($timezone){
            return [
                'recharge_by' => ($data->user_id != $data->charge_by)?$data->name.' ('.$data->email.')':'self',
                'order_code' => '',
                'amount' => format_price($data->amount),
                'payment_method' => '',
                'transaction_id' => '',
                'remarks' => $data->remarks,
                'type' => '',
                'created_at' => $data->created_at ? convert_datetime_to_local_timezone($data->created_at, $timezone) : '',
            ];
         });
         return response()->json([
            'result' => true,
            'data' => $data,
        ], 200);
    }

    public function wallet_screen($user_id)
    {
        $datas = DB::table('wallet_amounts')->select('id', 'amount', 'free_amount')->get();
        $data['amounts'] = $datas->map(function($data){
              return [
                'id' => $data->id,
                'amount' => format_price($data->amount),
                'free_amount' => format_price($data->free_amount)
              ];
        }); 
        $members = [];
        // getting parent of login user if have
        $login_user = DB::table('users')->where('id', $user_id)->select('parent_id')->first();
        if($login_user->parent_id){
          $members[] = $login_user->parent_id;
        }
        // getting childs of login user
        $childs = DB::table('users')->where('parent_id', $user_id)->select('id')->get();
        foreach($childs as $child){
            $members[] = $child->id;
        }
       $members = collect($members);
       $data['members'] = $members->map(function($member) {
        $user_data = DB::table('users')->where('id', $member)->select('name')->first();
        return [
                'id' => $member,
                'name' => $user_data->name,
            ]; 
       });

        return response()->json([
            'result' => true,
            'data' => $data,
        ], 200);
    }

    public function add_money_to_wallet(Request $request)
    { 
        $amount = DB::table('wallet_amounts')->where('id', $request->amount)->select('amount', 'free_amount')->first();
        $exact_amount = $amount->amount + $amount->free_amount;
        $wallet_id = $this->wallet_recharge($request, $exact_amount);
        $ipay = new Ipay88Controller();
        return $ipay->getCheckout($wallet_id, 'wallet_recharge', $amount->amount);
        // Bypass the payment
        // $ipay = new Ipay88Controller();
        // return $ipay->byPassWalletPayment($wallet_id);
    }

    public function wallet_recharge(Request $request, $exact_amount)
    {
        $wallet = new Wallet();
        $wallet->user_id = $request->user_id;
        $wallet->charge_by = $request->charge_by;
        $wallet->amount = $exact_amount;
        $wallet->payment_method = 'ipay88';
        $wallet->staff_code = $request->staff_code;
        $wallet->save();

        return $wallet->id;
    }

    public function wallet_recharge_done($wallet_id, $payment_details)
    {
        $wallet = Wallet::find($wallet_id);
        $wallet->payment_details = $payment_details;
        $wallet->status = 1;
        if($wallet->update()){
            $user = User::find($wallet->user_id);
            $user->balance += $wallet->amount;
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
            'user_id' => $wallet->user_id,
            'is_admin' => 3,
            'type' => 'wallet_recharge',
            'body' => translate('Hurrah!!! Your wallet has been recharged'),
            'wallet_id' => $wallet->id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $wallet->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Hurrah!!! Your wallet has been recharged')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        }
    return 1;
    }

    public function wallet_recharge_failed($wallet_id)
    {
        DB::table('wallets')->where('id', $wallet_id)->delete();
        return 1;
    }

    public function notification_details(Request $request)
    {
     $details = DB::table('notifications as n')->where('n.id', $request->id)
     ->leftJoin('wallets','wallets.id', 'n.wallet_id')
     ->leftJoin('users as recharger','recharger.id', 'wallets.charge_by')
     ->select('wallets.user_id','wallets.charge_by','recharger.name','recharger.email','wallets.amount',
    'wallets.payment_method','wallets.payment_details','wallets.created_at','wallets.remarks','wallets.type')
     ->first();
     $timezone = user_timezone($details->user_id);
     $payment_data = json_decode($details->payment_details);
     $data = [
                'recharge_by' => ($details->user_id != $details->charge_by)?$details->name.' ('.$details->email.')':'self',
                'order_code' => '',
                'amount' => format_price($details->amount),
                'payment_method' => $details->payment_method,
                'transaction_id' => (isset($payment_data->transid))?$payment_data->transid:'',
                'remarks' => $details->remarks,
                'type' => $details->type,
                'created_at' => $details->created_at ? convert_datetime_to_local_timezone($details->created_at, $timezone) : '',
            ];
     return response()->json([
        'result' => true,
        'data' => $data,
    ], 200);
    }
}
