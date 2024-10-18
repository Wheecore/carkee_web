<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->where('user_id', Auth::id())->where('type', '!=', 'emergency_coupon')->paginate(15);
        return view('backend.marketing.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('backend.marketing.coupons.create');
    }

    public function store(Request $request)
    {
        if (Coupon::where('code', '!=', null)->where('code', $request->coupon_code)->first()) {
            flash(translate('Coupon already exist for this coupon code'))->error();
            return back();
        }
        $coupon = new Coupon;
        $coupon->user_id = Auth::id();
        if ($request->coupon_type == "product_base") {
            $coupon->type = $request->coupon_type;
            $coupon->code = $request->coupon_code;
            $coupon->discount = $request->discount;
            $coupon->discount_type = $request->discount_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime($date_var[1]);
            $coupon->limit = $request->limit;
            $cupon_details = array();
            foreach ($request->product_ids as $product_id) {
                $data['product_id'] = $product_id;
                array_push($cupon_details, $data);
            }
            $coupon->details = json_encode($cupon_details);
            $coupon->product_ids = json_encode($request->product_ids);
            if ($coupon->save()) {
                flash(translate('Coupon has been saved successfully'))->success();
                return redirect()->route('coupon.index');
            } else {
                flash(translate('Something went wrong'))->danger();
                return back();
            }
        } elseif ($request->coupon_type == "cart_base") {
            $coupon->type             = $request->coupon_type;
            $coupon->code             = $request->coupon_code;
            $coupon->discount         = $request->discount;
            $coupon->discount_type    = $request->discount_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime($date_var[1]);
            $coupon->limit = $request->limit;
            $data                     = array();
            $data['min_buy']          = $request->min_buy;
            $data['max_discount']     = $request->max_discount;
            $coupon->details          = json_encode($data);
            if ($coupon->save()) {
                flash(translate('Coupon has been saved successfully'))->success();
                return redirect()->route('coupon.index');
            } else {
                flash(translate('Something went wrong'))->danger();
                return back();
            }
        } elseif ($request->coupon_type == "gift_base") {
            $coupon->type             = $request->coupon_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime($date_var[1]);
            $coupon->limit = $request->limit;
            $data                     = array();
            $data['min_buy']          = $request->min_buy;
            $coupon->details          = json_encode($data);
            $coupon->gift_type    = $request->discount_way;
            $coupon->discount_title    = $request->discount_title;
            $coupon->product_ids = json_encode($request->product_ids);
            if ($request->discount_way == 'discount') {
                $coupon->discount         = $request->discount;
                $coupon->discount_type    = $request->discount_type;
            } else {
                $count = $request->total_gifts;
                if ($count >= 1) {
                    $gifts = array();
                    for ($i = 1; $i <= $count; $i++) {
                        $gift_name_data = $request->input('gift_name_' . $i);
                        $gift_attach_id = $request->input('attachment_id_' . $i);
                        if ($gift_name_data != '' && $gift_attach_id != '') {
                            $gifts[$gift_attach_id] = $gift_name_data;
                        }
                    }
                    $coupon->gifts = json_encode($gifts);
                }
            }
            if ($coupon->save()) {
                flash(translate('Coupon has been saved successfully'))->success();
                return redirect()->route('coupon.index');
            } else {
                flash(translate('Something went wrong'))->danger();
                return back();
            }
        } elseif ($request->coupon_type == "warranty_reward") {
            $coupon->type             = $request->coupon_type;
            $coupon->code             = $request->coupon_code;
            $coupon->discount         = $request->discount;
            $coupon->discount_type    = $request->discount_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime($date_var[1]);
            $coupon->limit = $request->limit;
            $data                     = array();
            $data['min_buy']          = $request->min_buy;
            $coupon->details          = json_encode($data);
            if ($coupon->save()) {
                flash(translate('Coupon has been saved successfully'))->success();
                return redirect()->route('coupon.index');
            } else {
                flash(translate('Something went wrong'))->danger();
                return back();
            }
        }
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail(decrypt($id));
        return view('backend.marketing.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        if (Coupon::where('code', '!=', null)->where('id', '!=', $id)->where('code', $request->coupon_code)->first()) {
            flash(translate('Coupon already exist for this coupon code'))->error();
            return back();
        }

        $coupon = Coupon::findOrFail($id);
        if ($request->coupon_type == "product_base") {
            $coupon->type = $request->coupon_type;
            $coupon->code = $request->coupon_code;
            $coupon->discount = $request->discount;
            $coupon->discount_type  = $request->discount_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime($date_var[1]);
            $coupon->limit = $request->limit;
            $cupon_details = array();
            foreach ($request->product_ids as $product_id) {
                $data['product_id'] = $product_id;
                array_push($cupon_details, $data);
            }
            $coupon->details = json_encode($cupon_details);
            if ($coupon->save()) {
                flash(translate('Coupon has been saved successfully'))->success();
                return redirect()->route('coupon.index');
            } else {
                flash(translate('Something went wrong'))->danger();
                return back();
            }
        } elseif ($request->coupon_type == "cart_base") {
            $coupon->type           = $request->coupon_type;
            $coupon->code           = $request->coupon_code;
            $coupon->discount       = $request->discount;
            $coupon->discount_type  = $request->discount_type;
            $date_var               = explode(" - ", $request->date_range);
            $coupon->start_date     = strtotime($date_var[0]);
            $coupon->end_date       = strtotime($date_var[1]);
            $coupon->limit = $request->limit;
            $data                   = array();
            $data['min_buy']        = $request->min_buy;
            $data['max_discount']   = $request->max_discount;
            $coupon->details        = json_encode($data);
            if ($coupon->save()) {
                flash(translate('Coupon has been saved successfully'))->success();
                return redirect()->route('coupon.index');
            } else {
                flash(translate('Something went wrong'))->danger();
                return back();
            }
        } elseif ($request->coupon_type == "gift_base") {
            $coupon->type             = $request->coupon_type;
            $date_var                 = explode(" - ", $request->date_range);
            $coupon->start_date       = strtotime($date_var[0]);
            $coupon->end_date         = strtotime($date_var[1]);
            $coupon->limit = $request->limit;
            $data                     = array();
            $data['min_buy']          = $request->min_buy;
            $coupon->details          = json_encode($data);
            $coupon->gift_type    = $request->discount_way;
            $coupon->discount_title    = $request->discount_title;
            $coupon->product_ids = json_encode($request->product_ids);
            $gifts = array();
            if ($request->discount_way == 'discount') {
                $coupon->discount         = $request->discount;
                $coupon->discount_type    = $request->discount_type;
                $coupon->gifts = json_encode($gifts);
            } else {
                $coupon->discount         = '';
                $coupon->discount_type    = '';
                $count = $request->total_gifts;
                if ($count >= 1) {
                    for ($i = 1; $i <= $count; $i++) {
                        $gift_name_data = $request->input('gift_name_' . $i);
                        $gift_attach_id = $request->input('attachment_id_' . $i);
                        if ($gift_name_data != '' && $gift_attach_id != '') {
                            $gifts[$gift_attach_id] = $gift_name_data;
                        }
                    }
                    $coupon->gifts = json_encode($gifts);
                }
            }
            if ($coupon->save()) {
                flash(translate('Coupon has been saved successfully'))->success();
                return redirect()->route('coupon.index');
            } else {
                flash(translate('Something went wrong'))->danger();
                return back();
            }
        } elseif ($request->coupon_type == "warranty_reward") {
            $coupon->type           = $request->coupon_type;
            $coupon->code           = $request->coupon_code;
            $coupon->discount       = $request->discount;
            $coupon->discount_type  = $request->discount_type;
            $date_var               = explode(" - ", $request->date_range);
            $coupon->start_date     = strtotime($date_var[0]);
            $coupon->end_date       = strtotime($date_var[1]);
            $coupon->limit = $request->limit;
            $data                   = array();
            $data['min_buy']        = $request->min_buy;
            $coupon->details        = json_encode($data);
            if ($coupon->save()) {
                flash(translate('Coupon has been saved successfully'))->success();
                return redirect()->route('coupon.index');
            } else {
                flash(translate('Something went wrong'))->danger();
                return back();
            }
        }
    }

    public function destroy($id)
    {
        Coupon::findOrFail($id);
        if (Coupon::destroy($id)) {
            DB::table('coupon_usages')->where('coupon_id', $id)->delete();
            flash(translate('Coupon has been deleted successfully'))->success();
            return redirect()->route('coupon.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function get_coupon_form(Request $request)
    {
        if ($request->coupon_type == "product_base") {
            return view('backend.marketing.coupons.product_base_coupon');
        } elseif ($request->coupon_type == "cart_base") {
            return view('backend.marketing.coupons.cart_base_coupon');
        } elseif ($request->coupon_type == "gift_base") {
            return view('backend.marketing.coupons.gift_base_coupon');
        } elseif ($request->coupon_type == "warranty_reward") {
            return view('backend.marketing.coupons.warranty_reward');
        }
    }

    public function get_coupon_form_edit(Request $request)
    {
        if ($request->coupon_type == "product_base") {
            $coupon = Coupon::findOrFail($request->id);
            return view('backend.marketing.coupons.product_base_coupon_edit', compact('coupon'));
        } elseif ($request->coupon_type == "cart_base") {
            $coupon = Coupon::findOrFail($request->id);
            return view('backend.marketing.coupons.cart_base_coupon_edit', compact('coupon'));
        } elseif ($request->coupon_type == "gift_base") {
            $coupon = Coupon::findOrFail($request->id);
            return view('backend.marketing.coupons.gift_base_coupon_edit', compact('coupon'));
        } elseif ($request->coupon_type == "warranty_reward") {
            $coupon = Coupon::findOrFail($request->id);
            return view('backend.marketing.coupons.warranty_reward_edit', compact('coupon'));
        }
    }

    public function emergency_coupons()
    {
        $coupons = Coupon::orderBy('id', 'desc')->where('user_id', Auth::id())->where('type', 'emergency_coupon')->get();
        return view('backend.marketing.emergency_coupons.index', compact('coupons'));
    }

    public function emergency_coupon_create()
    {
        return view('backend.marketing.emergency_coupons.create');
    }

    public function emergency_coupon_store(Request $request)
    {
        if (Coupon::where('code', '!=', null)->where('code', $request->coupon_code)->first()) {
            flash(translate('Coupon already exist for this coupon code'))->error();
            return back();
        }
        $coupon = new Coupon;
        $coupon->user_id = Auth::id();
        $coupon->type             = 'emergency_coupon';
        $coupon->code             = $request->coupon_code;
        $coupon->discount         = $request->discount;
        $coupon->discount_type    = $request->discount_type;
        $date_var                 = explode(" - ", $request->date_range);
        $coupon->start_date       = strtotime($date_var[0]);
        $coupon->end_date         = strtotime($date_var[1]);
        $coupon->limit = $request->limit;
        if ($coupon->save()) {
            flash(translate('Coupon has been saved successfully'))->success();
            return redirect()->route('emergency_coupon.index');
        } else {
            flash(translate('Something went wrong'))->danger();
            return back();
        }
    }

    public function emergency_coupon_edit($id)
    {
        $coupon = Coupon::findOrFail(decrypt($id));
        return view('backend.marketing.emergency_coupons.edit', compact('coupon'));
    }

    public function emergency_coupon_update(Request $request, $id)
    {
        if (Coupon::where('code', '!=', null)->where('id', '!=', $id)->where('code', $request->coupon_code)->first()) {
            flash(translate('Coupon already exist for this coupon code'))->error();
            return back();
        }

        $coupon = Coupon::findOrFail($id);
        $coupon->code = $request->coupon_code;
        $coupon->discount = $request->discount;
        $date_var                 = explode(" - ", $request->date_range);
        $coupon->start_date       = strtotime($date_var[0]);
        $coupon->end_date         = strtotime($date_var[1]);
        $coupon->limit = $request->limit;
        if ($coupon->update()) {
            flash(translate('Coupon has been saved successfully'))->success();
            return redirect()->route('emergency_coupon.index');
        } else {
            flash(translate('Something went wrong'))->danger();
            return back();
        }
    }

    public function emergency_coupon_destroy($id)
    {
        Coupon::findOrFail($id);
        if (Coupon::destroy($id)) {
            DB::table('coupon_usages')->where('coupon_id', $id)->delete();
            flash(translate('Coupon has been deleted successfully'))->success();
            return redirect()->route('emergency_coupon.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }
}
