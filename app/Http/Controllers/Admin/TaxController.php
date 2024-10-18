<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $all_taxes = Tax::orderBy('created_at', 'desc')->get();
        return view('backend.setup_configurations.tax.index', compact('all_taxes'));
    }

    public function store(Request $request)
    {
        $tax = new Tax;
        $tax->name = $request->name;
        if ($tax->save()) {
            flash(translate('Tax has been inserted successfully'))->success();
            return redirect()->route('tax.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function edit($id)
    {
        $tax = Tax::findOrFail($id);
        return view('backend.setup_configurations.tax.edit', compact('tax'));
    }

    public function update(Request $request, $id)
    {
        $tax = Tax::findOrFail($id);
        $tax->name = $request->name;
        // $language->code = $request->code;
        if ($tax->save()) {
            flash(translate('Tax has been updated successfully'))->success();
            return redirect()->route('tax.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function change_tax_status(Request $request)
    {
        $tax = Tax::findOrFail($request->id);
        if ($tax->tax_status == 1) {
            $tax->tax_status = 0;
        } else {
            $tax->tax_status = 1;
        }

        if ($tax->save()) {
            return 1;
        }
        return 0;
    }

    public function destroy($id)
    {
        if (Tax::destroy($id)) {
            flash(translate('Tax has been deleted successfully'))->success();
            return redirect()->route('tax.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }
}
