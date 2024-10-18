<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\MerchantVoucher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function dashboard(Request $request)
    {
        if (Auth::user()->user_type == 'seller') {
            return view('frontend.user.seller.dashboard');
        } elseif (Auth::user()->user_type == 'customer') {
            return view('frontend.user.customer.dashboard');
        } elseif (Auth::user()->user_type == 'merchant') {
            $sort_search = null;
            $merchant_vouchers = MerchantVoucher::where('merchant_id', Auth::user()->id)->orderBy('created_at', 'desc');
            if ($request->has('search')) {
                $sort_search = $request->search;
                $voucher_ids = MerchantVoucher::where(function ($voucher) use ($sort_search) {
                    $voucher->where('voucher_code', 'like', '%' . $sort_search . '%');
                })->pluck('id')->toArray();
                $merchant_vouchers = $merchant_vouchers->where(function ($voucher) use ($voucher_ids) {
                    $voucher->whereIn('id', $voucher_ids);
                });
            }
            $merchant_vouchers = $merchant_vouchers->paginate(15);
            return view('frontend.user.merchant.dashboard', compact('merchant_vouchers', 'sort_search'));
        } elseif (Auth::user()->user_type == 'delivery_boy') {
            return view('delivery_boys.frontend.dashboard');
        } elseif (Auth::user()->user_type == 'admin') {
            return view('backend.dashboard');
        } else {
            abort(404);
        }
    }

    public function seller_update_profile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $request->photo;

        $seller = $user->seller;
        $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
        $seller->bank_payment_status = $request->bank_payment_status;
        $seller->bank_name = $request->bank_name;
        $seller->bank_acc_name = $request->bank_acc_name;
        $seller->bank_acc_no = $request->bank_acc_no;
        $seller->bank_routing_no = $request->bank_routing_no;

        if ($user->save() && $seller->save()) {
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function profile(Request $request)
    {
        if (Auth::user()->user_type == 'customer') {
            return view('frontend.user.customer.profile');
        } elseif (Auth::user()->user_type == 'delivery_boy') {
            return view('delivery_boys.frontend.profile');
        } elseif (Auth::user()->user_type == 'seller') {
            return view('frontend.user.seller.profile');
        } elseif (Auth::user()->user_type == 'merchant') {
            return view('frontend.user.merchant.profile');
        }
    }

    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if (!User::where('email', $email)->where('id', '!=', Auth::id())->first()) {
            // $this->send_email_change_verification_mail($request, $email);
            // flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            $user = Auth::user();
            $user->email = $email;
            if ($user->save()) {
                flash(translate('Your email has been updated successfully!'))->success();
                return back();
            }
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

}
