<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MerchantCategory;
use Illuminate\Http\Request;
use App\User;

class MerchantCategoryController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $merchant_categories = MerchantCategory::orderBy('id', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $cat_ids = MerchantCategory::where('name', 'like', '%' . $sort_search . '%')->pluck('id')->toArray();
            $merchant_categories = $merchant_categories->where(function ($merchant_cat) use ($cat_ids) {
                $merchant_cat->whereIn('id', $cat_ids);
            });
        }
        $merchant_categories = $merchant_categories->paginate(15);
        return view('backend.merchant_cats.index', compact('merchant_categories', 'sort_search'));
    }

    public function store(Request $request)
    {
        if (MerchantCategory::where('name', $request->name)->first() != null) {
            flash(translate('Category already exists!'))->error();
            return back();
        }
        $merchant_category = new MerchantCategory;
        $merchant_category->name = $request->name;
        if ($merchant_category->save()) {
            flash(translate('Merchant category has been inserted successfully'))->success();
            return redirect()->route('merchant.categories');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function edit($id)
    {
        $merchant_category = MerchantCategory::find($id);
        return view('backend.merchant_cats.edit', compact('merchant_category'));
    }

    public function update(Request $request, $id)
    {
        if (MerchantCategory::where('name', $request->name)->where('id', '!=', $id)->first() != null) {
            flash(translate('Category already exists!'))->error();
            return back();
        }
        $merchant_category = MerchantCategory::findOrFail($id);
        $merchant_category->name = $request->name;
        if ($merchant_category->update()) {
            flash(translate('Merchant category has been updated successfully'))->success();
            return redirect()->route('merchant.categories');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function destroy($id)
    {
        $merchant_category = MerchantCategory::find($id);
        if (User::where('merchant_category', $id)->first()) {
            flash(translate('Category already assigned to a merchant'))->error();
            return back();
        }
        if ($merchant_category->delete()) {
            flash(translate('Merchant category has been deleted successfully'))->success();
            return redirect()->route('merchant.categories');
        }
    }
}
