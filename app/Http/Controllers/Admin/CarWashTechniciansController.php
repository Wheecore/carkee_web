<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarWashTechnician;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class CarWashTechniciansController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $technicians = User::orderBy('users.created_at', 'desc')
        ->where('users.user_type', 'technician')
        ->leftJoin('car_wash_technicians as cwt', 'cwt.user_id', 'users.id');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $technicians = $technicians->where(function ($query) use ($sort_search) {
                $query->where('users.name', 'like', '%' . $sort_search . '%')
                    ->orWhere('users.email', 'like', '%' . $sort_search . '%')
                    ->orWhere('users.phone', 'like', '%' . $sort_search . '%')
                    ->orWhere('cwt.name', 'like', '%' . $sort_search . '%');
            });
        }
        $technicians = $technicians->select('users.id','users.name','users.banned','users.email','users.phone',
        'cwt.name as shop_name')->paginate(15);
        return view('backend.car_wash_technicians.index', compact('technicians', 'sort_search'));
    }

    public function create()
    {
        return view('backend.car_wash_technicians.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'phone' => 'required|unique:users',
        ]);

        $technician = new User();
        $technician->name = $request->name;
        $technician->email = $request->email;
        $technician->phone = $request->phone;
        $technician->user_type = 'technician';
        $technician->password = bcrypt($request->password);
        $technician->save();

        $cw_technician = new CarWashTechnician();
        $cw_technician->user_id = $technician->id;
        $cw_technician->logo = $request->logo;
        $cw_technician->name = $request->shop_name;
        $cw_technician->address = $request->address;
        $cw_technician->longitude = $request->longitude;
        $cw_technician->latitude = $request->latitude;
        $cw_technician->save();
        
        flash(translate('Technician added Successfully'))->success();
        return redirect()->route('car-wash-technicians.index');
    }

    public function show(Request $request, $id)
    {
        $sort_search = null;
        $technician = User::where('users.id', decrypt($id))
        ->leftJoin('car_wash_technicians as cwt', 'cwt.user_id', 'users.id')
        ->select('users.id','users.name','users.email','users.phone',
        'cwt.name as shop_name','cwt.address','cwt.logo')->first();

        $usages = DB::table('car_wash_usages as wu')
        ->join('users as u', 'u.id', '=', 'wu.user_id')
        ->join('car_wash_payments as p','p.id', 'wu.car_wash_payment_id')
        ->leftJoin('car_wash_products as wp', 'wp.id', 'p.car_wash_product_id');
        if ($request->filled('search')) {
            $sort_search = $request->search;
            $usages = $usages->where(function ($query) use ($sort_search) {
                    $query->where('wp.name', 'like', '%' . $sort_search . '%')
                        ->orWhere('u.name', 'like', '%' . $sort_search . '%')
                        ->orWhere('u.email', 'like', '%' . $sort_search . '%')
                        ->orWhere('p.car_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('p.model_name', 'like', '%' . $sort_search . '%');
                });
        }
       
        $usages = $usages->select('wu.id','u.name', 'u.email', 'wp.name as product', 'p.car_plate', 'p.model_name', 'wu.created_at')
        ->orderBy('u.id', 'desc')
        ->where('wu.technician_id', $technician->id)
        ->paginate(15);
        return view('backend.car_wash_technicians.show', compact('technician', 'usages', 'sort_search'));
    }

    public function edit($id)
    {
        $technician = User::where('users.id',decrypt($id))
        ->leftJoin('car_wash_technicians as cwt', 'cwt.user_id', 'users.id')
        ->select('users.id', 'users.name', 'users.email', 'users.phone', 'cwt.name as shop_name', 'cwt.address', 'cwt.logo',
        'cwt.longitude', 'cwt.latitude')
        ->first();
        return view('backend.car_wash_technicians.edit', compact('technician'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required',
        ]);

        $technician = User::findOrFail($id);
        $technician->name = $request->name;
        $technician->email = $request->email;
        $technician->phone = $request->phone;
        $technician->save();

        $cw_technician = CarWashTechnician::where('user_id', $technician->id)->first();
        $cw_technician->logo = $request->logo;
        $cw_technician->name = $request->shop_name;
        $cw_technician->address = $request->address;
        $cw_technician->longitude = $request->longitude;
        $cw_technician->latitude = $request->latitude;
        $cw_technician->save();

        flash(translate('Technician updated Successfully'))->success();
        return redirect()->route('car-wash-technicians.index');
    }

    public function ban($id)
    {
        $technician = User::findOrFail($id);
        if ($technician->banned == 1) {
            $technician->banned = 0;
            flash(translate('Technician unbanned Successfully'))->success();
        } else {
            $technician->banned = 1;
            flash(translate('Technician banned Successfully'))->success();
        }
        $technician->save();
        return back();
    }

    public function destroy($id)
    {
        if (User::destroy($id)) {
            DB::table('car_wash_technicians')->where('user_id', $id)->delete();
            flash(translate('Technician has been deleted successfully'))->success();
            return redirect()->route('car-wash-technicians.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function bulk_technicians_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $id) {
                $this->destroy($id);
            }
        }
        return 1;
    }
}
