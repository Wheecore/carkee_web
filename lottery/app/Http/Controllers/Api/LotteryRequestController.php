<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LotteryRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Config;
use Session;

class LotteryRequestController extends Controller
{
    public function DoCheckout(Request $request)
	{	
	    return view('do_checkout_v');
        header('Access-Control-Allow-Origin: *');
		$data = $request->input();
		
		// $product_id = $data['product_id'];
		// $product = DB::select('select * from product where product_id='.$product_id);
		
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		//1.
		//get formatted price. remove period(.) from the price
		$temp_amount 	= 10*100;
		$amount_array 	= explode('.', $temp_amount);
		$pp_Amount 		= $amount_array[0];
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		//2.
		//get the current date and time
		//be careful set TimeZone in config/app.php
		$pp_TxnDateTime 		= date('YmdHis', strtotime("+0 hours"));
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		//3.
		//to make expiry date and time add one hour to current date and time
		$pp_TxnExpiryDateTime = date('YmdHis', strtotime("+8 hours"));
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		//4.
		//make unique transaction id using current date
		$pp_TxnRefNo = "T". date('YmdHis');
		//NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
		
		//--------------------------------------------------------------------------------
		//$post_data

		$post_data =  array(
			"pp_Version" 			=> Config::get('constants.jazzcash.VERSION'),
			"pp_TxnType" 			=> "MWALLET",
			"pp_Language" 			=> Config::get('constants.jazzcash.LANGUAGE'),
			"pp_MerchantID" 		=> Config::get('constants.jazzcash.MERCHANT_ID'),
			"pp_SubMerchantID" 		=> "",
			"pp_Password" 			=> Config::get('constants.jazzcash.PASSWORD'),
			"pp_BankID" 			=> "TBANK",
			"pp_ProductID" 			=> "RETL",
			"pp_TxnRefNo" 			=> $pp_TxnRefNo,
			"pp_Amount" 			=> $pp_Amount,
			"pp_TxnCurrency" 		=> Config::get('constants.jazzcash.CURRENCY_CODE'),
			"pp_TxnDateTime" 		=> $pp_TxnDateTime,
			"pp_BillReference" 		=> "billRef",
			"pp_Description" 		=> "Description of transaction",
			"pp_TxnExpiryDateTime" 	=> $pp_TxnExpiryDateTime,
			"pp_ReturnURL" 			=> Config::get('constants.jazzcash.RETURN_URL'),
			"pp_SecureHash" 		=> "",
			"ppmpf_1" 				=> "1",
			"ppmpf_2" 				=> "2",
			"ppmpf_3" 				=> "3",
			"ppmpf_4" 				=> "4",
			"ppmpf_5" 				=> "5",
		);
		
		$pp_SecureHash = $this->get_SecureHash($post_data);
		
		$post_data['pp_SecureHash'] = $pp_SecureHash;
		
		// $values = array(
		// 	'TxnRefNo'    => $post_data['pp_TxnRefNo'],
		// 	'amount' 	  => $product[0]->price,
		// 	'description' => $post_data['pp_Description'],
		// 	'status' 	  => 'pending'
		// );
		// DB::table('order')->insert($values);
		
		
		Session::put('post_data',$post_data);
		
		return view('do_checkout_v');
	}

    private function get_SecureHash($data_array)
	{
		ksort($data_array);
		
		$str = '';
		foreach($data_array as $key => $value){
			if(!empty($value)){
				$str = $str . '&' . $value;
			}
		}
		
		$str = Config::get('constants.jazzcash.INTEGERITY_SALT').$str;
		
		$pp_SecureHash = hash_hmac('sha256', $str, Config::get('constants.jazzcash.INTEGERITY_SALT'));
		return $pp_SecureHash;
	}

    public function paymentStatus(Request $request)
	{
		$response = $request->input();
        dd($response);
		
		if($response['pp_ResponseCode'] == '000')
		{
			$response['pp_ResponseMessage'] = 'Your Payment has been Successful';
			$values = array('status' => 'completed');
			// DB::table('order')
			// 	->where('TxnRefNo',$response['pp_TxnRefNo'])
			// 	->update(['status' => 'completed']);
		}
		
		return view('payment-status',['response'=>$response]);
	}
	
    public function apply_for_lottery(Request $request)
    {
        $request_exists = DB::table('lottery_requests')->where('user_id', $request->user_id)->where('product_id', $request->product_id)->where('status', 'requested')->where('lottery_announced', 0)->first();
        if(!$request_exists){
        $l_request = new LotteryRequest();
        $l_request->user_id = $request->user_id;   
        $l_request->product_id = $request->product_id;   
        $l_request->lottery_no = rand(1,10000000000);   
        $l_request->save();  

        // Generate Notification to user
        Notification::create([
            'user_id' => $request->user_id,
            'is_admin' => 2,
            'type' => 'lottery_apply',
            'body' => 'You have successfully applied the lottery',
            'lottery_request_id' => $l_request->id,
        ]);

        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $request->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => 'You have successfully applied the lottery'
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }

        // Generate Notification to admin
        $admin_data = DB::table('users')->where('user_type', 'admin')->select('id')->first();
        Notification::create([
            'user_id' => $admin_data->id,
            'is_admin' => 1,
            'type' => 'lottery_apply',
            'body' => 'A new user has successfully applied the lottery',
            'lottery_request_id' => $l_request->id,
        ]);

        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $admin_data->id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => 'A new user has successfully applied the lottery'
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }

