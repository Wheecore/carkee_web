<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MerchantCategory;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $merchants = User::where('user_type', 'merchant')->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'merchant')->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
            $merchants = $merchants->where(function ($merchant) use ($user_ids) {
                $merchant->whereIn('id', $user_ids);
            });
        }
        $merchants = $merchants->paginate(15);
        return view('backend.merchants.index', compact('merchants', 'sort_search'));
    }

    public function create()
    {
        $categories = MerchantCategory::get();
        return view('backend.merchants.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (User::where('email', $request->email)->first() != null) {
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = "merchant";
        $user->password = Hash::make($request->password);
        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->merchant_category = $request->category;
        $user->is_recommended = $request->recommended;
        if ($user->save()) {
            // create shop for this merchant
            $shop = new Shop();
            $shop->user_id = $user->id;
            $shop->name = $request->name . " shop";
            $shop->slug = Str::slug($request->name, '-');
            $shop->save();

            flash(translate('Merchant has been inserted successfully'))->success();
            return redirect()->route('merchants.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function edit($id)
    {
        $merchant = User::findOrFail(decrypt($id));
        $categories = MerchantCategory::get();
        $shop = Shop::where('user_id', decrypt($id))->select('address', 'latitude', 'longitude')->first();
        return view('backend.merchants.edit', compact('merchant', 'categories', 'shop'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (User::where('email', $request->email)->where('id', '!=', $id)->first() != null) {
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $shop = Shop::where('user_id', $id)->first();
        if ($user->name != $request->name) {
            $shop->name = $request->name . " shop";
            $shop->slug = Str::slug($request->name, '-');
        }
        $shop->address = $request->address;
        $shop->latitude = $request->latitude;
        $shop->longitude = $request->longitude;
        $shop->update();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->merchant_category = $request->category;
        $user->is_recommended = $request->recommended;
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if ($user->save()) {
            flash(translate('Merchant has been updated successfully'))->success();
            return redirect()->route('merchants.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        DB::table('shops')->where('user_id', $id)->delete();
        DB::table('merchant_vouchers')->where('merchant_id', $id)->delete();
        if ($user->delete()) {
            flash(translate('Merchant has been deleted successfully'))->success();
            return redirect()->route('merchants.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_merchant_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $merchant_id) {
                $this->destroy($merchant_id);
            }
        }
        return 1;
    }

    public function profile_modal(Request $request)
    {
        $merchant = User::findOrFail($request->id);
        return view('backend.merchants.profile_modal', compact('merchant'));
    }

    public function login($id)
    {
        $merchant = User::findOrFail(decrypt($id));
        auth()->login($merchant, true);
        return redirect()->route('dashboard');
    }
}
