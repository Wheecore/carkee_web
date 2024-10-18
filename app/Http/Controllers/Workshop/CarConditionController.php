<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class CarConditionController extends Controller
{
    public function save(Request $request, $id)
    {
        $order = Order::find($id);
        $cc = DB::table('user_car_conditions')->where('order_id', $id)->first();
        if ($cc) {
            DB::table('user_car_conditions')->where('order_id', $id)->update([
                // 'car_condition' => $request->condition,
                'customer' => $request->customer,
                'contact_number' => $request->contact_number,
                'model' => $request->model,
                'number_plate' => $request->number_plate,
                'mileage' => $request->mileage,
                'vin' => $request->vin,
                'service_advisor' => $request->service_advisor,
                'techician' => $request->techician,
                'car_condition_date' => $request->car_condition_date,
                'car_condition_time' => $request->car_condition_time,
                'photos' => $request->photos,
                'front_end_body' => $request->front_end_body,
                'rear_end_body' => $request->rear_end_body,
                'driver_side_body' => $request->driver_side_body,
                'pass_side_body' => $request->pass_side_body,
                'roof' => $request->roof,
                'windshield' => $request->windshield,
                'window_glass' => $request->window_glass,
                'wheels_rim' => $request->wheels_rim,
                'fuel_tank_cover' => $request->fuel_tank_cover,
                'wing_cover' => $request->wing_cover,
                'horn_operation' => $request->horn_operation,
                'headlights' => $request->headlights,
                'front_wiper_blades' => $request->front_wiper_blades,
                'rear_wiper_blade' => $request->rear_wiper_blade,
                'tail_lights' => $request->tail_lights,
                'in_cabin' => $request->in_cabin,
                'system_check_lights' => $request->system_check_lights,
                'interior_comment' => $request->interior_comment,
                'engine_oil' => $request->engine_oil,
                'coolant' => $request->coolant,
                'power' => $request->power,
                'brake_fluid' => $request->brake_fluid,
                'windscreen' => $request->windscreen,
                'automatic' => $request->automatic,
                'cooling_system' => $request->cooling_system,
                'radiator_case' => $request->radiator_case,
                'engine_air' => $request->engine_air,
                'driver_belt' => $request->driver_belt,
                'under_hood_comment' => $request->under_hood_comment,
                'front_shocks' => $request->front_shocks,
                'drivershaft' => $request->drivershaft,
                'subframe' => $request->subframe,
                'fluid_leaks' => $request->fluid_leaks,
                'brake_hose' => $request->brake_hose,
                'real_shocks' => $request->real_shocks,
                'differential' => $request->differential,
                'exhuast' => $request->exhuast,
                'wheel_bearing' => $request->wheel_bearing,
                'under_vehicle_comment' => $request->under_vehicle_comment,
                'front_left_brake' => $request->front_left_brake,
                'right_left_brake' => $request->right_left_brake,
                'front_brake_disc' => $request->front_brake_disc,
                'front_right_brake' => $request->front_right_brake,
                'rear_right_brake_pads' => $request->rear_right_brake_pads,
                'rear_brake_disc' => $request->rear_brake_disc,
                'rear_right_brake_shoes' => $request->rear_right_brake_shoes,
                'rear_right_brake_cylinders' => $request->rear_right_brake_cylinders,
                'brake_condition_comment' => $request->brake_condition_comment,
                'battery_terminals' => $request->battery_terminals,
                'battery_capacity_test' => $request->battery_capacity_test,
                'battery_performance_comment' => $request->battery_performance_comment,
                'tyre_left_front' => $request->tyre_left_front,
                'tyre_right_front' => $request->tyre_right_front,
                'tyre_left_rear' => $request->tyre_left_rear,
                'tyre_right_rear' => $request->tyre_right_rear,
                'tyre_comment' => $request->tyre_comment
            ]);
        } else {
            DB::table('user_car_conditions')->insert([
                'user_id' => Auth::id(),
                'customer_id' => $order->user_id,
                'order_id' => $id,
                'workshop_id' => $order->seller_id,
                // 'car_condition' => $request->condition
                'customer' => $request->customer,
                'contact_number' => $request->contact_number,
                'model' => $request->model,
                'number_plate' => $request->number_plate,
                'mileage' => $request->mileage,
                'vin' => $request->vin,
                'service_advisor' => $request->service_advisor,
                'techician' => $request->techician,
                'car_condition_date' => $request->car_condition_date,
                'car_condition_time' => $request->car_condition_time,
                'photos' => $request->photos,
                'front_end_body' => $request->front_end_body,
                'rear_end_body' => $request->rear_end_body,
                'driver_side_body' => $request->driver_side_body,
                'pass_side_body' => $request->pass_side_body,
                'roof' => $request->roof,
                'windshield' => $request->windshield,
                'window_glass' => $request->window_glass,
                'wheels_rim' => $request->wheels_rim,
                'fuel_tank_cover' => $request->fuel_tank_cover,
                'wing_cover' => $request->wing_cover,
                'horn_operation' => $request->horn_operation,
                'headlights' => $request->headlights,
                'front_wiper_blades' => $request->front_wiper_blades,
                'rear_wiper_blade' => $request->rear_wiper_blade,
                'tail_lights' => $request->tail_lights,
                'in_cabin' => $request->in_cabin,
                'system_check_lights' => $request->system_check_lights,
                'interior_comment' => $request->interior_comment,
                'engine_oil' => $request->engine_oil,
                'coolant' => $request->coolant,
                'power' => $request->power,
                'brake_fluid' => $request->brake_fluid,
                'windscreen' => $request->windscreen,
                'automatic' => $request->automatic,
                'cooling_system' => $request->cooling_system,
                'radiator_case' => $request->radiator_case,
                'engine_air' => $request->engine_air,
                'driver_belt' => $request->driver_belt,
                'under_hood_comment' => $request->under_hood_comment,
                'front_shocks' => $request->front_shocks,
                'drivershaft' => $request->drivershaft,
                'subframe' => $request->subframe,
                'fluid_leaks' => $request->fluid_leaks,
                'brake_hose' => $request->brake_hose,
                'real_shocks' => $request->real_shocks,
                'differential' => $request->differential,
                'exhuast' => $request->exhuast,
                'wheel_bearing' => $request->wheel_bearing,
                'under_vehicle_comment' => $request->under_vehicle_comment,
                'front_left_brake' => $request->front_left_brake,
                'right_left_brake' => $request->right_left_brake,
                'front_brake_disc' => $request->front_brake_disc,
                'front_right_brake' => $request->front_right_brake,
                'rear_right_brake_pads' => $request->rear_right_brake_pads,
                'rear_brake_disc' => $request->rear_brake_disc,
                'rear_right_brake_shoes' => $request->rear_right_brake_shoes,
                'rear_right_brake_cylinders' => $request->rear_right_brake_cylinders,
                'brake_condition_comment' => $request->brake_condition_comment,
                'battery_terminals' => $request->battery_terminals,
                'battery_capacity_test' => $request->battery_capacity_test,
                'battery_performance_comment' => $request->battery_performance_comment,
                'tyre_left_front' => $request->tyre_left_front,
                'tyre_right_front' => $request->tyre_right_front,
                'tyre_left_rear' => $request->tyre_left_rear,
                'tyre_right_rear' => $request->tyre_right_rear,
                'tyre_comment' => $request->tyre_comment
            ]);
        }
        $order->update([
            'start_installation_status' => 1,
            // 'user_date_update' => 2
        ]);
        // Generate Notification
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'installation_alert',
            'body' => translate('Installation has started successfully'),
            'order_id' => $id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Installation has started successfully')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }

        flash(translate('Installation has started successfully'))->success();
        return redirect('dashboard');
    }

    public function CustomerList(Request $request)
    {
        $sort_search = null;
        if (Auth::user()->user_type == 'seller') {
            $conditions = DB::table('user_car_conditions')->where('user_id', Auth::id())->orderBy('id','desc');
            if ($request->has('search')) {
                $sort_search = $request->search;
                $conditions->where(function ($query) use ($sort_search) {
                        $query->where('number_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model', 'like', '%' . $sort_search . '%');
                    });
            }
            $conditions = $conditions->paginate(10);
        } else {
            $conditions = DB::table('user_car_conditions')->where('customer_id', Auth::id())->orderBy('id','desc');
            if ($request->has('search')) {
                $sort_search = $request->search;
                $conditions->where(function ($query) use ($sort_search) {
                        $query->where('number_plate', 'like', '%' . $sort_search . '%')
                        ->orWhere('model', 'like', '%' . $sort_search . '%');
                    });
            }
            $conditions = $conditions->paginate(10);
        }
        return view('frontend.user.car_condition', compact('conditions','sort_search'));
    }

    public function CustomerDetails(Request $request, $id)
    {
        $sort_by_red = $request->sort_by_red;
        $condition = DB::table('user_car_conditions')->where('id', $id)->first();
        return view('frontend.user.car_condition_details', compact('condition', 'sort_by_red'));
    }

    public function alertListOrder($id)
    {
        $condition = DB::table('user_car_conditions')->where('order_id', $id)->first();
        return view('frontend.user.alert_list_order_details', compact('condition'));
    }
}
