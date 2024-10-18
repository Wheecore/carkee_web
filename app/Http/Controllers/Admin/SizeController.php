<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SizeCategory;
use App\Models\SizeCategoryTranslation;
use App\Models\SizeChildCategory;
use App\Models\SizeChildCategoryTranslation;
use App\Models\SizeSubCategory;
use App\Models\SizeSubCategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SizeController extends Controller
{
    public function categories(Request $request)
    {
        $sort_search = null;
        $cats = SizeCategory::orderBy('name');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $cats = $cats->where('name', 'like', '%' . $sort_search . '%');
        }
        $datas = $cats->paginate(15);
        return view('backend.size.category.index', compact('datas', 'sort_search'));
    }
    public function categoryStore(Request $request)
    {
        $size_category = new SizeCategory;
        $size_category->name = $request->name;
        $size_category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $size_category->save();

        $size_category_translation = SizeCategoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'size_category_id' => $size_category->id]);
        $size_category_translation->name = $request->name;
        $size_category_translation->save();

        flash(translate('Data has been inserted successfully'))->success();
        return redirect()->route('size.categories');
    }
    public function categoryEdit(Request $request, $id)
    {
        $lang   = $request->lang;
        $data  = SizeCategory::findOrFail($id);
        return view('backend.size.category.edit', compact('lang', 'data'));
    }
    public function categoryUpdate(Request $request, $id)
    {
        $size_category = SizeCategory::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $size_category->name = $request->name;
        }
        $size_category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $size_category->save();

        $size_category_translation = SizeCategoryTranslation::firstOrNew(['lang' => $request->lang, 'size_category_id' => $size_category->id]);
        $size_category_translation->name = $request->name;
        $size_category_translation->save();

        flash(translate('Data has been updated successfully'))->success();
        return back();
    }
    public function categoryDestroy($id)
    {
        $data = SizeCategory::findOrFail($id);
        foreach ($data->size_category_translations as $key => $data_translation) {
            $data_translation->delete();
        }
        DB::table('size_sub_categories')->where('size_category_id', $id)->delete();
        DB::table('size_child_categories')->where('size_category_id', $id)->delete();
        SizeCategory::destroy($id);
        flash(translate('Data has been deleted successfully'))->success();
        return redirect()->back();
    }

    ///subCategories
    public function subCategories(Request $request)
    {
        $sort_search = null;
        $cats = SizeCategory::all();
        $subcats = SizeSubCategory::orderBy('size_category_id','asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $subcats = $subcats->where('name', 'like', '%' . $sort_search . '%');
        }
        $datas = $subcats->paginate(15);
        return view('backend.size.sub_category.index', compact('cats', 'datas', 'sort_search'));
    }
    public function subCategoryStore(Request $request)
    {
        $size_sub_category = new SizeSubCategory;
        $size_sub_category->size_category_id = $request->cat_id;
        $size_sub_category->name = $request->name;
        $size_sub_category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $size_sub_category->save();

        $size_sub_category_translation = SizeSubCategoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'size_sub_category_id' => $size_sub_category->id]);
        $size_sub_category_translation->name = $request->name;
        $size_sub_category_translation->save();

        flash(translate('Data has been inserted successfully'))->success();
        return redirect()->route('size.sub.categories');
    }
    public function subCategoryEdit(Request $request, $id)
    {
        $lang   = $request->lang;
        $data  = SizeSubCategory::findOrFail($id);
        return view('backend.size.sub_category.edit', compact('lang', 'data'));
    }
    public function subcategoryUpdate(Request $request, $id)
    {
        $data = SizeSubCategory::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $data->name = $request->name;
        }
        $data->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $data->save();

        $size_sub_category_translation = SizeSubCategoryTranslation::firstOrNew(['lang' => $request->lang, 'size_sub_category_id' => $data->id]);
        $size_sub_category_translation->name = $request->name;
        $size_sub_category_translation->save();

        flash(translate('Data has been updated successfully'))->success();
        return back();
    }
    public function subCategoryDestroy($id)
    {
        $data = SizeSubCategory::findOrFail($id);
        foreach ($data->size_sub_category_translations as $key => $data_translation) {
            $data_translation->delete();
        }
        DB::table('size_child_categories')->where('size_sub_category_id', $id)->delete();
        SizeSubCategory::destroy($id);

        flash(translate('Data has been deleted successfully'))->success();
        return redirect()->back();
    }

    ///Child Category
    public function childCategories(Request $request)
    {
        $sort_search = null;
        $cats = SizeCategory::orderBy('name')->get();
		$subcats = SizeChildCategory::join('size_categories', 'size_categories.id', '=', 'size_child_categories.size_category_id')
			->join('size_sub_categories', 'size_sub_categories.id', 'size_child_categories.size_sub_category_id')
			->orderBy('size_categories.name', 'asc')
			->orderBy('size_sub_categories.name', 'asc')
			->orderBy('size_child_categories.name', 'asc');
//        $subcats = SizeChildCategory::orderBy('id', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $subcats = $subcats->where('size_child_categories.name', 'like', '%' . $sort_search . '%');
        }
        $datas = $subcats->select('size_child_categories.*', 'size_categories.id as size_cat_id', 'size_sub_categories.id as sub_id')->paginate(15);
        return view('backend.size.child_category.index', compact('cats', 'datas', 'sort_search'));
    }
    public function childCategoryStore(Request $request)
    {
        $size_child_category = new SizeChildCategory();
        $size_child_category->size_category_id = $request->cat_id;
        $size_child_category->size_sub_category_id = $request->sub_cat_id;
        $size_child_category->name = $request->name;
        $size_child_category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $size_child_category->save();

        $size_child_category_translation = SizeChildCategoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'size_child_category_id' => $size_child_category->id]);
        $size_child_category_translation->name = $request->name;
        $size_child_category_translation->save();

        flash(translate('Data has been inserted successfully'))->success();
        return redirect()->route('size.child.categories');
    }
    public function childCategoryEdit(Request $request, $id)
    {
        $lang   = $request->lang;
        $data  = SizeChildCategory::findOrFail($id);
        return view('backend.size.child_category.edit', compact('lang', 'data'));
    }
    public function childCategoryUpdate(Request $request, $id)
    {
        $data = SizeChildCategory::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $data->name = $request->name;
        }
        $data->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $data->save();

        $size_child_category_translation = SizeChildCategoryTranslation::firstOrNew(['lang' => $request->lang, 'size_child_category_id' => $data->id]);
        $size_child_category_translation->name = $request->name;
        $size_child_category_translation->save();

        flash(translate('Data has been updated successfully'))->success();
        return back();
    }
    public function childCategoryDestroy($id)
    {
        $data = SizeChildCategory::findOrFail($id);
        foreach ($data->size_child_category_translations as $key => $data_translation) {
            $data_translation->delete();
        }
        SizeChildCategory::destroy($id);
        flash(translate('Data has been deleted successfully'))->success();
        return redirect()->back();
    }

    public function ajaxsubcategory(Request $request)
    {
        $datas = SizeSubCategory::where('size_category_id', $request->id)->get();
        return view('backend.size.sub_category.ajax', compact('datas'));
    }
    public function ajaxchildcategory(Request $request)
    {
        $datas = SizeChildCategory::where('size_sub_category_id', $request->id)->get();
        return view('backend.size.child_category.ajax', compact('datas'));
    }

    public function getTyres()
    {
        return view('frontend.searching.search_tyres');
    }
    public function products(Request $request)
    {
        $prods = Product::where('size_child_category_id', $request->id)->get();
        return view('frontend.searching.size_products', compact('prods'));
    }
}
