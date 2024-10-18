<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function feedbacks(Request $request)
    {
        $reviews = DB::table('rating_orders as ro')
        ->where('ro.seller_id', Auth::user()->id)
        ->leftJoin('users','users.id','ro.user_id')
        ->leftJoin('orders as o','o.id','ro.order_id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $reviews->where('ro.score', 'like', '%' . $sort_search . '%');
        }
        $reviews = $reviews->select('users.name','o.car_plate','o.model_name','o.code','ro.description','ro.score','ro.id')->paginate(20);
        return view('frontend.user.seller.feedbacks', compact('reviews'));
    }

}
