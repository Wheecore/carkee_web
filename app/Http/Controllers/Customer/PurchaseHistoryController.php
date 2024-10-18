<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->completed) {
            $orders = Order::where('user_id', Auth::user()->id)->where('delivery_status', 'Confirmed')->orderBy('id', 'desc')->paginate(100);
        } else if ($request->installation) {
            $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('start_installation_status', 1)->paginate(100);
        } else if ($request->completed && $request->installation) {
            $orders = Order::where('user_id', Auth::user()->id)->where('delivery_status', 'Confirmed')->orderBy('id', 'desc')->where('start_installation_status', 1)->paginate(100);
        } else if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = Order::where('user_id', Auth::user()->id)
                ->where(function ($query) use ($sort_search) {
                    $query->where('car_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model_name', 'like', '%' . $sort_search . '%')
                        ->orWhere('code', 'like', '%' . $sort_search . '%');
                })->orderBy('id', 'desc')->paginate(100);
        } else {
            $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        }

        return view('frontend.user.purchase_history', compact('orders'));
    }

    public function installation_history(Request $request)
    {
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('start_installation_status', 1)->where('car_plate', 'like', '%' . $sort_search . '%')->orWhere('model_name', 'like', '%' . $sort_search . '%')->orderBy('id', 'desc')->paginate(100);
        } else {
            $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('start_installation_status', 1)->paginate(100);
        }

        return view('frontend.user.installation_history', compact('orders'));
    }

    public function installation_history1(Request $request, $id)
    {
        DB::table('orders')->where('id', $id)->update([
            'notify_user_come_to_workshop_to_review_car' => 2
        ]);
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('start_installation_status', 1)->where('car_plate', 'like', '%' . $sort_search . '%')->orWhere('model_name', 'like', '%' . $sort_search . '%')->orderBy('id', 'desc')->paginate(100);
        } else {
            $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('start_installation_status', 1)->paginate(100);
        }

        return view('frontend.user.installation_history', compact('orders'));
    }

    public function purchase_history_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.user.order_details_customer', compact('order'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function ChangeDate($id)
    {
        $order = Order::where('id', $id)->first();
        $order->update([
        'user_date_update' => 1
        ]);
        return view('frontend.user.change_order_date', compact('order'));
    }
    
    public function updateDate($id, Request $request)
    {
        $order = Order::where('id', $id)->update([
            'workshop_date' => $request->wdate,
            'workshop_time' => $request->wtime,
            'availability_id' => $request->availability_id,
            'user_date_update' => 1
        ]);
        flash(translate('Updated Successfully'))->success();
        return back();
    }
}
