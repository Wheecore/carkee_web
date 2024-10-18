<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceCategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceSubChildCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $categories = ServiceCategory::where('service_categories.parent_id', '!=', null)->orderBy('service_categories.created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $categories = $categories->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id');
            $categories = $categories->where('sct.name', 'like', '%' . $sort_search . '%');
        }
        $categories = $categories->select('service_categories.*')->paginate(15);
        $parent_categories = DB::table('service_categories')
            ->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')
            ->select('sct.service_category_id as id', 'sct.name')
            ->where('service_categories.parent_id', null)
            ->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))
            ->get()
            ->toArray();
        return view('backend.services.sub_child_categories.index', compact('categories', 'sort_search', 'parent_categories'));
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
        $category->parent_id = $request->parent_id;
        $category->save();

        $category_translation = new ServiceCategoryTranslation;
        $category_translation->service_category_id = $category->id;
        $category_translation->lang = 'en';
        $category_translation->name = $request->name;
        $category_translation->save();

        flash(translate('Category has been added successfully'))->success();
        return redirect(route('service-sub-child-categories.index'));
    }

    public function edit(Request $request, $id)
    {
        $data['category'] = ServiceCategory::findOrFail($id);
        $data['lang'] = (isset($_GET['lang']) ? $_GET['lang'] : 'en');
        $data['categories'] = DB::table('service_categories')
            ->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')
            ->select('sct.service_category_id as id', 'sct.name')
            ->where('service_categories.parent_id', null)
            ->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))
            ->get()
            ->toArray();

        return view('backend.services.sub_child_categories.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->parent_id = $request->parent_id;
        $category->save();

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
        return redirect(route('service-sub-child-categories.index'));
    }

    public function show($id)
    {
        $category = ServiceCategory::findOrFail($id);
        DB::table('service_category_translations')->where('service_category_id', $category->id)->delete();
        $category->delete();

        flash(translate('Category has been deleted successfully'))->success();
        return redirect(route('service-sub-child-categories.index'));
    }
    
    public function get_sub_child_categories(Request $request)
    {
        $categories = DB::table('service_categories')->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')->select('sct.service_category_id as id', 'sct.name')->where('service_categories.parent_id', $request->id)->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))->get()->toArray();
        $options = '<option value="" readonly="">--Select-</option>';
        $child_id = '';
        if ($request->has('child_id')) {
            $child_id = $request->child_id;
        }
        foreach ($categories as $category) {
            $selected = ($category->id == $child_id) ? 'selected' : '';
            $options .= '<option value="' . $category->id . '" ' . $selected . '>' . $category->name . '</option>';
        }
        
        return $options;
    }
}
