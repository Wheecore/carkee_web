<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\MerchantVoucher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function merchant_update_profile(Request $request)
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

        if ($user->save()) {
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function getMerchantVouchers(Request $request)
    {
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
        return view('frontend.user.merchant.vouchers', compact('merchant_vouchers', 'sort_search'));
    }

    public function checkMerchantVouchers($voucher_code, $user_email)
    {
        $user = User::where('email', $user_email)->select('id', 'user_type')->first();
        if ($user && $user->user_type == 'customer') {
            $user_id = $user->id;
            $merchant_voucher = MerchantVoucher::where('merchant_id', Auth::user()->id)->where('voucher_code', $voucher_code)->whereJsonDoesntContain('used_by', $user_id)->first();
            if (!$merchant_voucher) {
                flash('Voucher code is invalid.')->error();
                return redirect()->route('dashboard');
            } else if ($merchant_voucher && $merchant_voucher->used_count >= $merchant_voucher->total_limit) {
                flash('This voucher code limit is already fulled.')->error();
                return redirect()->route('dashboard');
            } else {
                $used_by = $merchant_voucher->used_by;
                if ($used_by == '[]') {
                    $used_by = '[' . $user_id . ']';
                } else {
                    $used_by = str_replace("]", "", $used_by);
                    $used_by = $used_by . ',' . $user_id . ']';
                }
                $merchant_voucher->update([
                    'used_count' => $merchant_voucher->used_count + 1,
                    'used_by' => $used_by
                ]);
                flash(translate('Voucher code has been successfully used against this user.'))->success();
                return redirect()->route('dashboard');
            }
        } else {
            flash('The user email address is invalid.')->error();
            return redirect()->route('dashboard');
        }
    }
}
