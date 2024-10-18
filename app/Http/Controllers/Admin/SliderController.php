<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('backend.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('sliders.create');
    }

    public function store(Request $request)
    {
        if ($request->photo) {
            $slider = new Slider;
            $slider->link = $request->url;
            $slider->photo = $request->photo;
            $slider->save();
            flash(translate('Slider has been inserted successfully'))->success();
        }
        return redirect()->route('slider.index');
    }

    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();
        flash(translate('Slider has been deleted successfully'))->success();

        return redirect()->route('slider.index');
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('backend.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        $slider->photo = $request->photo;
        $slider->published = $request->status;
        if ($slider->save()) {
            return redirect('admin/slider');
        } else {
            return redirect('admin/slider');
        }
    }
}
