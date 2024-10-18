<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCodeUsage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiftCodesHistoryController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $redeem_status = null;
        $coupons_history = DB::table('gift_code_usages as gc_usage')
        ->join('gift_codes','gift_codes.id', 'gc_usage.gift_code_id')
        ->LeftJoin('users','users.id', 'gc_usage.given_to')
        ->leftJoin('users as reedemer','reedemer.id', 'gc_usage.redeem_by')
        ->orderBy('gc_usage.id', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $coupons_history = $coupons_history->where(function ($query) use ($sort_search) {
                $query->where('gift_codes.code', 'like', '%' . $sort_search . '%')
                    ->orWhere('users.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('users.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('reedemer.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('reedemer.email', 'like', '%' . $sort_search . '%');
            });
        }
        if ($request->redeem_status != null) {
            $redeem_status = $request->redeem_status;
            if($redeem_status == 'redeem'){
                $coupons_history = $coupons_history->whereNotNull('redeem_by');
            }
            else{
                $coupons_history = $coupons_history->whereNull('redeem_by');
            }
        }
        
        $coupons_history = $coupons_history->select('gift_codes.code','gift_codes.category','gift_codes.start_date','gift_codes.end_date','gift_codes.discount_amount',
        'gc_usage.id','gc_usage.created_at','gc_usage.redeem_date','users.name as given_user_name',
        'users.email as given_user_email','reedemer.name as reedemer_user_name','reedemer.email as reedemer_user_email')
        ->paginate(15);
        $timezone = user_timezone(Auth::id());

        // fetch all coupons except the ones that are in usage table
        $coupons = DB::table('gift_codes as gc')
        ->leftjoin('gift_code_usages as gc_usage','gc_usage.gift_code_id', 'gc.id')
        ->where('gc.type','car_wash')
        ->where('gc.start_date', '<=' ,strtotime(date('Y-m-d')))
        ->where('gc.end_date', '>=', strtotime(date('Y-m-d')))
        ->whereNull('gc_usage.gift_code_id')
        ->orderBy('gc.id', 'desc')
        ->select('gc.id','gc.code','gc.start_date','gc.end_date')
        ->get();
        return view('backend.marketing.gift_codes.history', compact('coupons_history','timezone','coupons','sort_search','redeem_status'));
    }


    public function assign(Request $request)
    {
        $user = User::where('email', $request->email)->where('user_type','customer')->select('id')->first();
        if(!$user){
            flash(translate('User with this email not exists.'))->error();
            return back();
        }
        if(!empty($request->gift_codes)){
            foreach($request->gift_codes as $code_id){
                $code_usage = new GiftCodeUsage();
                $code_usage->gift_code_id = $code_id;
                $code_usage->given_to  = $user->id;
                $code_usage->save();
            }

        // Generate Notification to user
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'is_admin' => 3,
            'type' => 'codes_assign',
            'body' => translate('Hurrah!!! Your have given free gift codes. Please check it'),
            'gift_codes' => json_encode($request->gift_codes),
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $user->id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Hurrah!!! Your have given free gift codes. Please check it')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        } 
        }
        flash(translate('Codes assigning has been done successfully'))->success();
        return back();
    }

    public function destroy($id)
    {
        if (GiftCodeUsage::destroy($id)) {
            flash(translate('Record has been deleted successfully'))->success();
            return redirect()->route('gift-codes-history.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
  
}
