<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatterySubCategory;
use App\Models\BatterySubCategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatterySubCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $categories = BatterySubCategory::where('battery_sub_categories.parent_id', null)->orderBy('battery_sub_categories.created_at', 'desc')
        ->leftJoin('battery_sub_category_translations as bsct', 'bsct.battery_sub_category_id', '=', 'battery_sub_categories.id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $categories = $categories->where('bsct.name', 'like', '%' . $sort_search . '%');
        }
        $categories = $categories->select('bsct.name', 'battery_sub_categories.id')->paginate(15);
        return view('backend.product.batteries.sub_categories.index', compact('categories', 'sort_search'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        if (DB::table('battery_sub_category_translations')->where('lang', 'en')->where('name', $request->name)->first()) {
            return back()->with('danger', translate('Category name is already taken'));
        }

        $category = new BatterySubCategory;
        $category->save();

        $category_translation = new BatterySubCategoryTranslation();
        $category_translation->battery_sub_category_id = $category->id;
        $category_translation->lang = 'en';
        $category_translation->name = $request->name;
        $category_translation->save();

        flash(translate('Category has been added successfully'))->success();
        return redirect(route('battery-sub-categories.index'));
    }

    public function edit($id)
    {
        $category = BatterySubCategory::findOrFail($id);
        $lang = (isset($_GET['lang']) ? $_GET['lang'] : 'en');
        return view('backend.product.batteries.sub_categories.edit', compact('category', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $category_translation = BatterySubCategoryTranslation::where('battery_sub_category_id', $id)->where('lang', $request->lang)->first();
        if ($category_translation) {
            $category_translation->lang = $request->lang;
            $category_translation->name = $request->name;
            $category_translation->save();
        } else {
            $category_translation = new BatterySubCategoryTranslation;
            $category_translation->battery_sub_category_id = $id;
            $category_translation->lang = 'en';
            $category_translation->name = $request->name;
            $category_translation->save();
        }

        flash(translate('Category has been updated successfully'))->success();
        return redirect(route('battery-sub-categories.index'));
    }

    public function show($id)
    {
        $category = BatterySubCategory::findOrFail($id);
        DB::table('battery_sub_categories')->where('parent_id', $category->id)->delete();
        DB::table('battery_sub_category_translations')->where('battery_sub_category_id', $category->id)->delete();
        $category->delete();

        flash(translate('Category has been deleted successfully'))->success();
        return redirect(route('battery-sub-categories.index'));
    }
    
    public function battery_get_sub_child_categories(Request $request)
    {
        $categories = DB::table('battery_sub_categories')->join('battery_sub_category_translations as sct', 'sct.battery_sub_category_id', '=', 'battery_sub_categories.id')->select('sct.battery_sub_category_id as id', 'sct.name')->where('battery_sub_categories.parent_id', $request->id)->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))->get()->toArray();
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
