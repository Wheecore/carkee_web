<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\AvailabilityRequest;
use DateTime;
use Illuminate\Http\Request;
use App\Models\WorkshopAvailability;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkshopAvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $timings = DB::table('workshop_availabilities')->where('shop_id', Auth::user()->shop->id)->whereYear('date', date('Y'))
            ->select('date')->get();
        return view('frontend.user.seller.availability.index', compact('timings'));
    }

    public function updateRequestStatus($id)
    {
        // Update Notication status
        DB::table('notifications')->where('id', $id)->update(['is_viewed' => 1]);
        $timings = DB::table('workshop_availabilities')->where('shop_id', Auth::user()->shop->id)->whereYear('date', date('Y'))
            ->select('date')->get();
        return view('frontend.user.seller.availability.index', compact('timings'));
    }

    public function store(Request $request)
    {
        if ($request->single_date) {
            $date_format = $request->single_date;
            $date_day = date('l', strtotime($date_format));
            $from_time = '';
            $to_time = '';
            if ($date_day == 'Monday') {
                $from_time = $request->monday_start_time;
                $to_time = $request->monday_end_time;
            }
            if ($date_day == 'Tuesday') {
                $from_time = $request->tuesday_start_time;
                $to_time = $request->tuesday_end_time;
            }
            if ($date_day == 'Wednesday') {
                $from_time = $request->wednesday_start_time;
                $to_time = $request->wednesday_end_time;
            }
            if ($date_day == 'Thursday') {
                $from_time = $request->thursday_start_time;
                $to_time = $request->thursday_end_time;
            }
            if ($date_day == 'Friday') {
                $from_time = $request->friday_start_time;
                $to_time = $request->friday_end_time;
            }
            if ($date_day == 'Saturday') {
                $from_time = $request->saturday_start_time;
                $to_time = $request->saturday_end_time;
            }
            if ($date_day == 'Sunday') {
                $from_time = $request->sunday_start_time;
                $to_time = $request->sunday_end_time;
            }
            $date_exist = WorkshopAvailability::where('shop_id', Auth::user()->shop->id)->where('date', $date_format)->first();
            if ($date_exist && $date_exist->from_time && $date_exist->to_time) {
                // $booked = DB::table('orders')->where('availability_id', $date_exist->id)->first();
                // if ($booked) {
                //     flash(translate('This date is already booked. you can not change timings.'))->warning();
                //     return back();
                // }
                $date_existt = $date_exist->date;
                $new_date = strtotime("first day of +2 month", strtotime(date("Y-m-d")));
                $new_date = date("Y-m-d", $new_date);
                if (new DateTime($date_existt) < new DateTime($new_date)) {
                    $date_exist_pending = DB::table('availability_requests')->where('shop_id', Auth::user()->shop->id)->where('date', $date_format)
                        ->where('status', 'Pending')->select('date', 'from_time', 'to_time')->first();
                    if ($date_exist_pending) {
                        flash(translate('Request is already in pending for this date.'))->warning();
                        return back();
                    } else {
                        $request = new AvailabilityRequest();
                        $request->shop_id = Auth::user()->shop->id;
                        $request->date = $date_format;
                        $request->previous_from_time = $date_exist->from_time;
                        $request->previous_to_time = $date_exist->to_time;
                        $request->from_time = $from_time;
                        $request->to_time = $to_time;
                        $request->save();
                        flash(translate('Date change request is generated successfully.'))->success();
                        return back();
                    }
                } else {
                    WorkshopAvailability::where('shop_id', Auth::user()->shop->id)->where('date', $date_format)->update([
                        'from_time' => $from_time,
                        'to_time' => $to_time,
                    ]);

                    $orders = Order::where('seller_id', Auth::user()->shop->id)
                    ->where('delivery_status', '!=', 'Confirmed')
                    ->where('delivery_status', '!=', 'Done')
                    ->where('delivery_status', '!=', 'Rejected')
                    ->where('delivery_status', '!=', 'cancelled')
                    ->whereDate('workshop_date', date('Y-m-d', strtotime($date_format)))
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

                    flash(translate('Schedule set successfully!'))->success();
                    return back();
                }
            } else if ($date_exist && !$date_exist->from_time && !$date_exist->to_time) {
                WorkshopAvailability::where('shop_id', Auth::user()->shop->id)->where('date', $date_format)->update([
                    'from_time' => $from_time,
                    'to_time' => $to_time,
                ]);
                flash(translate('Schedule set successfully!'))->success();
                return back();
            } else {
                $schedule = new WorkshopAvailability;
                $schedule->shop_id = Auth::user()->shop->id;
                $schedule->date = $date_format;
                $schedule->from_time = $from_time;
                $schedule->to_time = $to_time;
                $schedule->save();
                flash(translate('Schedule set successfully!'))->success();
                return back();
            }
        } else {
            $request->validate([
                'month' => 'required',
            ]);
            $months_array = $request->month;
            // $begin = new DateTime($months_array[0].' '.$request->selected_year);
            // Last day of the last selected month.
            // $end   = new DateTime(date('Y-m-t', strtotime(array_pop($months_array).' '.$request->selected_year)));
            // will update just the months which is after two months from the current month
            foreach ($months_array as $month) {
                $date = new DateTime($month . ' ' . $request->selected_year);
                $end   = new DateTime(date('Y-m-t', strtotime($month . ' ' . $request->selected_year)));
                $month_exists = DB::table('workshop_availabilities')->where('shop_id', Auth::user()->shop->id)->whereMonth('date', $date->format('m'))->whereYear('date', $date->format('Y'))
                    ->select('date')->first();
                if ($month_exists) {
                    $month_exists = $month_exists->date;
                    $next_date = strtotime("first day of +2 month", strtotime(date("Y-m-d")));
                    $next_date = date("Y-m-d", $next_date);
                    if (new DateTime($month_exists) < new DateTime($next_date)) {
                        flash(translate('You can just update after two months from the current month'))->warning();
                        return back();
                    } else {
                        $this->saveOrUpdate($date, $end, $request);
                    }
                } else {
                    $this->saveOrUpdate($date, $end, $request);
                }
            }
            flash(translate('Schedule set successfully!'))->success();
            return back();
        }
    }

    public function saveOrUpdate($begin, $end, $request)
    {
        for ($date = $begin; $date <= $end; $date->modify('+1 day')) {
            $date_format = $date->format("Y-m-d");
            $date_day = date('l', strtotime($date_format));
            $from_time = '';
            $to_time = '';
            if ($date_day == 'Monday') {
                $from_time = $request->monday_start_time;
                $to_time = $request->monday_end_time;
            }
            if ($date_day == 'Tuesday') {
                $from_time = $request->tuesday_start_time;
                $to_time = $request->tuesday_end_time;
            }
            if ($date_day == 'Wednesday') {
                $from_time = $request->wednesday_start_time;
                $to_time = $request->wednesday_end_time;
            }
            if ($date_day == 'Thursday') {
                $from_time = $request->thursday_start_time;
                $to_time = $request->thursday_end_time;
            }
            if ($date_day == 'Friday') {
                $from_time = $request->friday_start_time;
                $to_time = $request->friday_end_time;
            }
            if ($date_day == 'Saturday') {
                $from_time = $request->saturday_start_time;
                $to_time = $request->saturday_end_time;
            }
            if ($date_day == 'Sunday') {
                $from_time = $request->sunday_start_time;
                $to_time = $request->sunday_end_time;
            }
            $exists = WorkshopAvailability::where('shop_id', Auth::user()->shop->id)->where('date', $date_format)->first();
            // if($exists){
            //     $booked = DB::table('orders')->where('availability_id', $exists->id)->first();
            // }
            // else{
            //     $booked = '';
            // }
            // if ($booked) {
            //     continue;
            // }
            // else {
            if ($exists) {
                $exists->from_time = $from_time;
                $exists->to_time = $to_time;
                $exists->update();

                $orders = Order::where('seller_id', Auth::user()->shop->id)
                ->where('delivery_status', '!=', 'Confirmed')
                ->where('delivery_status', '!=', 'Done')
                ->where('delivery_status', '!=', 'Rejected')
                ->where('delivery_status', '!=', 'cancelled')
                ->where('workshop_date', date('m/d/Y', strtotime($date_format)))
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


            } else {
                $schedule = new WorkshopAvailability;
                $schedule->shop_id = Auth::user()->shop->id;
                $schedule->date = $date_format;
                $schedule->from_time = $from_time;
                $schedule->to_time = $to_time;
                $schedule->save();
            }
            // }
        }
    }

    public function monthTiming(Request $request)
    {
        $month = date('m', strtotime($request->month));
        return DB::table('workshop_availabilities')->where('shop_id', Auth::user()->shop->id)->whereYear('date', $request->year)
            ->whereMonth('date', $month)->select('date', 'from_time', 'to_time')->get();
    }

    public function yearTiming(Request $request)
    {
        return DB::table('workshop_availabilities')->where('shop_id', Auth::user()->shop->id)->whereYear('date', $request->year)
            ->select('date')->get();
    }

    public function dateTiming(Request $request)
    {
        $time = DB::table('workshop_availabilities')->where('shop_id', Auth::user()->shop->id)->where('date', $request->dateyear)
            ->select('date', 'from_time', 'to_time')->first();
        return response()->json($time);
    }

    public function getDates()
    {
        $data = WorkshopAvailability::select('date')->where('shop_id', Auth::user()->shop->id)->where('from_time', '!=', '')->where('to_time', '!=', '')->get();
        if (count($data) > 0) {
            return $data;
        } else {
            return 'empty';
        }
    }
}
