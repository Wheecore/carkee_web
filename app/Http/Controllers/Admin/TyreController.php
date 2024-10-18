<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tyre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TyreController extends Controller
{
    public function index()
    {
        $data['tyre'] = Tyre::first();
        return view('backend.product.tyres.index', $data);
    }

    public function saveOrUpdateTyre(Request $request)
    {
        $tyre = Tyre::first();
        if ($tyre) {
            $tyre->name = $request->name;
            $tyre->amount = $request->amount;
            $tyre->update();
            flash(translate('Data has been updated successfully'))->success();
        } else {
            $tyre = new Tyre();
            $tyre->user_id = Auth::id();
            $tyre->name = $request->name;
            $tyre->amount = $request->amount;
            $tyre->save();
            flash(translate('Data has been saved successfully'))->success();
        }
        return redirect()->back();
    }
}
