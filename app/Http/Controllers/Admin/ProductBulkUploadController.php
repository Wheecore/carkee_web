<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BrandData;
use App\Models\TyreProductsImport;
use App\Models\ServiceProductsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ProductBulkUploadController extends Controller
{
    public function index($type)
    {
        return view('backend.product.bulk_upload.index', compact('type'));
    }

    public function pdf_download_category()
    {
        $categories = Category::select('id','name')->get();
        return Pdf::loadView('backend.downloads.category', [
            'categories' => $categories,
        ], [], [])->download('category.pdf');
    }

    public function pdf_download_tyre_brand()
    {
        $brands = BrandData::select('id','name')->where('type','tyre_brands')->get();
        return PDF::loadView('backend.downloads.brand', [
            'brands' => $brands,
        ], [], [])->download('tyre_brands.pdf');
    }

    public function pdf_download_service_brand()
    {
        $brands = BrandData::select('id','name')->where('type','service_brands')->get();
        return PDF::loadView('backend.downloads.brand', [
            'brands' => $brands,
        ], [], [])->download('service_brands.pdf');
    }

    public function pdf_download_battery_brand()
    {
        $brands = BrandData::select('id','name')->where('type','battery_brands')->get();
        return PDF::loadView('backend.downloads.brand', [
            'brands' => $brands,
        ], [], [])->download('battery_brands.pdf');
    }

    public function pdf_download_service_subcategories()
    {
        $subcategories = DB::table('service_categories')
        ->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')
        ->select('sct.service_category_id as id', 'sct.name')
        ->where('service_categories.parent_id', null)
        ->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))
        ->get();

        return PDF::loadView('backend.downloads.subcategories', [
            'subcategories' => $subcategories,
        ], [], [])->download('sub_categories.pdf');
    }

    public function pdf_download_service_subchildcategories()
    {
        $childcategories = DB::table('service_categories')
        ->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')
        ->select('sct.service_category_id as id', 'sct.name', 'service_categories.parent_id')
        ->where('service_categories.parent_id','!=', null)
        ->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))
        ->get();

        return PDF::loadView('backend.downloads.subchildcategories', [
            'childcategories' => $childcategories,
        ], [], [])->download('child_categories.pdf');
    }

    public function pdf_download_battery_subcategories()
    {
        $subcategories = DB::table('battery_sub_categories')
        ->join('battery_sub_category_translations as bct', 'bct.battery_sub_category_id', '=', 'battery_sub_categories.id')
        ->select('bct.battery_sub_category_id as id', 'bct.name')
        ->where('battery_sub_categories.parent_id', null)
        ->where('bct.lang', env('DEFAULT_LANGUAGE', 'en'))
        ->get();

        return PDF::loadView('backend.downloads.subcategories', [
            'subcategories' => $subcategories,
        ], [], [])->download('sub_categories.pdf');
    }

    public function pdf_download_battery_childcategories()
    {
        $childcategories = DB::table('battery_sub_categories')
        ->join('battery_sub_category_translations as bct', 'bct.battery_sub_category_id', '=', 'battery_sub_categories.id')
        ->select('bct.battery_sub_category_id as id', 'bct.name', 'battery_sub_categories.parent_id')
        ->where('battery_sub_categories.parent_id','!=', null)
        ->where('bct.lang', env('DEFAULT_LANGUAGE', 'en'))
        ->get();

        return PDF::loadView('backend.downloads.subchildcategories', [
            'childcategories' => $childcategories,
        ], [], [])->download('child_categories.pdf');
    }

    public function bulk_upload(Request $request, $type)
    {
        if($type == 'tyre'){
            if ($request->hasFile('bulk_file')) {
                Excel::import(new TyreProductsImport, request()->file('bulk_file'));
            }
            return back();
        }
        else{
            if ($request->hasFile('bulk_file')) {
                Excel::import(new ServiceProductsImport, request()->file('bulk_file'));
            }
            return back();
        }
    }
}