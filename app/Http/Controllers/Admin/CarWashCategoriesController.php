<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarWashCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarWashCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $categories = CarWashCategory::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $categories = $categories->where('name', 'like', '%' . $sort_search . '%');
        }
        $categories = $categories->paginate(15);
        return view('backend.product.car_washes.categories.index', compact('categories', 'sort_search'));
    }

    public function create()
    {
        return view('backend.product.car_washes.categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:car_wash_categories,name']);
        $category = new CarWashCategory;
        $category->name = $request->name;
        $category->color_code = $request->color_code;
        $category->save();

        flash(translate('Category has been added successfully'))->success();
        return redirect(route('car-washes-categories.index'));
    }

    public function edit(Request $request, $id)
    {
        $category = CarWashCategory::findOrFail($id);
        return view('backend.product.car_washes.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = CarWashCategory::findOrFail($id);
        $request->validate([
            'name' => 'unique:car_wash_categories,name,' . $category->id,
        ]);
        $category->name = $request->name;
        $category->color_code = $request->color_code;
        $category->save();

        flash(translate('Category has been updated successfully'))->success();
        return redirect(route('car-washes-categories.index'));
    }

    public function destroy($id)
    {
        $category = CarWashCategory::findOrFail($id);
        DB::table('car_wash_products')->where('category_id', $category->id)->update(['category_id' => null]);
        $category->delete();

        flash(translate('Category has been deleted successfully'))->success();
        return redirect(route('car-washes-categories.index'));
    }
}
