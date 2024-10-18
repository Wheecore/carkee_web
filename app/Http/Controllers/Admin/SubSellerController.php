<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\User;

class SubSellerController extends Controller
{
    public function index(Request $request, $seller_id)
    {
        $sort_search = null;
        $sub_sellers = User::where('users.parent_id', $seller_id)
        ->where('users.user_type', 'seller')
        ->leftJoin('sellers','sellers.user_id', 'users.id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $sub_sellers = $sub_sellers->where(function ($query) use ($sort_search) {
                $query->where('users.name', 'like', '%' . $sort_search . '%')
                ->orWhere('users.email', 'like', '%' . $sort_search . '%');
            });
        }
        $sub_sellers = $sub_sellers->orderBy('users.created_at', 'desc')->select('users.id','users.name','users.email','users.phone',
        'users.avatar_original','users.banned')->paginate(15);
        $shop_data = DB::table('shops')->where('user_id', $seller_id)->select('name')->first();
        return view('backend.sub_sellers.index', compact('sub_sellers', 'shop_data', 'seller_id', 'sort_search'));
    }

    public function create($id)
    {
        return view('backend.sub_sellers.create', compact('id'));
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
        $user->parent_id = $request->seller_id;
        $user->avatar_original = $request->profile_img;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            $seller = new Seller;
            $seller->user_id = $user->id;
            $seller->save();
            flash(translate('Account has been inserted successfully'))->success();
            return redirect()->route('sub_sellers.index', $request->seller_id);
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function edit($id)
    {
        $seller = User::findOrFail($id);
        return view('backend.sub_sellers.edit', compact('seller'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (User::where('email', $request->email)->where('id','!=', $user->id)->first() != null) {
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar_original = $request->profile_img;
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if ($user->save()) {
            flash(translate('Account has been updated successfully'))->success();
            return redirect()->route('sub_sellers.index', $user->parent_id);
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function destroy($id)
    {
        User::destroy($id);
        Seller::where('user_id',$id)->delete();
        flash(translate('Account has been deleted successfully'))->success();
        return redirect()->back();
    }

    public function bulk_seller_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $seller_id) {
                $this->destroy($seller_id);
            }
        }

        return 1;
    }

    public function ban($id)
    {
        $seller = User::findOrFail($id);

        if ($seller->banned == 1) {
            $seller->banned = 0;
            flash(translate('Account has been unbanned successfully'))->success();
        } else {
            $seller->banned = 1;
            flash(translate('Account has been banned successfully'))->success();
        }

        $seller->save();
        return back();
    }
}
