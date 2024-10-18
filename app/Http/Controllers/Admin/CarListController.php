<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CarList;

class CarListController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_plate' => 'required|unique:car_lists'
        ]);
            CarList::create([
                'user_id' => Auth::id(),
                'brand_id' => $request->brand_id,
                'car_plate' => $request->car_plate,
                'mileage' => ($request->mileage) ? $request->mileage . 'KM' : '',
                'chassis_number' => $request->chassis_number,
                'vehicle_size' => $request->vehicle_size,
                'insurance' => $request->insurance,
                'model_id' => $request->model_id,
                'details_id' => $request->details_id,
                'year_id' => $request->year_id,
                'type_id' => $request->type_id,
                'size_alternative_id' => $request->size_alternative_id,
            ]);

        flash(translate('Added successfully'))->success();
        return redirect('dashboard');
    }

    public function storeFrontSide(Request $request)
    {
            CarList::create([
                'user_id' => Auth::id(),
                'brand_id' => $request->brand_id,
                'model_id' => $request->model_id,
                'details_id' => $request->details_id,
                'year_id' => $request->year_id,
                'type_id' => $request->type_id,
                'size_alternative_id' => $request->size_alternative_id,
            ]);
        flash(translate('Added successfully'))->success();
        return back();
    }
    
}
