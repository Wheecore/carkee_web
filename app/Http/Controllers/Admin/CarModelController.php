<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarList;
use App\Models\CarModel;
use App\Models\CarModelTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class CarModelController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name','asc')->select('id', 'name')->get();
        $sort_search = null;
        $models = CarModel::orderBy('brands.name', 'asc')->orderBy('car_models.name', 'asc')
        ->leftJoin('brands', 'brands.id', 'car_models.brand_id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $models = $models->where(function ($query) use ($sort_search) {
                $query->where('car_models.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_models.type', 'like', '%' . $sort_search . '%')
                    ->orWhere('brands.name', 'like', '%' . $sort_search . '%');
            });
        }
        $models = $models->select('brands.name as brand_name','car_models.id', 'car_models.type', 'car_models.name')->paginate(15);
        return view('backend.product.models.index', compact('brands', 'models', 'sort_search'));
    }

    public function store(Request $request)
    {
        $model = new CarModel();
        $model->brand_id = $request->brand_id;
        $model->name = strtoupper($request->name);
        $model->type = $request->type;
        $model->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $model->save();

        $model_translation = CarModelTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'car_model_id' => $model->id]);
        $model_translation->name = strtoupper($request->name);
        $model_translation->save();

        flash(translate('Model has been inserted successfully'))->success();
        return redirect()->route('models.index');
    }

    public function edit(Request $request, $id)
    {
        $brands = Brand::orderBy('name','asc')->select('id', 'name')->get();
        $lang   = $request->lang;
        $model  = CarModel::findOrFail($id);
        return view('backend.product.models.edit', compact('brands', 'model', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $model = CarModel::findOrFail($id);
        $model->brand_id = $request->brand_id;
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $model->name = strtoupper($request->name);
        }
        $model->type = $request->type;
        $model->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $model->save();

        $model_translation = CarModelTranslation::firstOrNew(['lang' => $request->lang, 'car_model_id' => $model->id]);
        $model_translation->name = strtoupper($request->name);
        $model_translation->save();

        flash(translate('Model has been updated successfully'))->success();
        return back();
    }

    public function destroy($id)
    {
        $model = CarModel::findOrFail($id);
        foreach ($model->car_modal_translations as $model_translation) {
            $model_translation->delete();
        }
        DB::table('car_years')->where('model_id', $id)->delete();
        DB::table('car_variants')->where('model_id', $id)->delete();
        CarModel::destroy($id);

        flash(translate('Model has been deleted successfully'))->success();
        return redirect()->route('models.index');
    }

    public function ajax(Request $request)
    {
        $models = CarModel::where('brand_id', $request->id)->orderBy('name', 'asc')->get();
        return view('backend.product.models.ajax_model', compact('models'));
    }
    public function ajaxSaveUserModels(Request $request)
    {
        $lists = CarList::where('brand_id', $request->id)->get();
        return view('backend.product.models.user_ajax_model', compact('lists'));
    }

}
