<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Order;

class EmergencyOrdersController extends Controller
{
    public function customerBatteryOrders(Request $request)
    {
        if ($request->user_id) {
            $timezone = user_timezone($request->user_id);
            $orders = DB::table('orders')->where('user_id', $request->user_id)->where('orders.order_type', 'B')
                ->orderBy('orders.code', 'desc')
                ->select('id', 'code', 'battery_type', 'created_at', 'delivery_status', 'grand_total', 'model_name')
                ->paginate(10)->appends(request()->query());

            $orders->getCollection()->transform(function ($order) use ($timezone) {
                $cancel_btn = false;
                $hourdiff = round((strtotime(now()) - strtotime($order->created_at))/3600, 1);
                if(!in_array($order->delivery_status, ['cancelled','Rejected','Done','completed', 'on_the_way']) && $hourdiff <= 2){
                    $cancel_btn = true;
                }
                return [
                    'id' => $order->id,
                    'code' => $order->code,
                    'date' => convert_datetime_to_local_timezone($order->created_at, $timezone),
                    'model_name' => $order->model_name,
                    'service_type' => ($order->battery_type == 'N') ? 'New Battery' : 'Jumpstart',
                    'amount' => single_price($order->grand_total),
                    'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                    'cancel_btn' => $cancel_btn
                ];
            });
            return response()->json([
                'result' => true,
                'data' => $orders
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'User id is missing.'
            ]);
        }
    }

