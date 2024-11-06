<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedCategory;
use App\Models\FeaturedSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class FeaturedCategoryController extends Controller
{

	// const type = tyre=>Tyre, parts=>Parts, car_wash =>Car Wash
	const type = [
		'tyre' => 'Tyre',
		'parts' => 'Parts',
		'car_wash' => 'Car Wash',
	];

	public function categories(Request $request)
	{
		$sort_search = null;
		$cats = FeaturedCategory::orderBy('id', 'desc');

		if ($request->has('search')) {
			$sort_search = $request->search;
			$cats = $cats->where('name', 'like', '%' . $sort_search . '%');
		}

		$types = self::type;
		$datas = $cats->paginate(15);

		return view('backend.featured_category.category.index', compact('datas', 'sort_search', 'types'));
	}

	public function categoryStore(Request $request)
	{
		$category = new FeaturedCategory;
		$category->name = $request->name;
        $category->type = $request->type;
		$category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
		$category->save();

		flash(translate('Data has been inserted successfully'))->success();
		return redirect()->route('featured.categories');
	}
    
	public function categoryEdit(Request $request, $id)
	{
		$lang = $request->lang;
		$data = FeaturedCategory::findOrFail($id);
        $types = self::type;
		return view('backend.featured_category.category.edit', compact('lang', 'data', 'types'));
	}

	public function categoryUpdate(Request $request, $id)
	{
		$category = FeaturedCategory::findOrFail($id);
		if ($request->lang == env("DEFAULT_LANGUAGE")) {
			$category->name = $request->name;
            $category->type = $request->type;
		}
		$category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
		$category->save();

		flash(translate('Data has been updated successfully'))->success();
		return back();
	}
	public function categoryDestroy($id)
	{
		DB::table('featured_sub_categories')->where('featured_category_id', $id)->delete();
		FeaturedCategory::findOrFail($id)->delete();
		flash(translate('Data has been deleted successfully'))->success();
		return redirect()->back();
	}

	///subCategories
	public function subCategories(Request $request)
	{
		$sort_search = null;
		$cats = FeaturedCategory::all();
		$subcats = FeaturedSubCategory::orderBy('id', 'desc');
		if ($request->has('search')) {
			$sort_search = $request->search;
			$subcats = $subcats->where('name', 'like', '%' . $sort_search . '%');
		}
		$datas = $subcats->paginate(15);
		return view('backend.featured_category.sub_category.index', compact('cats', 'datas', 'sort_search'));
	}
	public function subCategoryStore(Request $request)
	{
		$data = new FeaturedSubCategory;
		$data->featured_category_id = $request->cat_id;
		$data->name = $request->name;
		$data->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
		$data->save();

		flash(translate('Data has been inserted successfully'))->success();
		return redirect()->route('featured.sub.categories');
	}
	public function subCategoryEdit(Request $request, $id)
	{
		$lang = $request->lang;
		$data = FeaturedSubCategory::findOrFail($id);
		return view('backend.featured_category.sub_category.edit', compact('lang', 'data'));
	}
	public function subcategoryUpdate(Request $request, $id)
	{
		$data = FeaturedSubCategory::findOrFail($id);
		if ($request->lang == env("DEFAULT_LANGUAGE")) {
			$data->name = $request->name;
		}
		$data->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
		$data->save();
		flash(translate('Data has been updated successfully'))->success();
		return back();
	}
	public function subCategoryDestroy($id)
	{
		FeaturedSubCategory::findOrFail($id)->delete();
		flash(translate('Data has been deleted successfully'))->success();
		return redirect()->back();
	}
	public function ajaxsubcategory(Request $request)
	{
		$datas = FeaturedSubCategory::where('featured_category_id', $request->id)->get();
		return view('backend.featured_category.sub_category.ajax', compact('datas'));
	}
}
