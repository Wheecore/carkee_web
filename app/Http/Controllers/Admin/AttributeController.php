<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function colors(Request $request)
    {
        $colors = Color::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.product.color.index', compact('colors'));
    }

    public function store_color(Request $request)
    {
        $color = new Color;
        $color->name = $request->name;
        $color->code = $request->code;

        $color->save();

        flash(translate('Color has been inserted successfully'))->success();
        return redirect()->route('colors');
    }

    public function edit_color(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        return view('backend.product.color.edit', compact('color'));
    }

    public function update_color(Request $request, $id)
    {
        $color = Color::findOrFail($id);
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();

        flash(translate('Color has been updated successfully'))->success();
        return back();
    }

    public function destroy_color($id)
    {
        Color::destroy($id);

        flash(translate('Color has been deleted successfully'))->success();
        return redirect()->route('colors');
    }
}
