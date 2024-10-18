<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\SizeAlternative;
use Illuminate\Http\Request;

class SizeAlternativeController extends Controller
{
    public function index(Request $request)
    {
        $models = CarModel::select('id','name')->get();
        $sort_search = null;
        $datas = SizeAlternative::orderBy('name', 'asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $datas = $datas->where('name', 'like', '%' . $sort_search . '%');
        }
        $datas = $datas->paginate(15);
        return view('backend.size_alternative.index', compact('models', 'datas', 'sort_search'));
    }

    public function store(Request $request)
    {
        $data = new SizeAlternative();
        $data->model_id = $request->model_id;
        $data->name = $request->name;
        $data->save();

        flash(translate('Date been inserted successfully'))->success();
        return redirect()->route('size_alternative.index');
    }

    public function show($id)
    {
        SizeAlternative::where('id', $id)->delete();
        flash(translate('data been deleted successfully'))->success();
        return redirect()->back();
    }

    public function edit($id)
    {
        $models = CarModel::select('id','name')->get();
        $data = SizeAlternative::where('id', $id)->first();
        return view('backend.size_alternative.edit', compact('models', 'data'));
    }

    public function update(Request $request, $id)
    {
        $data = SizeAlternative::findOrFail($id);
        $data->model_id = $request->model_id;
        $data->name = $request->name;
        $data->save();
        flash(translate('data been updated successfully'))->success();
        return redirect()->route('size_alternative.index');
    }
}
