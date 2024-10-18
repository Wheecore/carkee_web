<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Battery;
use App\Models\BatteryProductsExport;
use App\Models\BatteryProductsImport;
use App\Models\BrandData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BatteryController extends Controller
{
    public function all_batteries(Request $request)
    {
        $sort_search = null;
        $batteries = Battery::where('service_type', 'N')->where('user_id', Auth::id())->orderBy('created_at', 'desc');
        if ($request->search != null) {
            $batteries = $batteries
                ->where('name', 'like', '%' . $request->search . '%')->orWhere('model', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        $batteries = $batteries->paginate(15);
        return view('backend.product.batteries.index', compact('batteries', 'sort_search'));
    }

    public function create()
    {
        $data['battery_brands'] = BrandData::where('type', 'battery_brands')->get();
        $data['subcategories'] = DB::table('battery_sub_categories')->join('battery_sub_category_translations as sct', 'sct.battery_sub_category_id', '=', 'battery_sub_categories.id')->select('sct.battery_sub_category_id as id', 'sct.name')->where('battery_sub_categories.parent_id', null)->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))->get()->toArray();
        return view('backend.product.batteries.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'unique:batteries'
        ]);

        $battery = new Battery;
        $battery->user_id = Auth::user()->id;
        $battery->battery_brand_id = $request->battery_brand_id;
        $battery->attachment_id = $request->attachment_id ? $request->attachment_id : 0;
        $battery->sub_category_id = $request->sub_category_id;
        $battery->sub_child_category_id = $request->sub_child_category_id;
        $battery->service_type = 'N';
        $battery->name = $request->name;
        $battery->warranty = $request->warranty;
        $battery->model = $request->model;
        $battery->amount = $request->amount;
        $battery->discount = $request->discount;
        $battery->stock = $request->stock;
        $battery->capacity = $request->capacity;
        $battery->description = $request->description;
        $battery->cold_cranking_amperes = $request->cold_cranking_amperes;
        $battery->mileage_warranty = $request->mileage_warranty;
        $battery->reserve_capacity = $request->reserve_capacity;
        $battery->height = $request->height;
        $battery->length = $request->length;
        $battery->width = $request->width;
        $battery->start_stop_function = $request->start_stop_function;
        $battery->jis = $request->jis;
        $battery->absorbed_glass_mat = $request->absorbed_glass_mat;
        $battery->save();

        flash(translate('Battery has been inserted successfully'))->success();
        return redirect()->route('batteries.all');
    }

    public function edit($id)
    {
        $battery = Battery::findOrFail($id);
        $data['battery_brands'] = BrandData::where('type', 'battery_brands')->get();
        $data['battery'] = $battery;
        $data['subcategories'] = DB::table('battery_sub_categories')->join('battery_sub_category_translations as sct', 'sct.battery_sub_category_id', '=', 'battery_sub_categories.id')->select('sct.battery_sub_category_id as id', 'sct.name')->where('battery_sub_categories.parent_id', null)->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))->get()->toArray();

        return view('backend.product.batteries.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $battery = Battery::find($id);
        $request->validate([
            'name' => 'unique:batteries,name,'.$battery->id,
        ]);

        $battery->battery_brand_id = $request->battery_brand_id;
        $battery->attachment_id = $request->attachment_id ? $request->attachment_id : 0;
        $battery->sub_category_id = $request->sub_category_id;
        $battery->sub_child_category_id = $request->sub_child_category_id;
        $battery->service_type = 'N';
        $battery->name = $request->name;
        $battery->warranty = $request->warranty;
        $battery->model = $request->model;
        $battery->amount = $request->amount;
        $battery->discount = $request->discount;
        $battery->stock = $request->stock;
        $battery->capacity = $request->capacity;
        $battery->description = $request->description;
        $battery->cold_cranking_amperes = $request->cold_cranking_amperes;
        $battery->mileage_warranty = $request->mileage_warranty;
        $battery->reserve_capacity = $request->reserve_capacity;
        $battery->height = $request->height;
        $battery->length = $request->length;
        $battery->width = $request->width;
        $battery->start_stop_function = $request->start_stop_function;
        $battery->jis = $request->jis;
        $battery->absorbed_glass_mat = $request->absorbed_glass_mat;
        $battery->update();

        flash(translate('Battery has been updated successfully'))->success();
        return redirect()->route('batteries.all');
    }

    public function jumpstartView()
    {
        $data = Battery::where('service_type', 'J')->select('id', 'amount')->first();
        return view('backend.product.batteries.jumpstart', compact('data'));
    }

    public function saveOrUpdateJumpstart(Request $request)
    {
        $battery = Battery::where('service_type', 'J')->first();
        if ($battery) {
            $battery->amount = $request->amount;
            $battery->update();
            flash(translate('Data has been updated successfully'))->success();
        } else {
            $battery = new Battery();
            $battery->amount = $request->amount;
            $battery->service_type = "J";
            $battery->save();
            flash(translate('Data has been saved successfully'))->success();
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        if (Battery::destroy($id)) {
            DB::table('browse_histories')->where('product_type', 'battery')->where('product_id', $id)->delete();
            flash(translate('Product has been deleted successfully'))->success();
            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_battery_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $battery_id) {
                $this->destroy($battery_id);
            }
        }
        return 1;
    }

    public function duplicate(Request $request, $id)
    {
        $battery = Battery::find($id);
        $battery_new = $battery->replicate();
        $battery_new->name = $battery->name.' - 1';
        if ($battery_new->save()) {
            flash(translate('Battery has been duplicated successfully'))->success();
            return redirect()->route('batteries.all');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function export()
    {
        return Excel::download(new BatteryProductsExport, 'battery_products.xlsx');
    }

    public function importIndex()
    {
        return view('backend.product.bulk_upload.battery_index');
    }

    public function bulk_upload(Request $request)
    {
        if ($request->hasFile('bulk_file')) {
            Excel::import(new BatteryProductsImport, request()->file('bulk_file'));
        }
        return back();
    }
}
