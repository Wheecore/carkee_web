<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class petrolController extends Controller
{
    public function index()
    {
        $data['petrol'] = Petrol::first();
        return view('backend.product.petrols.index', $data);
    }

    public function saveOrUpdatePetrol(Request $request)
    {
        $petrol = Petrol::first();
        if ($petrol) {
            $petrol->name = $request->name;
            $petrol->amount = $request->amount;
            $petrol->update();
            flash(translate('Data has been updated successfully'))->success();
        } else {
            $petrol = new petrol();
            $petrol->user_id = Auth::id();
            $petrol->name = $request->name;
            $petrol->amount = $request->amount;
            $petrol->save();
            flash(translate('Data has been saved successfully'))->success();
        }
        return redirect()->back();
    }
}
