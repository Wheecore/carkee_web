<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MerchantVoucher;
use Illuminate\Http\Request;
use App\User;

class MerchantVouchersController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $merchant_vouchers = MerchantVoucher::orderBy('created_at', 'desc');
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
        return view('backend.merchants-vouchers.index', compact('merchant_vouchers', 'sort_search'));
    }

    public function create()
    {
        $merchants = User::where('user_type', 'merchant')->select('id', 'name')->get();
        return view('backend.merchants-vouchers.create', compact('merchants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required',
            'voucher_code' => 'required',
            'total_limit' => 'required',
            'amount' => 'required'
        ]);
        if (MerchantVoucher::where('voucher_code', $request->voucher_code)->first() != null) {
            flash(translate('This voucher code already exists!'))->error();
            return back();
        }
        $code = new MerchantVoucher;
        $code->merchant_id = $request->merchant_id;
        $code->voucher_code = $request->voucher_code;
        $code->total_limit = $request->total_limit;
        $code->amount = $request->amount;
        $code->used_by = '[]';
        $code->description = $request->description;
        $code->image = $request->thumbnail_img;
        if ($code->save()) {
            flash(translate('Voucher code has been inserted successfully'))->success();
            return redirect()->route('merchants-vouchers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function edit($id)
    {
        $merchant_voucher = MerchantVoucher::findOrFail(decrypt($id));
        $merchants = User::where('user_type', 'merchant')->select('id', 'name')->get();
        return view('backend.merchants-vouchers.edit', compact('merchant_voucher', 'merchants'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'merchant_id' => 'required',
            'voucher_code' => 'required',
            'total_limit' => 'required',
            'amount' => 'required'
        ]);
        if (MerchantVoucher::where('voucher_code', $request->voucher_code)->where('id', '!=', $id)->first() != null) {
            flash(translate('This voucher code already exists!'))->error();
            return back();
        }
        $code = MerchantVoucher::findOrFail($id);
        $code->merchant_id = $request->merchant_id;
        $code->voucher_code = $request->voucher_code;
        $code->total_limit = $request->total_limit;
        $code->amount = $request->amount;
        $code->description = $request->description;
        $code->image = $request->thumbnail_img;
        if ($code->save()) {
            flash(translate('Voucher code has been updated successfully'))->success();
            return redirect()->route('merchants-vouchers.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function destroy($id)
    {
        $user = MerchantVoucher::findOrFail($id);
        if ($user->delete()) {
            flash(translate('Voucher code has been deleted successfully'))->success();
            return redirect()->route('merchants-vouchers.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_merchant_voucher_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $voucher_id) {
                $this->destroy($voucher_id);
            }
        }
        return 1;
    }
}