        return response()->json([
            'result' => true,
            'message' => 'Your Request has been sent successfully',
        ], 200);
    }
    else{
        return response()->json([
            'result' => false,
            'message' => 'Sorry!! Request for this product is already exists',
        ], 200);
    }
    }

    public function lottery_history()
    {
        $requested_history = DB::table('products as p')
        ->join('lottery_requests as l_r', 'p.id', '=', 'l_r.product_id')
        ->where('l_r.status', 'requested')
        ->where('l_r.lottery_announced', 0)
        ->join(DB::raw('(SELECT product_id, MAX(id) as max_id FROM lottery_requests GROUP BY product_id) as latest_details'), function ($join) {
            $join->on('l_r.product_id', '=', 'latest_details.product_id');
            $join->on('l_r.id', '=', 'latest_details.max_id');
        })
        ->select('l_r.product_id','p.name','p.attachment_id','l_r.created_at','p.expirey_date','p.token_price',DB::raw("CONCAT('#', l_r.lottery_no) AS lottery_id"))
        ->orderBy('l_r.id','desc')
        ->get();

        $winner_history = DB::table('lottery_requests as l_r')->where('l_r.status', 'winner')
        ->join('products as p', 'p.id', '=', 'l_r.product_id')
        ->select('l_r.product_id','l_r.id','p.name','p.attachment_id',DB::raw("CONCAT('#', l_r.lottery_no) AS lottery_id"),
        'l_r.created_at','p.expirey_date','p.token_price','l_r.winning_date','l_r.members_applied')
        ->orderBy('l_r.id','desc')
        ->get();

        $requested_history_arr = $requested_history->map(function($history){
            return [
                'id' => 0,
                'product_id' => $history->product_id,
                'name' => $history->name,
                'lottery_id' => $history->lottery_id,
                'applied_customers' => DB::table('lottery_requests')->where('product_id', $history->product_id)->where('lottery_announced', 0)->count(),
                'apply_date' => $history->created_at,
                'winning_date' => '',
                'last_date' => $history->expirey_date,
                'token_price' => $history->token_price,
                'delivery_address' => '',
                'product_image' => uploaded_asset($history->attachment_id)
            ];
        });

        $winner_history_arr = $winner_history->map(function($history){
            return [
                'id' => $history->id,
                'product_id' => $history->product_id,
                'name' => $history->name,
                'lottery_id' => $history->lottery_id,
                'applied_customers' => $history->members_applied,
                'apply_date' => $history->created_at,
                'winning_date' => $history->winning_date,
                'last_date' => $history->expirey_date,
                'token_price' => $history->token_price,
                'delivery_address' => '',
                'product_image' => uploaded_asset($history->attachment_id)
            ];
        });

        return response()->json([
            'result' => true,
            'requested_data' => $requested_history_arr,
            'winner_data' => $winner_history_arr,
        ], 200);
    }

    public function product_applied_users(Request $request)
    {
        $applied_users = DB::table('lottery_requests as l_r')
        ->where('l_r.product_id', $request->product_id)
        ->where('l_r.status', 'requested')
        ->where('l_r.lottery_announced', 0)
        ->join('users as u', 'u.id', '=', 'l_r.user_id')
        ->select('u.name','u.email','u.phone','u.attachment_id','u.delivery_address')
        ->get();

        $users_data = $applied_users->map(function($applied_user){
            return [
                'name' => $applied_user->name,
                'email' => $applied_user->email,
                'phone' => $applied_user->phone,
                'delivery_address' => $applied_user->delivery_address,
                'image' => uploaded_asset($applied_user->attachment_id),
            ];
        }); 
        return response()->json([
            'result' => true,
            'users' => $users_data,
        ], 200);
    }

    public function pick_lottery_winner(Request $request)
    {
        $requests = DB::table('lottery_requests')->where('product_id', $request->product_id)->where('status', 'requested')->where('lottery_announced', 0)->pluck('user_id');
        // Get the total number of users
        $totalUsers = count($requests);
        // Generate a random index within the range of the array
        $randomIndex = mt_rand(0, $totalUsers - 1);
        // Get the randomly selected user
        $randomUser = $requests[$randomIndex];
        // update the status for selected user
        DB::table('lottery_requests')->where('user_id', $randomUser)->where('product_id', $request->product_id)->where('status', 'requested')->where('lottery_announced', 0)->update([
            'status' => 'winner',
            'winning_date' => now()
        ]);
        // now update the remaining products of this lottery
        DB::table('lottery_requests')->where('product_id', $request->product_id)->where('lottery_announced', 0)->update([
            'lottery_announced' => 1,
            'members_applied' => $totalUsers
        ]);   
        
        $lottery_request = DB::table('lottery_requests')->where('product_id', $request->product_id)->where('user_id', $randomUser)->where('status', 'winner')
        ->select('id')->orderBy('id', 'desc')->first();
        // Generate Notification to winner user
        Notification::create([
            'user_id' => $randomUser,
            'is_admin' => 2,
            'type' => 'lottery_win',
            'body' => 'Hurrah!!! You have won the lottery',
            'lottery_request_id' => $lottery_request->id,
        ]);

        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $randomUser)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => 'Hurrah!!! You have won the lottery'
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        
        $user = User::find($randomUser);
        $user_data = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'delivery_address' => $user->delivery_address,
            'image' => uploaded_asset($user->attachment_id),
        ];

        return response()->json([
            'result' => true,
            'data' => $user_data,
            'message' => 'Hurrah!!! We have Got the winner',
        ], 200);
    }
}
