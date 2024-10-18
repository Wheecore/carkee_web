<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Battery;
use App\Models\BrandData;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandsDataController extends Controller
{
    public function brands(Request $request, $brand_type)
    {
        $sort_search = null;
        $brands = BrandData::where('type',$brand_type)->orderBy('id', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $brands = $brands->where('name', 'like', '%' . $sort_search . '%');
        }
        $brands = $brands->paginate(15);
        return view('backend.brands_data.index', compact('brands','brand_type','sort_search'));
    }

    public function brands_store(Request $request)
    {
        $brand = new BrandData;
        $brand->name = $request->name;
        $brand->type = $request->brand_type;
        $brand->photo = $request->logo;
        $brand->save();

        flash(translate('Brand has been inserted successfully'))->success();
        return redirect()->back();
    }

    public function brands_edit($id)
    {
        $brand  = BrandData::findOrFail($id);
        return view('backend.brands_data.edit', compact('brand'));
    }

    public function brands_update(Request $request, $id)
    {
        $brand = BrandData::findOrFail($id);
        $brand->name = $request->name;
        if($request->logo){
         $logo = $request->logo;
        }
        else{
          $logo = $brand->photo;
        }
        $brand->photo = $logo;
        $brand->save();

        flash(translate('Brand has been updated successfully'))->success();
        return redirect()->route('brands.data', $brand->type);
    }

    public function brand_destroy($id)
    {
        $brand = BrandData::findOrFail($id);
        if($brand->type == 'battery_brands'){
            Battery::where('battery_brand_id', $brand->id)->delete();
        }
        else{
            Product::where('tyre_service_brand_id', $brand->id)->delete();
        }
        BrandData::destroy($id);

        flash(translate('Brand has been deleted successfully'))->success();
        return back();
    }

}
