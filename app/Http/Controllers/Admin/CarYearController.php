<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarList;
use App\Models\CarModel;
use App\Models\CarYear;
use App\Models\CarYearTranslation;
use App\Models\SizeAlternative;
use App\Models\VehicleSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarYearController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name','asc')->select('id', 'name')->get();
        $sort_search = null;
        $years = CarYear::orderBy('car_years.name', 'asc')
        ->leftJoin('brands', 'brands.id', 'car_years.brand_id')
        ->leftJoin('car_models', 'car_models.id', 'car_years.model_id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $years = $years->where(function ($query) use ($sort_search) {
                $query->where('car_years.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('brands.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_models.name', 'like', '%' . $sort_search . '%');
            });
        }
        $years = $years->select('brands.name as brand_name', 'car_models.name as model_name','car_years.id','car_years.name')->paginate(15);
        return view('backend.product.years.index', compact('brands', 'years', 'sort_search'));
    }

    public function store(Request $request)
    {
        $year = new CarYear();
        $year->model_id = $request->model_id;
        $year->brand_id = $request->brand_id;
        $year->name = strtoupper($request->name);
        $year->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $year->save();

        $year_translation = CarYearTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'car_year_id' => $year->id]);
        $year_translation->name = strtoupper($request->name);
        $year_translation->save();

        flash(translate('Car year has been inserted successfully'))->success();
        return redirect()->route('years.index');
    }

    public function edit(Request $request, $id)
    {
        $brands = Brand::orderBy('name','asc')->select('id', 'name')->get();
        $models = CarModel::orderBy('name','asc')->select('id', 'name')->get();
        $lang   = $request->lang;
        $year  = CarYear::findOrFail($id);
        return view('backend.product.years.edit', compact('brands', 'models', 'year', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $year = CarYear::findOrFail($id);
        $year->brand_id = $request->brand_id;
        $year->model_id = $request->model_id;
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $year->name = strtoupper($request->name);
        }
        $year->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $year->save();

        $year_translation = CarYearTranslation::firstOrNew(['lang' => $request->lang, 'car_year_id' => $year->id]);
        $year_translation->name = strtoupper($request->name);
        $year_translation->save();

        flash(translate('Car year has been updated successfully'))->success();
        return back();
    }

    public function destroy($id)
    {
        $year = CarYear::findOrFail($id);
        foreach ($year->car_year_translations as $year_translation) {
            $year_translation->delete();
        }
        DB::table('car_variants')->where('year_id', $id)->delete();
        CarYear::destroy($id);

        flash(translate('Car year has been deleted successfully'))->success();
        return redirect()->route('years.index');
    }
    public function ajax(Request $request)
    {
        $years = CarYear::where('model_id', $request->id)->orderBy('name', 'asc')->get();
        return view('backend.product.years.ajax', compact('years'));
    }
    public function vehicle_size(Request $request)
    {
        $vehicle_sizes = VehicleSize::where('model_id', $request->id)->orderBy('name', 'asc')->get();
        return view('backend.product.years.vehicle_size', compact('vehicle_sizes'));
    }
    public function alternative_size(Request $request)
    {
        $a_sizes = SizeAlternative::where('model_id', $request->id)->orderBy('name', 'asc')->get();
        return view('backend.product.years.alternative_size', compact('a_sizes'));
    }
    public function ajaxSaveUserDetails(Request $request)
    {
        $lists = CarList::where('model_id', $request->id)->get();
        return view('backend.product.years.user_ajax_details', compact('lists'));
    }
}
