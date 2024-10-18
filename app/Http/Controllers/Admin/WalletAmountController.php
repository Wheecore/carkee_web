<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletAmount;
use Illuminate\Http\Request;

class WalletAmountController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $payments = WalletAmount::orderBy('created_at', 'desc');
        if ($request->search != null) {
            $payments = $payments->where('amount', 'like', '%' . $request->search . '%')->orWhere('free_amount', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        $payments = $payments->paginate(15);

        return view('backend.payments.wallet_amount', compact('payments', 'sort_search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'unique:wallet_amounts',
            'free_amount' => 'required'
        ]);

        $amount = new WalletAmount;
        $amount->amount = $request->amount;
        $amount->free_amount = $request->free_amount;
        $amount->save();

        flash(translate('Amount has been inserted successfully'))->success();
        return back();
    }

    public function update(Request $request, $id)
    {
        $amount = WalletAmount::find($id);
        $request->validate([
            'amount' => 'unique:wallet_amounts,amount,' . $amount->id,
            'free_amount' => 'required'
        ]);

        $amount->amount = $request->amount;
        $amount->free_amount = $request->free_amount;
        $amount->update();

        flash(translate('Amount has been updated successfully'))->success();
        return back();
    }

    public function show($id)
    {
        if (WalletAmount::destroy($id)) {
            flash(translate('Amount has been deleted successfully'))->success();
            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }
}
