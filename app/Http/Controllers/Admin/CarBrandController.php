<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarBrandController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $brands = Brand::orderBy('name', 'asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $brands = $brands->where('name', 'like', '%' . $sort_search . '%');
        }
        $brands = $brands->paginate(15);
        return view('backend.product.brands.index', compact('brands', 'sort_search'));
    }

    public function store(Request $request)
    {
        $brand = new Brand;
        $brand->name = strtoupper($request->name);
        $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $brand->save();

        $brand_translation = BrandTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'brand_id' => $brand->id]);
        $brand_translation->name = strtoupper($request->name);
        $brand_translation->save();

        flash(translate('Brand has been inserted successfully'))->success();
        return redirect()->route('brands.index');
    }

    public function edit(Request $request, $id)
    {
        $lang   = $request->lang;
        $brand  = Brand::findOrFail($id);
        return view('backend.product.brands.edit', compact('brand', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $brand->name = strtoupper($request->name);
        }
        $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $brand->save();

        $brand_translation = BrandTranslation::firstOrNew(['lang' => $request->lang, 'brand_id' => $brand->id]);
        $brand_translation->name = strtoupper($request->name);
        $brand_translation->save();

        flash(translate('Brand has been updated successfully'))->success();
        return back();
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        Product::where('brand_id', $brand->id)->delete();
        foreach ($brand->brand_translations as $brand_translation) {
            $brand_translation->delete();
        }
        DB::table('car_models')->where('brand_id', $id)->delete();
        DB::table('car_years')->where('brand_id', $id)->delete();
        DB::table('car_variants')->where('brand_id', $id)->delete();
        Brand::destroy($id);

        flash(translate('Brand has been deleted successfully'))->success();
        return redirect()->route('brands.index');
    }
    
}
