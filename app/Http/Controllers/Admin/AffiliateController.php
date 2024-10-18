<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Addon;
use App\User;
use App\Models\AffiliateConfig;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    public function index()
    {
     $data = AffiliateConfig::first(); 
     return view('backend.affiliate.index', compact('data'));
    }

    public function affiliate_config_store(Request $request)
    {
        $affiliate_config = AffiliateConfig::first();
        if ($affiliate_config) {
            $affiliate_config->first_purchase_amount = $request->first_purchase_amount;
            $affiliate_config->minimum_purchase_amount = $request->minimum_purchase_amount;
            $affiliate_config->status = $request->status;
            $affiliate_config->expiry_months = $request->expiry_months;
            $affiliate_config->update();
        }
        else{
            $affiliate_config = new AffiliateConfig;
            $affiliate_config->first_purchase_amount = $request->first_purchase_amount;
            $affiliate_config->minimum_purchase_amount = $request->minimum_purchase_amount;
            $affiliate_config->status = $request->status;
            $affiliate_config->expiry_months = $request->expiry_months;
            $affiliate_config->save();
        }
        flash("Data has been saved successfully")->success();
        return back();
    }

    public function processAffiliateAmount(User $login_user, $grand_total)
    {
        $affiliate_addon = Addon::where('unique_identifier', 'affiliate_system')->select('activated')->first();
        $affiliate_config = AffiliateConfig::select('first_purchase_amount','minimum_purchase_amount','status','expiry_months')->first();
        if(($affiliate_addon != null && $affiliate_addon->activated == 1) && ($affiliate_config != null && $affiliate_config->status == 1) && $grand_total >= $affiliate_config->minimum_purchase_amount)
        {
            $start_date = date('d-m-Y', strtotime(Carbon::now()));
            $no_of_days = $affiliate_config->expiry_months * 30;
            $end_date_format = Carbon::now()->addDays($no_of_days);
            $end_date = date('d-m-Y', strtotime($end_date_format));
            // add coupon for referred user
                  $coupon = new Coupon;
                  $coupon->user_id = $login_user->id;
                  $coupon->reffered_by = $login_user->referred_by;
                  $coupon->type             = 'cart_base';
                  $coupon->code             = Str::random(11);
                  $coupon->discount         = $affiliate_config->first_purchase_amount;
                  $coupon->discount_type    = 'amount';
                  $coupon->start_date       = strtotime($start_date);
                  $coupon->end_date         = strtotime($end_date);
                  $coupon->details = '{"min_buy":"1"}';
                  $coupon->limit         = 1;
                  $coupon->save();

                 DB::table('users')->where('id', $login_user->id)->update([
                     'referral_status' => 1
                ]); 

                // add coupon for referred by user
                  $coupon = new Coupon;
                  $coupon->user_id = $login_user->referred_by;
                  $coupon->type             = 'cart_base';
                  $coupon->code             = Str::random(11);
                  $coupon->discount         = $affiliate_config->first_purchase_amount;
                  $coupon->discount_type    = 'amount';
                  $coupon->start_date       = strtotime($start_date);
                  $coupon->end_date         = strtotime($end_date);
                  $coupon->details = '{"min_buy":"1"}';
                  $coupon->limit         = 1;
                  $coupon->save();
                }
    }

    public function refferal_users()
    {
        $refferal_users = User::where('referred_by', '!=', null)->paginate(10);
        return view('backend.affiliate.refferal_users', compact('refferal_users'));
    }

    public function refferal_coupons()
    {
        $refferal_coupons = DB::table('coupons as c')->where('c.user_id', '!=', Auth::user()->id)
        ->leftJoin('users','users.id','c.user_id')
        ->select('users.name','c.code','c.discount','c.start_date','c.end_date','c.limit')
        ->paginate(10);
        return view('backend.affiliate.referral_coupons', compact('refferal_coupons'));
    }
}
