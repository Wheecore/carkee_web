<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\AttachmentTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AttachmentTrait;

    public function notifications($user_id)
    {
        $notifications = DB::table('notifications')
        ->where('user_id', $user_id)
        ->select('id', 'type', 'body', 'created_at', 'is_viewed')
        ->orderBy('id', 'DESC')
        ->get()
        ->toArray();

        $notifications_count = DB::table('notifications')
        ->where('is_viewed', 0)
        ->where('user_id', $user_id)
        ->count();

        $notifications_data = [];
        foreach ($notifications as $notification) {
            $notifications_data[] = array(
                'notification_id' => $notification->id,
                'date' => $notification->created_at,
                'text' => $notification->body,
                'type' => $notification->type,
                'seen' => $notification->is_viewed,
            );
        }
        return response()->json([
            'result' => true,
            'total_notifications' => $notifications_count,
            'notifications' => $notifications_data
        ], 200);
    }

    public function notification_details($id)
    {
        DB::table('notifications')->where('id', $id)->update([
            'is_viewed' => 1
        ]);
        
        $notification = DB::table('notifications as n')
        ->where('n.id', $id)
        ->join('lottery_requests as l_r', 'l_r.id', '=', 'n.lottery_request_id')   
        ->join('products as p', 'p.id', '=', 'l_r.product_id')     
        ->join('users as u', 'u.id', '=', 'l_r.user_id')     
        ->select('p.name','p.attachment_id',DB::raw("CONCAT('#', l_r.lottery_no) AS lottery_id"),'p.expirey_date','p.token_price',
        'u.delivery_address','u.name as user_name','u.email','u.phone','u.attachment_id as user_image')
        ->first();

        return response()->json([
            'result' => true,
            'data' => [
                    'user_name' => $notification->user_name,
                    'user_email' => $notification->email,
                    'user_phone' => $notification->phone,
                    'user_image' => uploaded_asset($notification->user_image),
                    'product_name' => $notification->name,
                    'lottery_id' => $notification->lottery_id,
                    'last_date' => $notification->expirey_date,
                    'token_price' => $notification->token_price,
                    'delivery_address' => $notification->delivery_address,
                    'product_image' => uploaded_asset($notification->attachment_id)
                ],
        ], 200);
    }

    public function update_profile(Request $request)
    {
        $user_exists = User::where('email', $request->email)->where('id','!=', $request->user_id)->first();
        if ($user_exists != null) {
            return response()->json([
                'result' => false,
                'data' => [
                    'user' => null
                ],
                'message' => 'The given email already exists',
                'status' => 201
            ], 201);
        }
        $user = User::where('id', $request->user_id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->delivery_address = $request->delivery_address;
        $user->phone = $request->phone;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $user->attachment_id = $this->addAttachment($request->image);
        }
        $user->update();

        return response()->json([
            'result' => true,
            'data' => [
                'id' => $user->id,
                'user_type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'provider' => $user->provider,
                'profile_img' => uploaded_asset($user->attachment_id),
                'provider_id' => $user->provider_id,
                'delivery_address' => $user->delivery_address
            ],
            'message' => '',
            'status' => 200
        ], 200);
    }
    
    public function lottery_history(Request $request)
    {
        $requested_history = DB::table('lottery_requests as l_r')->where('l_r.user_id', $request->user_id)->where('l_r.status', 'requested')
        ->where('l_r.lottery_announced', 0)
        ->join('products as p', 'p.id', '=', 'l_r.product_id')
        ->join('users as u', 'u.id', '=', 'l_r.user_id')
        ->select('l_r.product_id','p.name','p.attachment_id',DB::raw("CONCAT('#', l_r.lottery_no) AS lottery_id"),
        'l_r.created_at','p.expirey_date','p.token_price','u.delivery_address')
        ->orderBy('l_r.id','desc')
        ->get();

        $winner_history = DB::table('lottery_requests as l_r')->where('l_r.user_id', $request->user_id)->where('l_r.status', 'winner')
        ->join('products as p', 'p.id', '=', 'l_r.product_id')
        ->join('users as u', 'u.id', '=', 'l_r.user_id')
        ->select('l_r.product_id','p.name','p.attachment_id',DB::raw("CONCAT('#', l_r.lottery_no) AS lottery_id"),
        'l_r.created_at','p.expirey_date','p.token_price','u.delivery_address','l_r.winning_date','l_r.members_applied')
        ->orderBy('l_r.id','desc')
        ->get();

        $requested_history_arr = $requested_history->map(function($history){
            return [
                'product_id' => 0,
                'user_id' => 0,
                'name' => $history->name,
                'lottery_id' => $history->lottery_id,
                'applied_customers' => DB::table('lottery_requests')->where('product_id', $history->product_id)->where('lottery_announced', 0)->count(),
                'apply_date' => $history->created_at,
                'winning_date' => '',
                'last_date' => $history->expirey_date,
                'token_price' => $history->token_price,
                'delivery_address' => $history->delivery_address,
                'product_image' => uploaded_asset($history->attachment_id)
            ];
        });

        $winner_history_arr = $winner_history->map(function($history){
            return [
                'product_id' => 0,
                'user_id' => 0,
                'name' => $history->name,
                'lottery_id' => $history->lottery_id,
                'applied_customers' => $history->members_applied,
                'apply_date' => $history->created_at,
                'winning_date' => $history->winning_date,
                'last_date' => $history->expirey_date,
                'token_price' => $history->token_price,
                'delivery_address' => $history->delivery_address,
                'product_image' => uploaded_asset($history->attachment_id)
            ];
        });

        return response()->json([
            'result' => true,
            'requested_data' => $requested_history_arr,
            'winner_data' => $winner_history_arr,
        ], 200);
    }

    protected function winner_user_data($id)
    {
        $user_data = DB::table('lottery_requests as l_r')->where('l_r.id', $id)
        ->join('users as u', 'u.id', '=', 'l_r.user_id')
        ->select('u.name','u.email','u.phone','u.attachment_id','u.delivery_address')
        ->first();
        return response()->json([
            'result' => true,
            'data' => [
                'name' => $user_data->name,
                'email' => $user_data->email,
                'phone' => $user_data->phone,
                'delivery_address' => $user_data->delivery_address,
                'image' => uploaded_asset($user_data->attachment_id),
            ],
        ], 200);
    }
}
