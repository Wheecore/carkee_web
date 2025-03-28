<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\CityTranslation;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::paginate(15);
        $countries = Country::where('status', 1)->get();
        return view('backend.setup_configurations.cities.index', compact('cities', 'countries'));
    }

    public function store(Request $request)
    {
        $city = new City;
        $city->name = $request->name;
        $city->cost = $request->cost;
        $city->country_id = $request->country_id;
        $city->save();

        flash(translate('City has been inserted successfully'))->success();

        return back();
    }

    public function edit(Request $request, $id)
    {
        $lang  = $request->lang;
        $city  = City::findOrFail($id);
        $countries = Country::where('status', 1)->get();
        return view('backend.setup_configurations.cities.edit', compact('city', 'lang', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $city->name = $request->name;
        }

        $city->country_id = $request->country_id;
        $city->cost = $request->cost;
        $city->save();

        $city_translation = CityTranslation::firstOrNew(['lang' => $request->lang, 'city_id' => $city->id]);
        $city_translation->name = $request->name;
        $city_translation->save();

        flash(translate('City has been updated successfully'))->success();
        return back();
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        foreach ($city->city_translations as $key => $city_translation) {
            $city_translation->delete();
        }

        City::destroy($id);

        flash(translate('City has been deleted successfully'))->success();
        return redirect()->route('cities.index');
    }

    public function get_city(Request $request)
    {
        $country_info = Country::where('status', 1)->where('name', $request->country_name)->first();

        $cities = City::where('country_id', $country_info->id)->get();
        $html = '';

        foreach ($cities as $row) {
            //            $val = $row->id . ' | ' . $row->name;
            $html .= '<option value="' . $row->name . '">' . $row->getTranslation('name') . '</option>';
        }

        echo json_encode($html);
    }
}
