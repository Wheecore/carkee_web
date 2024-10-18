<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function user_coupons()
    {
        if (Auth::check()) {
            $coupons = Coupon::where('user_id', Auth::id())->get();
            return view('frontend.user.coupon.index', compact('coupons'));
        }
        return view('auth.login');
    }
}
