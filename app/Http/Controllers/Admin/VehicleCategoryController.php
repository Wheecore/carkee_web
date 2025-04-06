<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleCategoryController extends Controller
{
    public function categories(Request $request)
    {
        $sort_search = null;
        $cats = VehicleCategory::orderBy('name', 'asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $cats = $cats->where('name', 'like', '%' . $sort_search . '%');
        }
        $datas = $cats->paginate(15);
        return view('backend.vehicle_category.category.index', compact('datas', 'sort_search'));
    }

    public function categoryStore(Request $request)
    {
        $category = new VehicleCategory;
        $category->name = $request->name;
        $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $category->save();

        flash(translate('Data has been inserted successfully'))->success();
        return redirect()->route('vehicle.categories');
    }

    public function categoryEdit(Request $request, $id)
    {
        $lang   = $request->lang;
        $data  = VehicleCategory::findOrFail($id);
        return view('backend.vehicle_category.category.edit', compact('lang', 'data'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = VehicleCategory::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $category->name = $request->name;
        }
        $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $category->save();

        flash(translate('Data has been updated successfully'))->success();
        return back();
    }

    public function categoryDestroy($id)
    {
        VehicleCategory::findOrFail($id)->delete();
        flash(translate('Data has been deleted successfully'))->success();
        return redirect()->back();
    }
}
