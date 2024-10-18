<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CarList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarListController extends Controller
{
    public function index()
    {
        return redirect('dashboard');
        if (Auth::check()) {
            $lists = CarList::all();
            return view('frontend.carlist.index', compact('lists'));
        }
        return view('auth.login');
    }

    public function orders(Request $request, $id)
    {
        $cart_list = CarList::find($id);
        $existing_car_lists = [];
        return view('frontend.carlist.details', compact('existing_car_lists'));
    }

    public function create()
    {
        return view('frontend.carlist.create');
    }

    public function edit($id)
    {
        $carlist = CarList::find($id);
        return view('frontend.carlist.edit', compact('carlist'));
    }

    public function update(Request $request, $id)
    {
        $carlist = CarList::find($id);
        $request->validate([
            'car_plate' => 'required|unique:car_lists,car_plate,' . $carlist->id
        ]);

        $carlist->update([
            'car_plate' => $request->car_plate,
            'mileage' => ($request->mileage) ? $request->mileage . 'KM' : '',
            'chassis_number' => $request->chassis_number,
            'vehicle_size' => $request->vehicle_size,
            'insurance' => $request->insurance
        ]);
        return redirect('dashboard');
    }

    public function destroy(Request $request, $id)
    {
        CarList::find($id)->delete();
        return redirect()->back();
    }
}
