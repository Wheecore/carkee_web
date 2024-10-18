<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\VehicleSize;
use Illuminate\Http\Request;

class VehicleSizeController extends Controller
{
    public function index(Request $request)
    {
        $models = CarModel::all();
        $sort_search = null;
        $datas = VehicleSize::orderBy('name', 'asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $datas = $datas->where('name', 'like', '%' . $sort_search . '%');
        }
        $datas = $datas->paginate(15);
        return view('backend.vehicle_size.index', compact('models', 'datas', 'sort_search'));
    }

    public function store(Request $request)
    {
        $data = new VehicleSize();
        $data->model_id = $request->model_id;
        $data->name = $request->name;
        $data->save();

        flash(translate('Date been inserted successfully'))->success();
        return redirect()->route('vehicle_size.index');
    }

    public function show($id)
    {
        VehicleSize::where('id', $id)->delete();
        flash(translate('data been deleted successfully'))->success();
        return redirect()->back();
    }

    public function edit($id)
    {
        $models = CarModel::all();
        $data = VehicleSize::where('id', $id)->first();
        return view('backend.vehicle_size.edit', compact('models', 'data'));
    }

    public function update(Request $request, $id)
    {
        $data = VehicleSize::findOrFail($id);
        $data->model_id = $request->model_id;
        $data->name = $request->name;
        $data->save();
        flash(translate('data been updated successfully'))->success();
        return redirect()->route('vehicle_size.index');
    }
}
