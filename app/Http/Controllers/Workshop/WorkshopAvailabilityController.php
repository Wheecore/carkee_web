<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Models\AvailabilityRequest;
use App\Models\Order;
use App\Models\WorkshopAvailability;
use DateTime;
use Illuminate\Http\Request;
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

			// Determine from_time and to_time based on the day of the week
			$from_time = '';
			$to_time = '';
			switch ($date_day) {
				case 'Monday':
					$from_time = $request->monday_start_time;
					$to_time = $request->monday_end_time;
					break;
				case 'Tuesday':
					$from_time = $request->tuesday_start_time;
					$to_time = $request->tuesday_end_time;
					break;
				case 'Wednesday':
					$from_time = $request->wednesday_start_time;
					$to_time = $request->wednesday_end_time;
					break;
				case 'Thursday':
					$from_time = $request->thursday_start_time;
					$to_time = $request->thursday_end_time;
					break;
				case 'Friday':
					$from_time = $request->friday_start_time;
					$to_time = $request->friday_end_time;
					break;
				case 'Saturday':
					$from_time = $request->saturday_start_time;
					$to_time = $request->saturday_end_time;
					break;
				case 'Sunday':
					$from_time = $request->sunday_start_time;
					$to_time = $request->sunday_end_time;
					break;
			}

			// Check if the date exists in WorkshopAvailability
			$date_exist = WorkshopAvailability::where('shop_id', Auth::user()->shop->id)
				->where('date', $date_format)
				->first();

			if ($date_exist) {
				$date_existt = $date_exist->date;
				$new_date = strtotime("first day of +2 months", strtotime(date("Y-m-d")));
				$new_date = date("Y-m-d", $new_date);

				// If the date is within two months, insert into availability_requests
				if (new DateTime($date_existt) < new DateTime($new_date)) {
					$date_exist_pending = DB::table('availability_requests')
						->where('shop_id', Auth::user()->shop->id)
						->where('date', $date_format)
						->where('status', 'Pending')
						->select('date', 'from_time', 'to_time')
						->first();

					if ($date_exist_pending) {
						flash(translate('Request is already in pending for this date.'))->warning();
						return back();
					} else {
						// Insert a new availability request
						$availability_request = new AvailabilityRequest();
						$availability_request->shop_id = Auth::user()->shop->id;
						$availability_request->date = $date_format;
						$availability_request->previous_from_time = $date_exist->from_time;
						$availability_request->previous_to_time = $date_exist->to_time;
						$availability_request->from_time = $from_time;
						$availability_request->to_time = $to_time;
						$availability_request->save();

						flash(translate('Date change request is generated successfully.'))->success();
						return back();
					}
				} else {
					// If the date is over two months, update WorkshopAvailability
					WorkshopAvailability::where('shop_id', Auth::user()->shop->id)
						->where('date', $date_format)
						->update([
							'from_time' => $from_time,
							'to_time' => $to_time,
						]);

					// Update relevant orders and send notifications
					$orders = Order::where('seller_id', Auth::user()->shop->id)
						->where('delivery_status', '!=', 'Confirmed')
						->where('delivery_status', '!=', 'Done')
						->where('delivery_status', '!=', 'Rejected')
						->where('delivery_status', '!=', 'cancelled')
						->whereDate('workshop_date', date('Y-m-d', strtotime($date_format)))
						->get();

					foreach ($orders as $order) {
						$order->update(['reassign_status' => 1]);

						// Generate Notification
						\App\Models\Notification::create([
							'user_id' => $order->user_id,
							'is_admin' => 3,
							'type' => 'reassign',
							'body' => translate('The order needs to be reassigned'),
							'order_id' => $order->id,
						]);

						try {
							// Send Firebase notification
							$device_token = DB::table('device_tokens')
								->where('user_id', $order->user_id)
								->select('token')
								->get()
								->toArray();

							$array = [
								'device_token' => $device_token,
								'title' => translate('The order needs to be reassigned'),
							];
							send_firebase_notification($array);
						} catch (\Exception $e) {
							// Handle exception
						}
					}

					flash(translate('Schedule set successfully!'))->success();
					return back();
				}
			} else {
				// If the date does not exist, create a new WorkshopAvailability
				$schedule = new WorkshopAvailability();
				$schedule->shop_id = Auth::user()->shop->id;
				$schedule->date = $date_format;
				$schedule->from_time = $from_time;
				$schedule->to_time = $to_time;
				$schedule->save();

				flash(translate('Schedule set successfully!'))->success();
				return back();
			}
		} else {
			// Validation for month-based input
			$request->validate(['month' => 'required']);
			$months_array = $request->month;

			foreach ($months_array as $month) {
				$date = new DateTime($month . ' ' . $request->selected_year);
				$end = new DateTime(date('Y-m-t', strtotime($month . ' ' . $request->selected_year)));

				// Check if the date exists in WorkshopAvailability
				$month_exists = DB::table('workshop_availabilities')
					->where('shop_id', Auth::user()->shop->id)
					->whereMonth('date', $date->format('m'))
					->whereYear('date', $date->format('Y'))
					->select('date')
					->first();

				if ($month_exists) {
					$month_exists_date = $month_exists->date;
					$next_date = strtotime("first day of +2 months", strtotime(date("Y-m-d")));
					$next_date = date("Y-m-d", $next_date);

					if (new DateTime($month_exists_date) < new DateTime($next_date)) {
						flash(translate('You can just update after two months from the current month'))->warning();
						return back();
					} else {
						$this->saveOrUpdate($date, $end, $request);
					}
				} else {
					// If the date does not exist, insert a new record directly
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

			// Determine from_time and to_time based on the day of the week
			$from_time = '';
			$to_time = '';
			switch ($date_day) {
				case 'Monday':
					$from_time = $request->monday_start_time;
					$to_time = $request->monday_end_time;
					break;
				case 'Tuesday':
					$from_time = $request->tuesday_start_time;
					$to_time = $request->tuesday_end_time;
					break;
				case 'Wednesday':
					$from_time = $request->wednesday_start_time;
					$to_time = $request->wednesday_end_time;
					break;
				case 'Thursday':
					$from_time = $request->thursday_start_time;
					$to_time = $request->thursday_end_time;
					break;
				case 'Friday':
					$from_time = $request->friday_start_time;
					$to_time = $request->friday_end_time;
					break;
				case 'Saturday':
					$from_time = $request->saturday_start_time;
					$to_time = $request->saturday_end_time;
					break;
				case 'Sunday':
					$from_time = $request->sunday_start_time;
					$to_time = $request->sunday_end_time;
					break;
			}

			// Check if the date exists in WorkshopAvailability
			$exists = WorkshopAvailability::where('shop_id', Auth::user()->shop->id)
				->where('date', $date_format)
				->first();

			if ($exists) {
				// Only update if the new from_time and to_time are not null
				if ($from_time && $to_time) {
					$exists->from_time = $from_time;
					$exists->to_time = $to_time;
					$exists->update();

					// Update relevant orders and send notifications
					$orders = Order::where('seller_id', Auth::user()->shop->id)
						->where('delivery_status', '!=', 'Confirmed')
						->where('delivery_status', '!=', 'Done')
						->where('delivery_status', '!=', 'Rejected')
						->where('delivery_status', '!=', 'cancelled')
						->whereDate('workshop_date', $date_format)
						->get();

					foreach ($orders as $order) {
						$order->update(['reassign_status' => 1]);
						\App\Models\Notification::create([
							'user_id' => $order->user_id,
							'is_admin' => 3,
							'type' => 'reassign',
							'body' => translate('The order needs to be reassigned'),
							'order_id' => $order->id,
						]);

						try {
							// Send Firebase notification
							$device_token = DB::table('device_tokens')
								->where('user_id', $order->user_id)
								->select('token')
								->get()
								->toArray();

							$array = [
								'device_token' => $device_token,
								'title' => translate('The order needs to be reassigned'),
							];
							send_firebase_notification($array);
						} catch (\Exception $e) {
							// Handle exception
						}
					}
				}
			} else {
				// Insert a new record if the date does not exist
				$schedule = new WorkshopAvailability();
				$schedule->shop_id = Auth::user()->shop->id;
				$schedule->date = $date_format;
				$schedule->from_time = $from_time;
				$schedule->to_time = $to_time;
				$schedule->save();
			}
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
