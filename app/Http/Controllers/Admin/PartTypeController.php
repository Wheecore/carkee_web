<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PartType;
use App\Models\PartTypeTranslation;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartTypeController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $part_types = PartType::orderBy('name', 'asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $part_types = $part_types->where('name', 'like', '%' . $sort_search . '%');
        }
        $part_types = $part_types->paginate(15);
        return view('backend.product.part_type.index', compact('part_types', 'sort_search'));
    }

    public function store(Request $request)
    {
        $part_type = new PartType;
        $part_type->name = strtoupper($request->name);
        $part_type->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $part_type->save();

        $brand_translation = PartTypeTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'part_type_id' => $part_type->id]);
        $brand_translation->name = strtoupper($request->name);
        $brand_translation->save();

        flash(translate('Part Type has been inserted successfully'))->success();
        return redirect()->route('part-types.index');
    }

    public function edit(Request $request, $id)
    {
        $lang   = $request->lang;
        $part_type  = PartType::findOrFail($id);
        return view('backend.product.part_type.edit', compact('part_type', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $part_type = PartType::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $part_type->name = strtoupper($request->name);
        }
        $part_type->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtoupper($request->name))) . '-' . Str::random(5);
        $part_type->save();

        $brand_translation = PartTypeTranslation::firstOrNew(['lang' => $request->lang, 'part_type_id' => $part_type->id]);
        $brand_translation->name = strtoupper($request->name);
        $brand_translation->save();

        flash(translate('Part Type has been updated successfully'))->success();
        return back();
    }

    public function destroy($id)
    {
        $part_type = PartType::findOrFail($id);
        Product::where('brand_id', $part_type->id)->delete();
        foreach ($part_type->part_type_translations as $brand_translation) {
            $brand_translation->delete();
        }
        PartType::destroy($id);

        flash(translate('Part Type has been deleted successfully'))->success();
        return redirect()->route('part-types.index');
    }
    
}
