<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\CarModel;
use App\Models\Upload;
use App\Models\Order;
use App\Models\Shop;
use App\User;
use Hash;

class WorkshopController extends Controller
{
    public function dashboard($user_id)
    {
        if ($user_id) {
            $shop = DB::table('shops')->where('user_id', $user_id)->first();
            $orders_count = DB::table('orders')->where('order_type', 'N')->where('seller_id', $shop->id)->selectRaw("
            COUNT(*) AS all_orders,
            COUNT(CASE start_installation_status WHEN 1 THEN 1 END) AS start_installation_orders,
            COUNT(CASE user_date_update WHEN 1 THEN 1 END) AS updated_date_orders
            ")->first();

            return response()->json([
                'result' => true,
                'total_orders' => $orders_count->all_orders,
                'installation_list' => $orders_count->start_installation_orders,
                'updated_date_orders' => $orders_count->updated_date_orders,
                'car_condition_list' => DB::table('user_car_conditions')->where('user_id', $user_id)->count(),
                'total_notifications' => DB::table('notifications')->where('user_id', $user_id)->where('is_viewed', 0)->count()
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'You are logged out from app please login again.'
            ]);
        }
    }

    public function orders(Request $request, $user_id)
    {
        if ($user_id) {
            $shop = Shop::where('user_id', $user_id)->first();
            $date = ($request->date) ? $request->date : '';
            $orders = DB::table('orders')
                ->orderBy('id', 'desc')
                ->where('seller_id', $shop->id)->where('user_date_update', '!=', 1)
                ->where('order_type','N')
                ->select('orders.id')
                ->distinct();
            if ($date != '') {
                $exploded_date = explode(" to ", $date);
                $orders = $orders->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
            }
            $orders = $orders->get();
            foreach ($orders as $key => $value) {
                $order = Order::find($value->id);
                $order->viewed = 1;
                $order->save();
            }
            $orders_arr = $orders->map(function ($order_id) {
                $order = Order::find($order_id->id);
                $model = CarModel::where('id', $order->model_id)->first();
                return [
                    'car_model' => $model ? $model->name : 'N/A',
                    'car_plate' => $order->car_plate ? $order->car_plate : '',
                    'order_id' => $order->id,
                    'corder_code' => $order->code,
                    'customer' => ($order->user_id != null) ? $order->user->name : '',
                    'amount' => single_price($order->grand_total),
                    'delivery_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                ];
            });
            return response()->json([
                'result' => true,
                'orders' => $orders_arr,
                'date' => $date
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'You are logged out from app please login again.'
            ]);
        }
    }

    public function orderDetails($order_id)
    {
        $order = Order::findOrFail($order_id);
        if ($order) {
            if ($order->model_id) {
                $model = CarModel::where('id', $order->model_id)->first();
            }
        $tyre_products = DB::table('order_details')
        ->where('order_details.order_id', $order_id)
        ->where('order_details.type', 'T')
        ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
        ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
        ->select('order_details.product_id','product_translations.name', 'order_details.quantity', 'order_details.price')
        ->get();
        
        $tyre_products_arr = $tyre_products->map(function ($tyre_product) {
            $product_name_with_choice = ($tyre_product->name != null) ? $tyre_product->name : translate('Product Unavailable');
            return [
                'product_id' => $tyre_product->product_id,
                'product_name' => $product_name_with_choice,
                'quantity' => $tyre_product->quantity,
                'price' => single_price($tyre_product->price),
                'package_name' => ''
            ];
        });
        
        $package_products = DB::table('order_details')
            ->where('order_details.order_id', $order_id)
            ->where('order_details.type', 'P')
            ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('order_details.product_id', 'product_translations.name', 'order_details.quantity', 'order_details.price')
            ->get();
            $package_products_arr = $package_products->map(function ($package_product) {
                return [
                    'product_id' => $package_product->product_id,
                    'product_name' => ($package_product->name != null) ? $package_product->name : translate('Product Unavailable'),
                    'quantity' => $package_product->quantity,
                    'price' => single_price($package_product->price),
                    'package_name' => translate('Package')
                ];
        });
        
            $gifts_arr = [];
            if($order->is_gift_product_availed){
            $gift_datas = json_decode($order->gift_product_data);
                $data = [
                    'gift_title' => $gift_datas->discount_title,
                    'gift_name' => $gift_datas->gift_name,
                    'gift_image' => api_asset($gift_datas->gift_image)
                ];
                array_push($gifts_arr,$data);
            }
            $gift_discount_data = json_decode($order->gift_discount_data);
            $old_shop = DB::table('shops')
            ->where('id', $order->old_workshop_id)
            ->select('name')
            ->first();
            $old_shop_reassign_data = $order->reassign_data?json_decode($order->reassign_data, true):[];
            $old_shop_app_date = '';
            $old_shop_app_time = '';
            if(!empty($old_shop_reassign_data)){
                $old_shop_app_date = date(env('DATE_FORMAT'), strtotime($old_shop_reassign_data['old_workshop_date']));
                $old_shop_app_time = $old_shop_reassign_data['old_workshop_time'];
            }
            $timezone = user_timezone($order->orderDetails->first()->seller_id);
            $data = [
                'order_code' => $order->code,
                'is_user_date_update' => $order->user_date_update,
                'old_shop_name' => ($old_shop) ? $old_shop->name : '',
                'reassign_date' => ($order->reassign_date)?convert_datetime_to_local_timezone($order->reassign_date, $timezone):'',
                'old_shop_appointment_date' => $old_shop_app_date,
                'old_shop_appointment_time' => $old_shop_app_time,
                'old_appointment_date' => date(env('DATE_FORMAT'), strtotime($order->old_workshop_date)),
                'old_appointment_time' => $order->old_workshop_time,
                'appointment_date' => date(env('DATE_FORMAT'), strtotime($order->workshop_date)),
                'appointment_time' => $order->workshop_time,
                'email' => ($order->user_id != null) ? $order->user->email : '',
                'car_model' => (isset($model)) ? $model->name : '',
                'car_plate' => ($order->car_plate) ? $order->car_plate : '',
                'order_date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), $timezone),
                'delivery_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'total_order_amount' => single_price($order->grand_total),
                'payment_method' => ucfirst(str_replace('_', ' ', $order->payment_type)),
                'tyre_order_details' => $tyre_products_arr,
                'package_order_details' => $package_products_arr,
                'gifts_arr' => $gifts_arr,
                'subtotal' => single_price($order->orderDetails->sum('price')),
                'coupon' => single_price($order->coupon_discount),
                'is_gift_discount_applied' => $order->is_gift_discount_applied,
                'discount_title' => ($order->is_gift_discount_applied)?$gift_discount_data->title:'',
                'gift_discount' => ($order->is_gift_discount_applied)?single_price($gift_discount_data->discount):'',
                'is_express_delivery' => ($order->express_delivery) ? true : false,
                'express_delivery' => single_price($order->express_delivery),
                'total' => single_price($order->grand_total)
            ];
            return response()->json([
                'result' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'No order found.'
            ]);
        }
    }

    public function CarConditionList($user_id, Request $request)
    {
        if ($user_id) {
            $conditions = DB::table('user_car_conditions')->where('user_id', $user_id)->get();
            $conditions_arr = $conditions->map(function ($condition) {
                $shop = Shop::where('id', $condition->workshop_id)->first();
                return [
                    'id' => $condition->id,
                    'car_model' => $condition->model ? $condition->model : '',
                    'car_plate' => $condition->number_plate ? $condition->number_plate : '',
                    'shop_name' => $shop ? $shop->name : '--'
                ];
            });
            return response()->json([
                'result' => true,
                'data' => $conditions_arr
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'You are logged out from app please login again.'
            ]);
        }
    }

    public function installationList(Request $request, $user_id)
    {
        if ($user_id) {
            $shop = DB::table('shops')->where('user_id', $user_id)->first();
            $orders = Order::where('order_type','N')->where('start_installation_status', 1)->where('seller_id', $shop->id)->orderBy('id', 'desc')->get();
            $orders_arr = $orders->map(function ($order) {
                $button1 = [
                    'text' => '',
                    'action' => ''
                ];
                $button2 = [
                    'text' => '',
                    'action' => ''
                ];
                $button3 = [
                    'text' => '',
                    'action' => ''
                ];
                $button4 = [
                    'text' => '',
                    'action' => ''
                ];
                if ($order->done_installation_status == 2 || $order->done_installation_status == 1) {
                    $button1 = [
                        'text' => 'Already Done',
                        'action' => ''
                    ];
                } else {
                    if ($order->notify_user_come_to_workshop_to_review_car == 1 || $order->notify_user_come_to_workshop_to_review_car == 2) {
                        $button2 = [
                            'text' => 'Notified',
                            'action' => ''
                        ];
                    } else {
                        $button3 = [
                            'text' => 'Notify user come to workshop to review car',
                            'action' => url('api/v2/workshop/notify-user-come-to-workshop/' . $order->id)
                        ];
                    }
                    $button4 = [
                        'text' => 'Waiting for user to rate this order',
                        'action' => ''
                    ];
                }
                return [
                    'model_name' => $order->model_name,
                    'car_plate' => $order->car_plate ? $order->car_plate : '--',
                    'order_code' => $order->code,
                    'order_id' => $order->id,
                    'customer' => ($order->user_id != null) ? $order->user->name : '',
                    'amount' => single_price($order->grand_total),
                    'button1' => $button1,
                    'button2' => $button2,
                    'button3' => $button3,
                    'button4' => $button4
                ];
            });
            return response()->json([
                'result' => true,
                'data' => $orders_arr
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'User id is missing.'
            ]);
        }
    }

    public function notifyUserComeToWorkshop($order_id)
    {
        if ($order_id) {
            $order = Order::find($order_id);
            $order->notify_user_come_to_workshop_to_review_car = 1;
            $order->update();

            // Generate Notification
            \App\Models\Notification::create([
                'user_id' => $order->user_id,
                'is_admin' => 3,
                'type' => 'review_car',
                'body' => translate('Please come to workshop and review your car'),
                'order_id' => $order_id,
            ]);
            try {
                // Send firebase notification
                $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
                $array = array(
                    'device_token' => $device_token,
                    'title' => translate('Please come to workshop and review your car')
                );
                send_firebase_notification($array);
            } catch (\Exception $e) {}

            return response()->json([
                'result' => true,
                'message' => 'Done notifying.'
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Order id is missing.'
            ]);
        }
    }

    public function showOrderAfterQRScan($order_id, $type = null)
    {
        if ($order_id) {
            $order = Order::where('id', $order_id)->first();
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetails[] = $orderDetail->received_status;
            }
            
            $tyre_products = DB::table('order_details')
            ->where('order_details.order_id', $order_id)
            ->where('order_details.type', 'T')
            ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('order_details.product_id','product_translations.name', 'order_details.quantity', 'products.thumbnail_img','order_details.received_status','order_details.id')
            ->get();
            $package_products = DB::table('order_details')
            ->where('order_details.order_id', $order_id)
            ->where('order_details.type', 'P')
            ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('order_details.product_id','product_translations.name', 'order_details.quantity', 'products.thumbnail_img','order_details.received_status','order_details.id')
            ->get();
            $tyre_products_arr = $tyre_products->map(function ($orderDetail) use($order) {
                if($orderDetail->received_status == 'Received'){
                    $status = $orderDetail->received_status;
                    $button = [
                    'text' => '',
                    'action' => ''
                ];
                }
                else if($order->delivery_status == 'Rejected'){
                    $status = $order->delivery_status;
                    $button = [
                    'text' => '',
                    'action' => ''
                ];
                }
                else{
                    $status = '';
                    $button = [
                    'text' => 'Receive Now',
                    'action' => url('api/v2/workshop/received-order-item', $orderDetail->id)
                ];
                }
                return [
                    'product_id' => $orderDetail->product_id,
                    'image' => $orderDetail->thumbnail_img != null ? api_asset($orderDetail->thumbnail_img) : translate('N/A'),
                    'product_name' => $orderDetail->name != null ? $orderDetail->name : translate('Product Unavailable'),
                    'quantity' => $orderDetail->quantity,
                    'status' =>  $status,
                    'button' => $button,
                    'package_name' => ''
                ];
            });
            $package_products_arr = $package_products->map(function ($orderDetail) use($order) {
                if($orderDetail->received_status == 'Received'){
                    $status = $orderDetail->received_status;
                    $button = [
                    'text' => '',
                    'action' => ''
                ];
                }
                else if($order->delivery_status == 'Rejected'){
                    $status = $order->delivery_status;
                    $button = [
                    'text' => '',
                    'action' => ''
                ];
                }
                else{
                    $status = '';
                    $button = [
                    'text' => 'Receive Now',
                    'action' => url('api/v2/workshop/received-order-item', $orderDetail->id)
                ];
                }
                return [
                    'product_id' => $orderDetail->product_id,
                    'image' => $orderDetail->thumbnail_img != null ? api_asset($orderDetail->thumbnail_img) : translate('N/A'),
                    'product_name' => $orderDetail->name != null ? $orderDetail->name : translate('Product Unavailable'),
                    'quantity' => $orderDetail->quantity,
                    'status' =>  $status,
                    'button' => $button,
                    'package_name' => translate('Package')
                ];
            });
            $order_arr = [
                'order_id' => $order->id,
                'delivery_status' => $order->delivery_status,
                'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'notify_user_to_workshop_btn' => (!in_array(null, $orderDetails)) ? 'yes' : 'no',
                'order_code' => $order->code,
                'order_date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($order->orderDetails->first()->seller_id)),
                'payment_method' => ucfirst(str_replace('_', ' ', $order->payment_type)),
                'tyre_products' => $tyre_products_arr,
                'package_products' => $package_products_arr
            ];
            
            return response()->json([
                'result' => true,
                'order' => $order_arr
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Order id is missing.'
            ]);
        }
    }

    public function receivedOrder($order_id, $user_id)
    {
        OrderDetail::where('id', $order_id)->update([
            'received_status' => 'Received',
            'received_by' => $user_id
        ]);
        return response()->json([
            'result' => true,
            'message' => 'Action performed successfully.'
        ]);
    }

    public function confirmOrder($order_id)
    {
        $order = Order::where('id', $order_id)->first();
        // Generate Notification
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'notify_user',
            'body' => translate('The order has reached to workshop'),
            'order_id' => $order_id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('The order has reached to workshop')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        $order->delivery_status = 'Confirmed';
        $order->save();

        return response()->json([
            'result' => true,
            'message' => 'Done Successfully!'
        ]);
    }

    public function rejectOrder(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $order->delivery_status = 'Rejected';
        $order->reason = $request->reason;
        $order->save();
        return response()->json([
            'result' => true,
            'message' => 'Rejected Successfully!'
        ]);
    }

    public function showUserOrder($customer_id, $order_id, $user_id)
    {
        $user = User::where('id', $customer_id)->first();
        $order = Order::where('id', $order_id)->first();
        $chk_shop = DB::table('shops')->where('user_id', $user_id)->first();
        if ($chk_shop->id == $order->seller_id) {
            $data = DB::table('car_lists')->where('user_id', $order->user_id)->first();
            $tyre_products = DB::table('order_details')
            ->where('order_details.order_id', $order_id)
            ->where('order_details.type', 'T')
            ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('order_details.product_id','product_translations.name', 'order_details.quantity', 'products.thumbnail_img')
            ->get();
            $package_products = DB::table('order_details')
            ->where('order_details.order_id', $order_id)
            ->where('order_details.type', 'P')
            ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('order_details.product_id', 'product_translations.name', 'order_details.quantity', 'products.thumbnail_img')
            ->get();
            $tyre_products_arr = $tyre_products->map(function ($orderDetail) {
                return [
                    'product_id' => $orderDetail->product_id,
                    'image' => $orderDetail->thumbnail_img != null ? uploaded_asset($orderDetail->thumbnail_img) : translate('N/A'),
                    'product_name' => $orderDetail->name != null ? $orderDetail->name : translate('Product Unavailable'),
                    'quantity' => $orderDetail->quantity?$orderDetail->quantity:0,
                    'package_name' => ''
                ];
            });
            $package_products_arr = $package_products->map(function ($orderDetail) {
                return [
                    'product_id' => $orderDetail->product_id,
                    'image' => $orderDetail->thumbnail_img != null ? uploaded_asset($orderDetail->thumbnail_img) : translate('N/A'),
                    'product_name' => $orderDetail->name != null ? $orderDetail->name : translate('Product Unavailable'),
                    'quantity' => $orderDetail->quantity?$orderDetail->quantity:0,
                    'package_name' => translate('Package')
                ];
            });
            $order_data = [
                'delivery_status' => $order->delivery_status,
                'order_id' => $order->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'order_code' => $order->code,
                'print_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'order_date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($user_id)),
                'payment_method' => ucfirst(str_replace('_', ' ', $order->payment_type)),
                'user_phone' => $user->phone?$user->phone:'',
                'model' => $order->model_name,
                'car_plate' => $order->car_plate,
                'mileage' => (isset($data) && $data->mileage) ? $data->mileage : '',
                'tyre_products' => $tyre_products_arr,
                'package_products' => $package_products_arr
            ];
            return response()->json([
                'result' => true,
                'data' => $order_data
            ]);
        } else {
            // Generate Notification
            \App\Models\Notification::create([
                'user_id' => $order->user_id,
                'is_admin' => 3,
                'type' => 'notify_address',
                'body' => translate('The order address has been changed'),
                'order_id' => $order_id,
            ]);
            try {
                // Send firebase notification
                $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
                $array = array(
                    'device_token' => $device_token,
                    'title' => translate('The order address has been changed')
                );
                send_firebase_notification($array);
            } catch (\Exception $e) {
                // dd($e);
            }
            return response()->json([
                'result' => false,
                'message' => 'User Not Matched To Workshop!'
            ]);
        }
    }

