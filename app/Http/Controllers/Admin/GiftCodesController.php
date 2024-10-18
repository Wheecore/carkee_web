<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\GiftCodesExport;

class GiftCodesController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $date = $request->date;
        $coupons = GiftCode::where('type', 'car_wash');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $coupons = $coupons->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($date != null) {
            $exploded_date = explode(" to ", $date);
            $coupons = $coupons->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $coupons = $coupons->orderBy('id', 'desc')->paginate(15);
        return view('backend.marketing.gift_codes.index', compact('coupons','sort_search','date'));
    }

    public function create()
    {
        return view('backend.marketing.gift_codes.create');
    }

    public function store(Request $request)
    {
        // $zeros = '';
        // for($j = 1; $j<= $request->zeros; $j++){
        //    $zeros .= 0;
        // }
        for($i= 1; $i <= $request->no_of_codes; $i++){
            $code = $request->first_letter.substr(sha1(mt_rand()),17,9);
            if (GiftCode::where('code', '!=', null)->where('code', $code)->first() == null) {
            $coupon = new GiftCode;
            $coupon->type             = 'car_wash';
            $coupon->code             = $code;
            $coupon->category         = $request->category;
            $coupon->discount_amount    = $request->amount;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime($date_var[1]);
            $coupon->save();
                // flash(translate('Gift Code already exist for this number '.$code))->error();
                // return back();
            }
        }
        flash(translate('Gift Code has been saved successfully'))->success();
        return redirect()->route('gift-codes.index');
    }

    public function edit($id)
    {
        $coupon = GiftCode::findOrFail(decrypt($id));
        return view('backend.marketing.gift_codes.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        if (GiftCode::where('code', '!=', null)->where('id', '!=', $id)->where('code', $request->code)->first()) {
            flash(translate('Record already exist for this code'))->error();
            return back();
        }

        $coupon = GiftCode::findOrFail($id);
        $coupon->code = $request->code;
        $coupon->category = $request->category;
        $coupon->discount_amount  = $request->amount;
        $date_var                 = explode(" - ", $request->date_range);
        $coupon->start_date       = strtotime($date_var[0]);
        $coupon->end_date         = strtotime($date_var[1]);
        if ($coupon->save()) {
            flash(translate('Gift Code has been saved successfully'))->success();
            return redirect()->route('gift-codes.index');
        } else {
            flash(translate('Something went wrong'))->danger();
            return back();
        }
    }

    public function destroy($id)
    {
        GiftCode::findOrFail($id);
        if (GiftCode::destroy($id)) {
            DB::table('gift_code_usages')->where('gift_code_id', $id)->delete();
            flash(translate('Record has been deleted successfully'))->success();
            return redirect()->route('gift-codes.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
  
    public function export(Request $request)
    {
        $date = $request->date;
        return Excel::download(new GiftCodesExport($date), 'gift_codes.xlsx');
    }
}
