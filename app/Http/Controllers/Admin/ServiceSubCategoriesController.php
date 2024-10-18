<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceCategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceSubCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $categories = ServiceCategory::where('service_categories.parent_id', null)->orderBy('service_categories.created_at', 'desc')
        ->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $categories = $categories->where('sct.name', 'like', '%' . $sort_search . '%');
        }
        $categories = $categories->select('sct.name', 'service_categories.id')->paginate(15);
        return view('backend.services.sub_categories.index', compact('categories', 'sort_search'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        if (DB::table('service_category_translations')->where('lang', 'en')->where('name', $request->name)->first()) {
            return back()->with('danger', translate('Category name is already taken'));
        }

        $category = new ServiceCategory;
        $category->save();

        $category_translation = new ServiceCategoryTranslation;
        $category_translation->service_category_id = $category->id;
        $category_translation->lang = 'en';
        $category_translation->name = $request->name;
        $category_translation->save();

        flash(translate('Category has been added successfully'))->success();
        return redirect(route('service-sub-categories.index'));
    }

    public function edit(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        $lang = (isset($_GET['lang']) ? $_GET['lang'] : 'en');
        return view('backend.services.sub_categories.edit', compact('category', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $category_translation = ServiceCategoryTranslation::where('service_category_id', $id)->where('lang', $request->lang)->first();
        if ($category_translation) {
            $category_translation->lang = $request->lang;
            $category_translation->name = $request->name;
            $category_translation->save();
        } else {
            $category_translation = new ServiceCategoryTranslation;
            $category_translation->service_category_id = $id;
            $category_translation->lang = 'en';
            $category_translation->name = $request->name;
            $category_translation->save();
        }

        flash(translate('Category has been updated successfully'))->success();
        return redirect(route('service-sub-categories.index'));
    }

    public function show($id)
    {
        $category = ServiceCategory::findOrFail($id);
        DB::table('service_categories')->where('parent_id', $category->id)->delete();
        DB::table('service_category_translations')->where('service_category_id', $category->id)->delete();
        $category->delete();

        flash(translate('Category has been deleted successfully'))->success();
        return redirect(route('service-sub-categories.index'));
    }
}
