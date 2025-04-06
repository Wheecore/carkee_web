<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\CarYear;
use App\Models\CarVariant;
use App\Models\CarVariantTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarVariantController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name','asc')->select('id', 'name')->get();
        $sort_search = null;
        $variants = CarVariant::orderBy('brands.name', 'asc')->orderBy('car_models.name', 'asc')->orderBy('car_variants.name', 'asc')
        ->leftJoin('brands', 'brands.id', 'car_variants.brand_id')
        ->leftJoin('car_models', 'car_models.id', 'car_variants.model_id')
        ->leftJoin('car_years', 'car_years.id', 'car_variants.year_id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $variants = $variants->where(function ($query) use ($sort_search) {
                $query->where('car_variants.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('brands.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_models.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('car_years.name', 'like', '%' . $sort_search . '%');
            });
        }
        $variants = $variants->select('brands.name as brand_name', 'car_models.name as model_name', 'car_years.name as year_name',
        'car_variants.id', 'car_variants.name')->paginate(15);
        return view('backend.product.variants.index', compact('brands', 'variants', 'sort_search'));
    }

    public function store(Request $request)
    {
        $variant = new CarVariant();
        $variant->model_id = $request->model_id;
        $variant->brand_id = $request->brand_id;
        $variant->year_id = $request->year_id;
        $variant->name = strtoupper($request->name);
        $variant->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $variant->save();

        $variant_translation = CarVariantTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'car_variant_id' => $variant->id]);
        $variant_translation->name = strtoupper($request->name);
        $variant_translation->save();

        flash(translate('Car variant has been inserted successfully'))->success();
        return redirect()->route('variants.index');
    }

    public function edit(Request $request, $id)
    {
        $brands = Brand::orderBy('name','asc')->select('id', 'name')->get();
        $models = CarModel::orderBy('name','asc')->select('id', 'name')->get();
        $years = CarYear::orderBy('name','asc')->select('id', 'name')->get();
        $lang   = $request->lang;
        $variant  = CarVariant::findOrFail($id);
        return view('backend.product.variants.edit', compact('brands', 'models', 'years', 'variant', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $variant = CarVariant::findOrFail($id);
        $variant->brand_id = $request->brand_id;
        $variant->model_id = $request->model_id;
        $variant->year_id = $request->year_id;
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $variant->name = strtoupper($request->name);
        }
        $variant->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $variant->save();

        $variant_translation = CarVariantTranslation::firstOrNew(['lang' => $request->lang, 'car_variant_id' => $variant->id]);
        $variant_translation->name = strtoupper($request->name);
        $variant_translation->save();

        flash(translate('Car variant has been updated successfully'))->success();
        return back();
    }

    public function destroy($id)
    {
        $variant = CarVariant::findOrFail($id);
        foreach ($variant->car_variant_translations as $variant_translation) {
            $variant_translation->delete();
        }
        CarVariant::destroy($id);

        flash(translate('Car variant has been deleted successfully'))->success();
        return redirect()->route('variants.index');
    }

}
