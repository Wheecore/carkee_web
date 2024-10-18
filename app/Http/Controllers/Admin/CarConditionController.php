<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CarConditionController extends Controller
{
    public function adminlist(Request $request)
    {
        $sort_search = null;
        $ccs = DB::table('user_car_conditions')->orderBy('id', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $ccs = $ccs
                ->where(function ($query) use ($sort_search) {
                    $query->where('number_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model', 'like', '%' . $sort_search . '%');
                });
        }
        $ccs = $ccs->paginate(15);
        return view('backend.customer.car_condition', compact('ccs','sort_search'));
    }

    public function details(Request $request, $id)
    {
        $sort_by_red = $request->sort_by_red;
        $condition = DB::table('user_car_conditions')->where('id', $id)->first();
        return view('backend.customer.car_condition_details', compact('condition', 'sort_by_red'));
    }
}
