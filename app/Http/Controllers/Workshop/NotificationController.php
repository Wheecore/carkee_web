<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function all($user_id)
    {
        $notifications = DB::table('notifications as n')
        ->leftjoin('orders as o', 'o.id', '=', 'n.order_id')
        ->leftjoin('availability_requests as ar', 'ar.id', '=', 'n.availability_request_id')
        ->select('n.id', 'n.order_id', 'n.availability_request_id', 'n.type', 'n.body', 'n.created_at', 'n.is_viewed', 'n.is_admin', 'o.workshop_date')
        ->where('n.user_id', $user_id)
        ->orderBy('n.id', 'desc')
        ->get()
        ->toArray();

        return view('frontend.notifications', compact('notifications'));
    }
}
