<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailabilityRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\WorkshopAvailability;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Shop;
use App\User;
use Carbon\Carbon;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $sort_search = null;
        $approved = null;
        $sellers = Seller::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'seller')->where(function ($user) use ($sort_search) {
                $user->where('name', 'like', '%' . $sort_search . '%')->orWhere('email', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
            $sellers = $sellers->where(function ($seller) use ($user_ids) {
                $seller->whereIn('user_id', $user_ids);
            });
        }
        if ($request->approved_status != null) {
            $approved = $request->approved_status;
            $sellers = $sellers->where('verification_status', $approved);
        }
        $sellers = $sellers->paginate(15);
        return view('backend.sellers.index', compact('sellers', 'sort_search', 'approved'));
    }

    public function create()
    {
        $categories = Category::whereIn('name',['Tyre','Services'])->select('id','name')->orderBy('id', 'asc')->get();
        return view('backend.sellers.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (User::where('email', $request->email)->first() != null) {
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);
        if ($user->save()) {

            $category = json_encode($request->category_id);
            $seller = new Seller;
            $seller->user_id = $user->id;
            if ($seller->save()) {
                $shop = new Shop();
                $shop->user_id = $user->id;
                $shop->category_id = $category;
                $shop->name = $request->shop_name;
                $shop->address = $request->address;
                $shop->slug = 'demo-shop-' . $user->id;
                $shop->longitude = $request->longitude;
                $shop->latitude = $request->latitude;
                $shop->o_hours = $request->from_time . '-' . $request->to_time;
                $shop->no_of_staff = $request->no_of_staff;
                $shop->contact_no = $request->contact_no;
                $shop->working_bay = $request->working_bay;
                $shop->description = $request->description;
                $shop->availability_duration = $request->avail_duration;
                $shop->save();
                flash(translate('Workshop has been inserted successfully'))->success();
                return redirect()->route('sellers.index');
            }
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function edit($id)
    {
        $seller = Seller::findOrFail(decrypt($id));
        $shop = DB::table('shops')->where('user_id', $seller->user_id)->first();
        $categories = Category::whereIn('name',['Tyre','Services'])->select('id','name')->orderBy('id', 'asc')->get();
        return view('backend.sellers.edit', compact('seller', 'shop', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        $user = $seller->user;
        if (User::where('email', $request->email)->where('id','!=', $user->id)->first() != null) {
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if ($user->save()) {
                $category = json_encode($request->category_id);
                DB::table('shops')->where('user_id', $seller->user_id)->update([
                    'category_id' => $category,
                    'name' => $request->shop_name,
                    'address' => $request->address,
                    'slug' => 'demo-shop-' . $user->id,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'o_hours' => $request->from_time . '-' . $request->to_time,
                    'no_of_staff' => $request->no_of_staff,
                    'contact_no' => $request->contact_no,
                    'working_bay' => $request->working_bay,
                    'description' => $request->description,
                    'availability_duration' => $request->avail_duration
                ]);
                flash(translate('Workshop has been updated successfully'))->success();
                return redirect()->route('sellers.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        Shop::where('user_id', $seller->user_id)->delete();
        DB::table('products')->where('user_id', $seller->user_id)->delete();
        DB::table('orders')->where('user_id', $seller->user_id)->delete();
        DB::table('orders')->where('seller_id', $seller->user_id)->delete();
        DB::table('order_details')->where('seller_id', $seller->user_id)->delete();
        User::destroy($seller->user->id);
        if (Seller::destroy($id)) {
            flash(translate('Workshop has been deleted successfully'))->success();
            return redirect()->route('sellers.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_seller_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $seller_id) {
                $this->destroy($seller_id);
            }
        }

        return 1;
    }

    public function approve_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 1;
        if ($seller->save()) {
            flash(translate('Workshop has been approved successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function reject_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 0;
        if ($seller->save()) {
            flash(translate('Workshop verification request has been rejected successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function profile_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('backend.sellers.profile_modal', compact('seller'));
    }

    public function updateApproved(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        $seller->verification_status = $request->status;
        if ($seller->save()) {
            return 1;
        }
        return 0;
    }

    public function login($id)
    {
        $seller = Seller::findOrFail(decrypt($id));
        $user  = $seller->user;
        auth()->login($user, true);

        return redirect(route('dashboard'));
    }

    public function ban($id)
    {
        $seller = Seller::findOrFail($id);

        if ($seller->user->banned == 1) {
            $seller->user->banned = 0;
            flash(translate('Workshop has been unbanned successfully'))->success();
        } else {
            $seller->user->banned = 1;
            flash(translate('Workshop has been banned successfully'))->success();
        }

        $seller->user->save();
        return back();
    }


    public function availabilityRequests(Request $request)
    {
        $sort_search = null;
        $status = null;
        $requests = AvailabilityRequest::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $request_ids = AvailabilityRequest::where(function ($data) use ($sort_search) {
                $data->where('date', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
            $requests = $requests->where(function ($request) use ($request_ids) {
                $request->whereIn('id', $request_ids);
            });
        }
        if ($request->status != null) {
            $status = $request->status;
            $requests = $requests->where('status', $status);
        }
        $requests = $requests->paginate(15);
        foreach ($requests as $key => $value) {
            $request = AvailabilityRequest::find($value->id);
            $request->viewed = 1;
            $request->update();
        }

        return view('backend.sellers.availability_requests.index', compact('requests', 'sort_search', 'status'));
    }

    public function bulk_requests_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $request_id) {
                $this->destroyRequest($request_id);
            }
        }
        return 1;
    }

    public function destroyRequest($id)
    {
        $request = AvailabilityRequest::findOrFail($id);
        if ($request->delete()) {
            flash(translate('Request has been deleted successfully'))->success();
            return redirect()->route('sellers.availability-requests');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function approveRequest(Request $request)
    {
        $availability_request = AvailabilityRequest::find($request->request_id);
        WorkshopAvailability::where('shop_id', $availability_request->shop_id)->where('date', $availability_request->date)->update([
            'from_time' => $availability_request->from_time,
            'to_time' => $availability_request->to_time
        ]);
        $availability_request->update([
            'status' => 'Approved',
            'request_approved' => 1
        ]);
        // Generate Notification
        $shop_user_id = DB::table('shops')->where('id', $availability_request->shop_id)->first()->user_id;
        \App\Models\Notification::create([
            'user_id' => $shop_user_id,
            'is_admin' => 2,
            'availability_request_id' => $request->request_id,
            'type' => 'availability_request',
            'body' => translate('Date change requests approved from') . ' ' .  Carbon::parse($availability_request->previous_from_time)->format('h: i a') . '--' . Carbon::parse($availability_request->previous_to_time)->format('h: i a') . ' to ' . Carbon::parse($availability_request->from_time)->format('h: i a') . '--' . Carbon::parse($availability_request->to_time)->format('h: i a') . ' on ' . Carbon::parse($availability_request->date)->format('m-d-Y'),
            'availability_request_id' => $request->request_id
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $shop_user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => (translate('Date change requests approved from') . ' ' .  Carbon::parse($availability_request->previous_from_time)->format('h: i a') . '--' . Carbon::parse($availability_request->previous_to_time)->format('h: i a') . ' to ' . Carbon::parse($availability_request->from_time)->format('h: i a') . '--' . Carbon::parse($availability_request->to_time)->format('h: i a') . ' on ' . Carbon::parse($availability_request->date)->format('m-d-Y'))
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }

        $orders = Order::where('seller_id', $availability_request->shop_id)
        ->where('delivery_status', '!=', 'Confirmed')
        ->where('delivery_status', '!=', 'Done')
        ->where('delivery_status', '!=', 'Rejected')
        ->where('delivery_status', '!=', 'cancelled')
        ->whereDate('workshop_date', date('Y-m-d', strtotime($availability_request->date)))
        ->get();
        foreach ($orders as $order) {
            $order->update([
                'reassign_status' => 1,
            ]);
            // Generate Notification
            \App\Models\Notification::create([
                'user_id' => $order->user_id,
                'is_admin' => 3,
                'type' => 'reassign',
                'body' => translate('The order needs to be reassigned'),
                'order_id' => $order->id,
            ]);
            try {
                // Send firebase notification
                $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
                $array = array(
                    'device_token' => $device_token,
                    'title' => translate('The order needs to be reassigned')
                );
                send_firebase_notification($array);
            } catch (\Exception $e) {
                // dd($e);
            }
        }

        flash(translate('Request has been approved successfully'))->success();
        return redirect()->route('sellers.availability-requests');
    }
}
