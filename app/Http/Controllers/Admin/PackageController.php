<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarDetail;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\CarYear;
use App\Models\Package;
use App\Models\PackageProduct;
use App\Models\PackageTranslation;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        Session::forget('s_pack_id');
        $sort_search = null;
        $packages = Package::orderBy('name', 'asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $packages = $packages->where('name', 'like', '%' . $sort_search . '%');
        }
        $packages = $packages->paginate(15);
        return view('backend.services.packages.index', compact('packages', 'sort_search'));
    }

    public function create()
    {
        return view('backend.services.packages.create');
    }

    public function store(Request $request)
    {
        $package = new Package();
        $package->brand_id = json_encode($request->brand_id);
        $package->model_id = json_encode($request->model_id);
        $package->details_id = json_encode($request->details_id);
        $package->year_id = json_encode($request->year_id);
        $package->type_id = json_encode($request->type_id);
        $package->name = $request->name;
        $package->mileage = $request->mileage;
        $package->type = $request->package_type;
        $package->expiry_month = $request->expiry_month;
        $package->logo = $request->logo;
        $package->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $package->save();

        $package_translation = PackageTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'package_id' => $package->id]);
        $package_translation->name = $request->name;
        $package_translation->save();

        flash(translate('Package has been created successfully'))->success();
        return redirect(route('packages.index'));
    }

    public function edit(Request $request, $id)
    {
        $lang   = $request->lang;
        $package  = Package::findOrFail($id);
        $ibrands = Brand::whereIn('id', $package->brand_id != 'null' ? json_decode($package->brand_id) : ['0'])->get();
        $nbrands = Brand::whereNotIn('id', $package->brand_id != 'null' ? json_decode($package->brand_id) : ['0'])->get();
        $models = CarModel::whereIn('id', $package->model_id != 'null' ? json_decode($package->model_id) : ['0'])->get();
        $years = CarDetail::whereIn('id', $package->details_id != 'null' ? json_decode($package->details_id) : ['0'])->get();
        $details = CarYear::whereIn('id', $package->year_id != 'null' ? json_decode($package->year_id) : ['0'])->get();
        $types = CarType::whereIn('id', $package->type_id != 'null' ? json_decode($package->type_id) : ['0'])->get();

        return view('backend.services.packages.edit', compact('package', 'lang', 'ibrands', 'nbrands', 'models', 'years', 'details', 'types'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $package->brand_id = json_encode($request->brand_id);
        $package->model_id = json_encode($request->model_id);
        $package->details_id = json_encode($request->details_id);
        $package->year_id = json_encode($request->year_id);
        $package->type_id = json_encode($request->type_id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $package->name = $request->name;
        }
        $package->mileage = $request->mileage;
        $package->type = $request->package_type;
        $package->expiry_month = $request->expiry_month;
        $package->logo = $request->logo;
        $package->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $package->save();

        $package_translation = PackageTranslation::firstOrNew(['lang' => $request->lang, 'package_id' => $package->id]);
        $package_translation->name = $request->name;
        $package_translation->save();

        flash(translate('Package has been updated successfully'))->success();
        return redirect(route('packages.index'));
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        if ($package->delete()) {
        DB::table('package_products')->where('package_id', $id)->delete();
        DB::table('carts')->where('package_id', $id)->delete();
        DB::table('cart_package_products')->where('package_id', $id)->delete();
        flash(translate('Package has been deleted successfully'))->success();
        return redirect(route('packages.index'));
        }
        else{
        flash(translate('Something went wrong'))->error();
        return redirect(route('packages.index'));
        }
    }

    public function packageProductsAddOrUpdate(Request $request)
    {
        $package_products = PackageProduct::where('package_id', $request->package_id)->where('type', $request->type)->first();
        $products_with_qty = [];
        if($request->product_id){
        foreach ($request->product_id as $product_id) {
            $products_with_qty[$product_id] = $request->input('qty_' . $product_id);
        }
        }

        if ($package_products) {
            $package_products->products = json_encode($products_with_qty);
            $package_products->update();
        } else {
            $package_products = new PackageProduct();
            $package_products->package_id = $request->package_id;
            $package_products->products = json_encode($products_with_qty);
            $package_products->type = $request->type;
            $package_products->save();
        }
        flash(translate('Products saved successfully'))->success();
        return back();
    }

    public function rocommendEdit(Request $request, $id)
    {
        $r_products = PackageProduct::where('package_id', $id)->where('type', 'Recommended')->select('products')->first();
        $products_data = ($r_products && $r_products->products != 'null') ? (array) json_decode($r_products->products) : [];
        $sort_search = null;
        $products = Product::where('category_id', 4)->where('qty', '>', 0);
        if ($request->search != null) {
            $products = $products
                ->where('products.name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        $products = $products->select('products.id', 'products.name', 'products.thumbnail_img', 'products.min_qty', 'ps.qty')->paginate(20);
        return view('backend.services.packages.products.recommend_edit', compact('products', 'sort_search', 'products_data', 'id'));
    }

    public function addonEdit(Request $request, $id)
    {
        $a_products = PackageProduct::where('package_id', $id)->where('type', 'Addon')->select('products')->first();
        $products_data = ($a_products && $a_products->products != 'null') ? (array) json_decode($a_products->products) : [];
        $sort_search = null;
        $products = Product::where('category_id', 4)->where('qty', '>', 0);
        if ($request->search != null) {
            $products = $products
                ->where('products.name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        $products = $products->select('products.id', 'products.name', 'products.thumbnail_img', 'products.min_qty', 'ps.qty')->paginate(20);
        return view('backend.services.packages.products.addon_edit', compact('products', 'sort_search', 'products_data', 'id'));
    }
}