    public function saveCarCondition(Request $request, $order_id, $user_id)
    {
        $order = Order::find($order_id);
        $cc = DB::table('user_car_conditions')->where('order_id', $order_id)->first();
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
        );
        $dir = public_path('uploads/all/');
        if ($cc) {
            if ($request->hasfile('image')) {
                $files_id_arr = [];
                $files = $request->file('image');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = str_replace(" ", "-", rand(10000000000, 9999999999) . date("YmdHis") . $file->getClientOriginalName());

                    $upload = new Upload();
                    $size = $file->getSize();

                    if (!isset($type[$extension])) {
                        return response()->json([
                            'result' => false,
                            'message' => "Only image can be uploaded"
                        ]);
                    }

                    $newPath = "uploads/all/$filename";
                    if (env('FILESYSTEM_DRIVER') == 's3') {
                        Storage::disk('s3')->put($newPath, file_get_contents(base_path('public/') . $newPath));
                    } else {
                        $file->move($dir, $filename);
                    }

                    $upload->file_original_name = 'Installation_list';
                    $upload->extension = $extension;
                    $upload->file_name = 'uploads/all/' . $filename;
                    $upload->user_id = $user_id;
                    $upload->type = $type[$upload->extension];
                    $upload->file_size = $size;
                    $upload->save();

                    array_push($files_id_arr, $upload->id);
                }
                $photos = implode(',', $files_id_arr);
            } else {
                $photos = $cc->photos;
            }

