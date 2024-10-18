<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealTranslation;
use App\Models\DealProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $deals = Deal::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $deals = $deals->where('title', 'like', '%' . $sort_search . '%');
        }
        $deals = $deals->paginate(15);
        return view('backend.marketing.deals.index', compact('deals', 'sort_search'));
    }

    public function create()
    {
        return view('backend.marketing.deals.create');
    }

    public function store(Request $request)
    {
        $deal = new Deal;
        $deal->title = $request->title;
        $deal->type = $request->type;
        $deal->text_color = $request->text_color;
        $date_var               = explode(" to ", $request->date_range);
        $deal->start_date = strtotime($date_var[0]);
        $deal->end_date   = strtotime($date_var[1]);
        $deal->slug = strtolower(str_replace(' ', '-', $request->title) . '-' . Str::random(5));
        $deal->banner = $request->banner;
        if ($deal->save()) {
            if(($request->type == 'today' || $request->type == 'tyre') && !empty($request->products)){
                foreach ($request->products as $key => $product) {
                    $deal_product = new DealProduct();
                    $deal_product->deal_id = $deal->id;
                    $deal_product->product_id = $product;
                    $deal_product->save();
                    $root_product = Product::findOrFail($product);
                    $root_product->discount = $request['discount_' . $product];
                    $root_product->discount_type = $request['discount_type_' . $product];
                    $root_product->discount_start_date = strtotime($date_var[0]);
                    $root_product->discount_end_date   = strtotime($date_var[1]);
                    $root_product->save();
                }
            }
            else if($request->type == 'car_wash' && !empty($request->carwash_products)){
                foreach ($request->carwash_products as $key => $product) {
                    $deal_product = new DealProduct();
                    $deal_product->deal_id = $deal->id;
                    $deal_product->product_id = $product;
                    $deal_product->save();
                }
            }

            $deal_translation = DealTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'deal_id' => $deal->id]);
            $deal_translation->title = $request->title;
            $deal_translation->save();

            flash(translate('Deal has been inserted successfully'))->success();
            return redirect()->route('deals.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $deal = Deal::findOrFail($id);
        return view('backend.marketing.deals.edit', compact('deal', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $deal = Deal::findOrFail($id);
        $deal->text_color = $request->text_color;
        $deal->type = $request->type;
        $date_var               = explode(" to ", $request->date_range);
        $deal->start_date = strtotime($date_var[0]);
        $deal->end_date   = strtotime($date_var[1]);

        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $deal->title = $request->title;
            if ($deal->title != $request->title) {
                $deal->slug = strtolower(str_replace(' ', '-', $request->title) . '-' . Str::random(5));
            }
        }

        $deal->banner = $request->banner;
        DB::table('deal_products')->where('deal_id', $id)->delete();
        if ($deal->save()) {
            if(($request->type == 'today' || $request->type == 'tyre') && !empty($request->products)){
                foreach ($request->products as $key => $product) {
                    $deal_product = new DealProduct();
                    $deal_product->deal_id = $deal->id;
                    $deal_product->product_id = $product;
                    $deal_product->save();
                    $root_product = Product::findOrFail($product);
                    $root_product->discount = $request['discount_' . $product];
                    $root_product->discount_type = $request['discount_type_' . $product];
                    $root_product->discount_start_date = strtotime($date_var[0]);
                    $root_product->discount_end_date   = strtotime($date_var[1]);
                    $root_product->save();
                }
            }
            else if($request->type == 'car_wash' && !empty($request->carwash_products)){
                foreach ($request->carwash_products as $key => $product) {
                    $deal_product = new DealProduct();
                    $deal_product->deal_id = $deal->id;
                    $deal_product->product_id = $product;
                    $deal_product->save();
                }
            }

            $sub_category_translation = DealTranslation::firstOrNew(['lang' => $request->lang, 'deal_id' => $deal->id]);
            $sub_category_translation->title = $request->title;
            $sub_category_translation->save();

            flash(translate('Deal has been updated successfully'))->success();
            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function destroy($id)
    {
        $deal = Deal::findOrFail($id);
        DB::table('deal_products')->where('deal_id', $id)->delete();
        foreach ($deal->deal_translations as $key => $deal_translation) {
            $deal_translation->delete();
        }
        Deal::destroy($id);
        flash(translate('Deal has been deleted successfully'))->success();
        return redirect()->route('deals.index');
    }

    public function update_status(Request $request)
    {
        $deal = Deal::findOrFail($request->id);
        $deal->status = $request->status;
        if ($deal->save()) {
            flash(translate('Deal status updated successfully'))->success();
            return 1;
        }
        return 0;
    }

    public function product_discount(Request $request)
    {
        $product_ids = $request->product_ids;
        return view('backend.marketing.deals.deal_discount', compact('product_ids'));
    }

    public function product_discount_edit(Request $request)
    {
        $product_ids = $request->product_ids;
        $deal_id = $request->deal_id;
        return view('backend.marketing.deals.deal_discount_edit', compact('product_ids', 'deal_id'));
    }
}
