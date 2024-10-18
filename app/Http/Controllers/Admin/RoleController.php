<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleTranslation;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('backend.staff.staff_roles.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.staff.staff_roles.create');
    }

    public function store(Request $request)
    {
        // if ($request->has('permissions')) {
            $role = new Role;
            $role->name = $request->name;
            $role->permissions = json_encode($request->permissions);
            $role->save();

            $role_translation = RoleTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'role_id' => $role->id]);
            $role_translation->name = $request->name;
            $role_translation->save();

            flash(translate('Role has been inserted successfully'))->success();
            return redirect()->route('roles.index');
        // }
        // flash(translate('Something went wrong'))->error();
        // return back();
    }

    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $role = Role::findOrFail($id);
        return view('backend.staff.staff_roles.edit', compact('role', 'lang'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // if ($request->has('permissions')) {
            if ($request->lang == env("DEFAULT_LANGUAGE")) {
                $role->name = $request->name;
            }
            $role->permissions = json_encode($request->permissions);
            $role->save();

            $role_translation = RoleTranslation::firstOrNew(['lang' => $request->lang, 'role_id' => $role->id]);
            $role_translation->name = $request->name;
            $role_translation->save();

            flash(translate('Role has been updated successfully'))->success();
            return redirect()->route('roles.index');
        // }
        // flash(translate('Something went wrong'))->error();
        // return back();
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        foreach ($role->role_translations as $key => $role_translation) {
            $role_translation->delete();
        }

        Role::destroy($id);
        flash(translate('Role has been deleted successfully'))->success();
        return redirect()->route('roles.index');
    }
}