            DB::table('user_car_conditions')->where('order_id', $order_id)->update([
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
                'photos' => $photos,
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
            if ($request->hasfile('image')) {
                $files_id_arr = [];
                $files = $request->file('image');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = str_replace(" ", "-", rand(10000000000, 9999999999) . date("YmdHis") . $file->getClientOriginalName());

                    $upload = new Upload;
                    $size = $file->getSize();

                    if (!isset($type[$extension])) {
                        return response()->json([
                            'result' => false,
                            'message' => "Only image can be uploaded"
                        ]);
                    }

                    $newPath = "uploads/all/$filename";
                    if (env('FILESYSTEM_DRIVER') == 's3') {
                        Storage::disk('s3')->put($newPath, file_get_contents(base_path('public/') . $newPath));
                    } else {
                        $file->move($dir, $filename);
                    }

                    $upload->file_original_name = 'Installation_list';
                    $upload->extension = $extension;
                    $upload->file_name = 'uploads/all/' . $filename;
                    $upload->user_id = $user_id;
                    $upload->type = $type[$upload->extension];
                    $upload->file_size = $size;
                    $upload->save();

                    array_push($files_id_arr, $upload->id);
                }
                $photos = implode(',', $files_id_arr);
            } else {
                $photos = '';
            }
            DB::table('user_car_conditions')->insert([
                'user_id' => $user_id,
                'customer_id' => $order->user_id,
                'order_id' => $order_id,
                'carlist_id' => $order->carlist_id,
                'workshop_id' => $order->seller_id,
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
                'photos' => $photos,
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
        ]);
        // Generate Notification
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'view_order',
            'body' => translate('Installation has started successfully'),
            'order_id' => $order_id,
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
        return response()->json([
            'result' => true,
            'message' => 'Installation started successfully'
        ]);
    }

