<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MerchantVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NearMerchantsController extends Controller
{
    public function index()
    {
        return view('frontend.user.near_merchants');
    }

    public function frontIndex()
    {
        $mapShops = [];
        $merchant_categories = DB::table('merchant_categories')->get();
        $merchants = DB::table('users')->where('user_type', 'merchant')->select('id')->get();
        if (count($merchants) > 0) {
            $merchant_ids = [];
            foreach ($merchants as $merchant) {
                array_push($merchant_ids, $merchant->id);
            }
            $shops = DB::table("shops")->whereIn('user_id', $merchant_ids);
            $latitude = $shops->count() ? $shops->average('latitude') : 27.72;
            $longitude = $shops->count() ? $shops->average('longitude') : 85.36;
            $shops = $shops->select("*", DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                                + sin(radians(" . $latitude . ")) * sin(radians(latitude))) AS distance"));
            $shops     =    $shops->orderBy('distance', 'asc');
            $mapShops  = $shops->get();
        }
        return view('frontend.merchants.index', compact('mapShops', 'merchant_categories'));
    }
    public function voucherDetails($id)
    {
        $voucher = MerchantVoucher::find($id);
        return view('frontend.merchants.voucher_details', compact('voucher'));
    }

    public function getMerchantVouchers(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $m_vouchers = MerchantVoucher::where('merchant_id', $request->merchant_id)->whereRaw('total_limit > used_count')->whereJsonDoesntContain('used_by', $user_id)->get();
        } else {
            $m_vouchers = MerchantVoucher::where('merchant_id', $request->merchant_id)->whereRaw('total_limit > used_count')->get();
        }
        $shop_name = $request->shop_name;
        return view('frontend.user.voucher_details', compact('m_vouchers', 'shop_name'));
    }
}