    public function customerBatteryOrderDetails($order_id)
    {
        if ($order_id) {
            $order = Order::findOrFail($order_id);
            $timezone = user_timezone($order->user_id);
            $products_arr = $order->orderDetails->map(function ($orderDetail) use ($order, $timezone) {
                if ($order->battery_type == 'N') {
                    if ($orderDetail->batteryProduct != null) {
                        $name = $orderDetail->batteryProduct->name;
                    } else {
                        $name = translate('Battery Unavailable');
                    }
                } else {
                    $name = 'Jumpstart';
                }
                $warranty_end_date = ($order->battery_expiry_months && $order->warranty_activation_date) ? date(env('DATE_FORMAT'), strtotime("+" . $order->battery_expiry_months . " months", strtotime($order->warranty_activation_date))) : '';
                return [
                    'name' => $name,
                    'price' => single_price($orderDetail->price),
                    'warranty_start_date' => ($order->warranty_activation_date) ? convert_datetime_to_local_timezone(date('Y-m-d H:i:s', strtotime($order->warranty_activation_date)), $timezone) : '',
                    'warranty_end_date' => ($warranty_end_date != '') ? convert_datetime_to_local_timezone(date('Y-m-d H:i:s', strtotime($warranty_end_date)), $timezone) : '',
                ];
            });
			$order_address = ($order->location)?json_decode($order->location):[];
            $order_arr = [
                'code' => $order->code,
                'service_type' => ($order->battery_type == 'N') ? 'New Battery' : 'Jumpstart',
                'order_date' => $order->date ? convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), $timezone) : '',
                'schedule_time' => date(env('DATE_FORMAT').' h:i a', strtotime($order->order_schedule_time)),
                'order_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'total_order_amount' => single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')),
                'payment_method' => ucfirst(str_replace('_', ' ', $order->payment_type)),
                'car_model' => $order->model_name,
                'products' => $products_arr,
                'subtotal' => single_price($order->orderDetails->sum('price')),
                'coupon' => single_price($order->coupon_discount),
                'total' => single_price($order->grand_total),
                'location' => (!empty($order_address))?$order_address->loc:'',
                'arrival_mints' => $order->arrival_minutes.' min'
            ];
            return response()->json([
                'result' => true,
                'data' => $order_arr
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Order id is missing.'
            ]);
        }
    }

    public function customerTyreOrders(Request $request)
    {
        if ($request->user_id) {
            $timezone = user_timezone($request->user_id);
            $orders = DB::table('orders')->where('user_id', $request->user_id)->where('orders.order_type', 'T')
                ->orderBy('orders.code', 'desc')
                ->select('id', 'code', 'created_at', 'delivery_status', 'grand_total', 'model_name')
                ->paginate(10)->appends(request()->query());

            $orders->getCollection()->transform(function ($order) use ($timezone) {
                $cancel_btn = false;
                $hourdiff = round((strtotime(now()) - strtotime($order->created_at))/3600, 1);
                if(!in_array($order->delivery_status, ['cancelled','Rejected','Done','completed']) && $hourdiff <= 2){
                    $cancel_btn = true;
                }
                return [
                    'id' => $order->id,
                    'code' => $order->code,
                    'date' => convert_datetime_to_local_timezone($order->created_at, $timezone),
                    'model_name' => $order->model_name,
                    'amount' => single_price($order->grand_total),
                    'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                    'cancel_btn' => $cancel_btn
                ];
            });
            return response()->json([
                'result' => true,
                'data' => $orders
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'User id is missing.'
            ]);
        }
    }

    public function customerPetrolOrders(Request $request)
    {
        if ($request->user_id) {
            $timezone = user_timezone($request->user_id);
            $orders = DB::table('orders')->where('user_id', $request->user_id)->where('orders.order_type', 'P')
                ->orderBy('orders.code', 'desc')
                ->select('id', 'code', 'created_at', 'delivery_status', 'grand_total', 'model_name')
                ->paginate(10)->appends(request()->query());

            $orders->getCollection()->transform(function ($order) use ($timezone) {
                $cancel_btn = false;
                $hourdiff = round((strtotime(now()) - strtotime($order->created_at))/3600, 1);
                if(!in_array($order->delivery_status, ['cancelled','Rejected','Done','completed']) && $hourdiff <= 2){
                    $cancel_btn = true;
                }
                return [
                    'id' => $order->id,
                    'code' => $order->code,
                    'date' => convert_datetime_to_local_timezone($order->created_at, $timezone),
                    'model_name' => $order->model_name,
                    'amount' => single_price($order->grand_total),
                    'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                    'cancel_btn' => $cancel_btn
                ];
            });
            return response()->json([
                'result' => true,
                'data' => $orders
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'User id is missing.'
            ]);
        }
    }

    public function customerEmergencyOrderShow(Request $request)
    {
        if ($request->order_id) {
            $order = Order::findOrFail($request->order_id);
            $products_arr = $order->orderDetails->map(function ($orderDetail) use ($request) {
                if ($request->type == 'tyre') {
                    if ($orderDetail->tyreProduct != null) {
                        $name = $orderDetail->tyreProduct->name;
                    } else {
                        $name = 'Spare Tyre';
                    }
                } else {
                    if ($orderDetail->petrolProduct != null) {
                        $name = $orderDetail->petrolProduct->name;
                    } else {
                        $name = 'Petrol';
                    }
                }
                return [
                    'name' => $name,
                    'price' => single_price($orderDetail->price),
                ];
            });
            $order_address = ($order->location)?json_decode($order->location):[];
            $order_arr = [
                'code' => $order->code,
                'order_date' => $order->date ? convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($order->user_id)) : '',
                'schedule_time' => date(env('DATE_FORMAT').' h:i a', strtotime($order->order_schedule_time)),
                'order_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'total_order_amount' => single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')),
                'payment_method' => ucfirst(str_replace('_', ' ', $order->payment_type)),
                'car_model' => $order->model_name,
                'products' => $products_arr,
                'subtotal' => single_price($order->orderDetails->sum('price')),
                'coupon' => single_price($order->coupon_discount),
                'total' => single_price($order->grand_total),
                'location' => (!empty($order_address))?$order_address->loc:'',
                'arrival_mints' => $order->arrival_minutes.' min'
            ];
            return response()->json([
                'result' => true,
                'data' => $order_arr
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Order id is missing.'
            ]);
        }
    }

    public function invoice_download($order_id, $type = null)
    {
        $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        $language_code = Session::get('locale', Config::get('app.locale'));

        if (\App\Models\Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $text_align = 'right';
            $not_text_align = 'left';
        } else {
            $direction = 'ltr';
            $text_align = 'left';
            $not_text_align = 'right';
        }

        if ($currency_code == 'BDT' || $language_code == 'bd') {
            // bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        } elseif ($currency_code == 'KHR' || $language_code == 'kh') {
            // khmer font
            $font_family = "'Hanuman','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
        } elseif ($currency_code == 'ILS') {
            // Israeli font
            $font_family = "'Varela Round','sans-serif'";
        } elseif ($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD') {
            // middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        } else {
            // general for all
            $font_family = "'Roboto','sans-serif'";
        }

        $order = Order::findOrFail($order_id);
        $html = view('backend.invoices.emergency-order-invoice', [
            'order' => $order,
            'type' => $type,
            'font_family' => $font_family,
            'direction' => $direction,
            'text_align' => $text_align,
            'not_text_align' => $not_text_align
        ])->render();

        return response()->json([
            'result' => true,
            'pdf_name' => 'order-' . $order->code,
            'htmlCode' => $html,
        ]);
    }
}