    public function profileUpdate(Request $request, $user_id)
    {
        $email_exists = User::where('email', $request->email)->where('id', '!=', $user_id)->first();
        if ($email_exists) {
            return response()->json([
                'result' => false,
                'message' => 'Email already exists!',
            ]);
        }
        $user = User::find($user_id);
        if ($request->hasfile('photo')) {
            $type = array(
                "jpg" => "image",
                "jpeg" => "image",
                "png" => "image",
                "svg" => "image",
                "webp" => "image",
                "gif" => "image",
            );
            $dir = public_path('uploads/all/');
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = str_replace(" ", "-", rand(10000000000, 9999999999) . date("YmdHis") . $file->getClientOriginalName());

            $upload = new Upload;
            $size = $file->getSize();

            if (!isset($type[$extension])) {
                return response()->json([
                    'result' => false,
                    'message' => "Only image can be uploaded"
                ]);
            }

            $newPath = "uploads/all/$filename";
            if (env('FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->put($newPath, file_get_contents(base_path('public/') . $newPath));
            } else {
                $file->move($dir, $filename);
            }

            $upload->file_original_name = 'profile';
            $upload->extension = $extension;
            $upload->file_name = 'uploads/all/' . $filename;
            $upload->user_id = $user_id;
            $upload->type = $type[$upload->extension];
            $upload->file_size = $size;
            $upload->save();

            $photo = $upload->id;
        } else {
            $photo = $user->avatar_original;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->new_password != "" && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $photo;

        $seller = $user->seller;
        $seller->bank_name = $request->bank_name;
        $seller->bank_acc_name = $request->bank_acc_name;
        $seller->bank_acc_no = $request->bank_acc_no;
        $seller->save();

        if ($user->save()) {
            return response()->json([
                'result' => true,
                'message' => 'Your Profile has been updated successfully!',
            ]);
        }
        return response()->json([
            'result' => false,
            'message' => 'Sorry! Something went wrong.',
        ]);
    }

    public function feedbacks(Request $request, $user_id)
    {
        $reviews = DB::table('rating_orders as ro')
        ->where('ro.seller_id', $user_id)
        ->leftJoin('users','users.id','ro.user_id')
        ->leftJoin('orders as o','o.id','ro.order_id')
        ->select('users.name as customer_name','o.car_plate','o.model_name as car_model','o.code','ro.description','ro.score as rating','ro.id')
        ->get();
        
        return response()->json([
            'result' => true,
            'feedbacks' => $reviews
        ]);
    }

    public function deleteCustomerFeedback($feedback_id)
    {
        DB::table('rating_orders')->where('id', $feedback_id)->delete();
        return response()->json([
            'result' => true,
            'message' => 'Feedback deleted successfully.'
        ]);
    }

    public function updatedDateOrders(Request $request, $user_id)
    {
        $shop = Shop::where('user_id', $user_id)->first();
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->where('seller_id', $shop->id)->where('user_date_update', 1)
            ->select('orders.id')
            ->where('order_type','N')
            ->distinct()
            ->get();

        foreach ($orders as $key => $value) {
            $order = Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }
        $orders_arr = $orders->map(function ($order_id) {
            $order = Order::find($order_id->id);
            return [
                'id' => $order->id,
                'car_model' => $order->model_name ? $order->model_name : '',
                'car_plate' => $order->car_plate ? $order->car_plate : '',
                'order_code' => $order->code ? $order->code : '',
                'customer' =>  $order->user_id != null ? $order->user->name : '',
                'amount' => single_price($order->grand_total),
                'booking_date' => $order->workshop_date ? $order->workshop_date : '',
                'booking_time' => $order->workshop_time ? $order->workshop_time : '',
                'workshop_date_approve_status' => $order->workshop_date_approve_status
            ];
        });
        return response()->json([
            'result' => true,
            'orders' => $orders_arr
        ]);
    }

    public function approveDateStatus($order_id)
    {
        $order = Order::find($order_id);
        $order->workshop_date_approve_status = 1;
        $order->update();

        // Generate Notification
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'order_reschedule_approve',
            'body' => translate('Your request of order reschedule has been approved by workshop'),
            'order_id' => $order_id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Your request of order reschedule has been approved by workshop')
            );
            send_firebase_notification($array);
            } catch (\Exception $e) {
                // dd($e);
            }
        return response()->json([
            'result' => true,
            'message' => 'Reschedule request has been Approved Successfully!'
        ]);
    }
}
