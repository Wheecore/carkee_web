<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CarList;
use App\Models\CarModel;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Review;
use App\User;
use App\Models\Order;
use App\Models\Addon;
use App\Models\AffiliateConfig;
use App\Models\Battery;
use App\Models\BatteryActivationImage;
use App\Models\CarWashPayment;
use App\Models\CarWashProduct;
use App\Models\MerchantVoucher;
use App\Models\OrderDetail;
use App\Models\Package;
use App\Models\QrcodeDownloadHistory;
use App\Models\Upload;
use App\Models\WorkshopAvailability;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Models\Customer;


class CustomerController extends Controller
{
    public function dashboard($user_id)
    {
        if ($user_id) {
            $car_lists = DB::table('car_lists')
            ->leftJoin('brands', 'brands.id', '=', 'car_lists.brand_id')
            ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
            ->select('brands.name as brand_name', 'car_models.name as model_name', 'car_lists.id', 'car_lists.image')
            ->where('car_lists.user_id', $user_id)
            ->orderBy('car_lists.id', 'desc')
            ->get();

            $car_lists_arr = $car_lists->map(function($list){
                return [
                    'id' => $list->id,
                    'car_plate' => '',
                    'brand_id' => 0,
                    'model_id' => 0,
                    'year_id' => 0,
                    'variant_id' => 0,
                    'brand_name' => $list->brand_name,
                    'model_name' => $list->model_name,
                    'year_name' => '',
                    'variant_name' => '',
                    'image' => api_asset($list->image)
                ];
            });
            return response()->json([
                'result' => true,
                'list_data' => $car_lists_arr,
                'total_notifications' => DB::table('notifications')->where('user_id', $user_id)->where('is_viewed', 0)->count()
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'You are logged out from app please login again.'
            ]);
        }
    }

    public function get_vehicle_data($vehicle_id)
    {
        $car_list = DB::table('car_lists')
        ->leftJoin('brands', 'brands.id', '=', 'car_lists.brand_id')
        ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
        ->leftJoin('car_years', 'car_years.id', '=', 'car_lists.year_id')
        ->leftJoin('car_variants', 'car_variants.id', '=', 'car_lists.variant_id')
        ->select('brands.name as brand_name', 'car_models.name as model_name','car_years.name as year_name','car_variants.name as variant_name',
        'car_lists.id', 'car_lists.image','car_lists.car_plate','car_lists.brand_id',
        'car_lists.model_id','car_lists.year_id','car_lists.variant_id')
        ->where('car_lists.id', $vehicle_id)
        ->first();
        $car_list_arr = [
            'id' => $car_list->id,
            'car_plate' => $car_list->car_plate,
            'brand_id' => $car_list->brand_id ? $car_list->brand_id : 0,
            'model_id' => $car_list->model_id ? $car_list->model_id : 0,
            'year_id' => $car_list->year_id ? $car_list->year_id : 0,
            'variant_id' => $car_list->variant_id ? $car_list->variant_id : 0,
            'brand_name' => $car_list->brand_name,
            'model_name' => $car_list->model_name,
            'year_name' => $car_list->year_name,
            'variant_name' => $car_list->variant_name,
            'image' => api_asset($car_list->image)
        ];
        $on_going_orders = Order::where('orders.carlist_id', $vehicle_id)
        ->where('orders.payment_status', 'paid')
        ->where('orders.start_installation_status', 1)
        ->whereIn('orders.delivery_status',['pending','picked_up','on_the_way','delivered','Confirmed'])
        ->leftJoin('brands', 'brands.id','orders.brand_id')
        ->select('orders.model_name','orders.car_plate','orders.order_type','brands.name','orders.seller_id')
        ->get();
        $on_going_orders_arr = $on_going_orders->map(function($data){
                if($data->order_type == 'N'){
                    $name = 'Services';
                    $shop = DB::table('shops')->where('id', $data->seller_id)->select('name')->first();
                    $shop = $shop?$shop->name:'';
                }
                else if($data->order_type == 'CW'){
                    $name = 'Car Wash';
                    $shop = 'Car wash service center';
                }
                else{
                $name = 'Emergency Services';
                $shop = 'Emergency service center';
                }
                $category_logo = DB::table('categories')->where('name', $name)->select('icon')->first();
                return [
                    'logo' => api_asset($category_logo->icon),
                    'shop' => $shop,
                    'brand' => $data->name,
                    'model' => $data->model_name,
                    'car_plate' => $data->car_plate
                ];
        });
        return response()->json([
            'vehicle_data' => $car_list_arr,
            'on_going_orders' => $on_going_orders_arr
        ]);
    }

    public function notifications($user_id)
    {
        $timezone = user_timezone($user_id);
        $notifications = DB::table('notifications as n')
            ->leftjoin('orders as o', 'o.id', '=', 'n.order_id')
            ->select('n.id', 'n.order_id', 'n.type', 'n.body', 'n.created_at', 'n.availability_request_id', 'o.workshop_date', 'o.code', 'n.is_viewed', 'o.order_type')
            ->where('n.user_id', $user_id)
            ->orderBy('n.id', 'DESC')
            ->get()
            ->toArray();

        $notifications_data = [];
        foreach ($notifications as $notification) {
            switch ($notification->order_type) {
                case 'CW':
                    $order_type = 'CW';
                    break;
                case 'B':
                    $order_type = 'Battery';
                    break;
                case 'P':
                    $order_type = 'Petrol';
                    break;
                case 'T':
                    $order_type = 'Tyre';
                    break;
                default:
                    $order_type = 'N';
                    break;
            }
            switch ($notification->type) {
                case 'reassign':
                    $html = $notification->body . ' - ';
                    $chk_time = DB::table('availability_requests')->select('from_time', 'to_time', 'previous_from_time', 'previous_to_time')->where('date', date('Y/m/d', strtotime($notification->workshop_date)))->orderBy('id', 'desc')->first();
                    if ($chk_time && $chk_time->from_time && $chk_time->to_time) {
                        $html .= '(Shop Time is Changed From' . \Carbon\Carbon::parse($chk_time->previous_from_time)->format('h: i a') . '--' . \Carbon\Carbon::parse($chk_time->previous_to_time)->format('h: i a') . ' to ' . \Carbon\Carbon::parse($chk_time->from_time)->format('h: i a') . '--' . \Carbon\Carbon::parse($chk_time->to_time)->format('h: i a') . ')';
                    } else {
                        $html .= '(Shop Will be Closed on ' . $notification->workshop_date . ')';
                    }

                    $notifications_data[] = array(
                        'order_id' => $notification->order_id,
                        'order_code' => $notification->code,
                        'date' => convert_datetime_to_local_timezone_for_notification($notification->created_at, $timezone),
                        'text' => $html,
                        'type' => 'reassign',
                        'seen' => $notification->is_viewed,
                        'id' => $notification->id,
                        'order_type' => $order_type,
                        'availability_request_id' => $notification->availability_request_id
                    );
                    break;
                default:
                    $notifications_data[] = array(
                        'order_id' => $notification->order_id,
                        'order_code' => $notification->code,
                        'date' => convert_datetime_to_local_timezone_for_notification($notification->created_at, $timezone),
                        'text' => $notification->body,
                        'type' => $notification->type,
                        'seen' => $notification->is_viewed,
                        'id' => $notification->id,
                        'order_type' => $order_type,
                        'availability_request_id' => $notification->availability_request_id
                    );
                    break;
            }
        }

        return response()->json([
            'result' => true,
            'total_notifications' => count($notifications),
            'notifications' => $notifications_data
        ]);
    }

    public function notification_seen($id)
    {
        DB::table('notifications')->where('id', $id)->update(['is_viewed' => 1]);
        return response()->json(['result' => true]);
    }

    public function user_address($order_id)
    {
        if ($order_id) {
            $order = Order::where('id', $order_id)->first();
            $user = User::where('id', $order->user_id)->first();
            $shop = DB::table('shops')->where('id', $order->seller_id)->first();
            return response()->json([
                'result' => true,
                'workshop_name' => $shop?$shop->name:'',
                'workshop_address' => $shop?$shop->address:'',
                'user_name' => $user->name,
                'user_email' => $user->email,
                'order_code' => $order->code,
                'order_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'order_date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($order->user_id)),
                'payment_type' => ucfirst(str_replace('_', ' ', $order->payment_type))
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Order id is missing'
            ]);
        }
    }

    public function ViewAgain($qrcode_id)
    {
        $voucher = QrcodeDownloadHistory::find($qrcode_id);
        return response()->json([
            'result' => true,
            'qrcode_path' => url('public/qr-codes/'.$voucher->image_name)
        ]);
    }

    public function referralUrl($user_id)
    {
        $user = User::find($user_id);
        $affiliate_system = Addon::where('unique_identifier', 'affiliate_system')->select('activated')->first();
        if ($affiliate_system != null && $affiliate_system->activated && \App\Models\AffiliateConfig::where('status', 1)->first()->status) {
            if ($user->referral_code == null) {
                $user->referral_code = substr($user->id . \Str::random(10), 0, 10);
                $user->update();
            }
            $referral_code = $user->referral_code;
            $referral_code_url = URL::to('/register') . "?referral_code=$referral_code";
        } else {
            $referral_code_url = '';
        }
        $affiliate_config = AffiliateConfig::select('first_purchase_amount')->first();
        return response()->json([
            'result' => true,
            'referral_code_url' => $referral_code_url,
            'referral_amount' => $affiliate_config->first_purchase_amount
        ]);
    }

    public function userCoupons($user_id)
    {
        $emergency_coupons = DB::table('coupon_usages as c_usage')->where('c_usage.user_id', $user_id)
        ->leftJoin('coupons as c','c.id','c_usage.coupon_id')
        ->where('c.type', 'emergency_coupon')
        ->select('c.code','c.discount','c.discount_type')
        ->get();

        $emergency_coupon_arr = $emergency_coupons->map(function($coupon){
           return [
            'amount' => ($coupon->discount_type == 'amount')?single_price($coupon->discount):$coupon->discount.'%',
            'code' => $coupon->code
           ];
        });

        $normal_coupons = DB::table('coupon_usages as c_usage')->where('c_usage.user_id', $user_id)
        ->leftJoin('coupons as c','c.id','c_usage.coupon_id')
        ->whereIn('c.type', ['product_base','cart_base'])
        ->where('c.user_id', '!=', $user_id)
        ->select('c.code','c.discount','c.discount_type')
        ->get();

        $normal_coupon_arr = $normal_coupons->map(function($coupon){
           return [
            'amount' => ($coupon->discount_type == 'amount')?single_price($coupon->discount):$coupon->discount.'%',
            'code' => $coupon->code
           ];
        });

        $orders = DB::table('orders')->where('user_id', $user_id)->where('order_type','N')
        ->where('is_gift_product_availed', 1)->orWhere('is_gift_discount_applied', 1)
        ->select('is_gift_product_availed','gift_product_data','is_gift_discount_applied','gift_discount_data')->get();
        $gifts_arr = [];
        $gifts_discount_arr = [];
        foreach($orders as $order){
        if ($order->is_gift_product_availed) {
                $gift_datas = json_decode($order->gift_product_data);
                $data = [
                    'gift_title' => $gift_datas->discount_title,
                    'gift_name' => $gift_datas->gift_name,
                    'gift_image' => api_asset($gift_datas->gift_image)
                ];
                array_push($gifts_arr, $data);
        } 
        if ($order->is_gift_discount_applied) {
            $gift_discount_data = json_decode($order->gift_discount_data);
            $data = [
                'title' => $gift_discount_data->title,
                'discount' => single_price($gift_discount_data->discount),
            ];
            array_push($gifts_discount_arr, $data);
        }
        }

        $battery_warranty_rewards = DB::table('coupons')->where('type', 'warranty_reward')
        ->whereJsonContains('claimed_user_id', $user_id)
        ->select('id', 'code', 'details', 'discount', 'discount_type', 'start_date', 'end_date', 'limit')
        ->paginate(10)->appends(request()->query());

        $battery_warranty_rewards->getCollection()->transform(function ($reward) use ($user_id) {
            $details = json_decode($reward->details);
            $coupon_used = DB::table('coupon_usages')->where('user_id', $user_id)->where('coupon_id', $reward->id)->first();
            return [
                'code' => $reward->code,
                'min_buy_amount' => single_price($details->min_buy),
                'discount' => ($reward->discount_type == 'amount')?single_price($reward->discount):$reward->discount . ' ' . ucfirst($reward->discount_type),
                'discount_start_date' => date(env('DATE_FORMAT'), $reward->start_date),
                'discount_end_date' => date(env('DATE_FORMAT'), $reward->end_date),
                'usage_limit' => $reward->limit,
                'status' => ($coupon_used) ? 'Availed' : 'Claimed'
            ];
        });

        $referral_coupons = DB::table('coupons as c')->where('c.user_id', $user_id)
        ->leftJoin('users','users.id','c.reffered_by')
        ->select('users.name','c.reffered_by','c.code','c.discount','c.start_date','c.end_date','c.limit')
        ->get();
        $referral_coupons_arr = $referral_coupons->map(function ($coupon) {
            return [
                'coupon_code' => $coupon->code ? $coupon->code : '',
                'discount' => single_price($coupon->discount),
                'start_date' => date(env('DATE_FORMAT'), $coupon->start_date),
                'end_date' => date(env('DATE_FORMAT'), $coupon->end_date),
                'referred_by' => $coupon->reffered_by ? $coupon->name : 'You reffered someone',
                'status' => ($coupon->limit > 0)?'Not Used':'Used'
            ];
        });

        $merchant_vouchers = MerchantVoucher::whereJsonContains('used_by', $user_id)->select('voucher_code','amount')->get();
        $merchant_vouchers_arr = $merchant_vouchers->map(function ($coupon) {
            return [
            'amount' => single_price($coupon->amount),
            'code' => $coupon->voucher_code 
            ];
        });

        $download_histories = QrcodeDownloadHistory::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        $download_histories_arr = [];
        foreach($download_histories as $history){
            if(MerchantVoucher::whereJsonContains('used_by', $user_id)->where('voucher_code',$history->voucher_code)->first() == null){
                $download_histories_arr[] = [
                    'id' => $history->id,
                    'voucher_code' => $history->voucher_code,
                    'date' => ($history->created_at) ? convert_datetime_to_local_timezone($history->created_at, user_timezone($user_id)) : '',
                ]; 
            }
        }

        return response()->json([
            'result' => true,
            'emergency_coupons' => $emergency_coupon_arr,
            'normal_coupons' => $normal_coupon_arr,
            'gifts_coupons' => ['gifts' => $gifts_arr, 'gift_discounts' => $gifts_discount_arr],
            'battery_warranty_rewards' => $battery_warranty_rewards,
            'referral_coupons' => $referral_coupons_arr,
            'merchant_coupons' => ['coupons' => $merchant_vouchers_arr, 'qr_codes' => $download_histories_arr]
        ]);
    }

    public function coupons($user_id)
    {
        $currentTimestamp = time();
        $coupons = DB::table('coupons as c')
            ->whereRaw('? BETWEEN c.start_date AND c.end_date', [$currentTimestamp])
            ->select(
                'c.id',
                'c.type',
                'c.code',
                'c.discount_title',
                'c.details',
                'c.product_ids',
                'c.discount',
                'c.discount_type',
                DB::raw('FROM_UNIXTIME(c.start_date) as start_date'),
                DB::raw('FROM_UNIXTIME(c.end_date) as end_date'),
                'c.limit',
                'c.gift_type',
                'c.gifts',
                'c.tnc',
                'c.description',
            )
            ->get();

        // Process cart_base coupons
        $cart_base_arr = $coupons->filter(function ($coupon) {
            return $coupon->type === 'cart_base';
        })->map(function ($coupon) {
            return [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount_title' => $coupon->discount_title,
                'details' => $coupon->details,
                'product_ids' => $coupon->product_ids,
                'discount' => ($coupon->discount_type == 'amount') ? single_price($coupon->discount) : $coupon->discount . '%',
                'discount_type' => $coupon->discount_type,
                'start_date' => date(env('DATE_FORMAT'), strtotime($coupon->start_date)),
                'end_date' => date(env('DATE_FORMAT'), strtotime($coupon->end_date)),
                'usage_limit' => $coupon->limit,
                'tnc' => $coupon->tnc,
                'description' => $coupon->description,
            ];
        })->values(); 

        // Process gift_base coupons
        $gift_base_arr = $coupons->filter(function ($coupon) {
            return $coupon->type === 'gift_base';
        })->map(function ($coupon) {
            return [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount_title' => $coupon->discount_title,
                'details' => json_decode($coupon->details, true),
                'product_ids' => $coupon->product_ids,
                'discount' => ($coupon->discount_type == 'amount') ? single_price($coupon->discount) : $coupon->discount . '%',
                'discount_type' => $coupon->discount_type,
                'start_date' => date(env('DATE_FORMAT'), strtotime($coupon->start_date)),
                'end_date' => date(env('DATE_FORMAT'), strtotime($coupon->end_date)),
                'usage_limit' => $coupon->limit,
                'gift_type' => $coupon->gift_type ?? null,
                'gifts' => json_decode($coupon->gifts ?? '{}', true),
                'tnc' => $coupon->tnc,
                'description' => $coupon->description,
            ];
        })->values();

        // get deals and offers
        // table deals where status = 1, type = 'membership'

        $deals = DB::table('deals')
            ->join('uploads', 'deals.banner', '=', 'uploads.id')
            ->where('deals.status', 1)
            ->where('deals.type', 'membership')
            ->select(
            'deals.id AS id', 
            'title',
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(start_date), '%d/%m/%Y') AS start_date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(end_date), '%d/%m/%Y') AS end_date"),
            DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS banner")
            )->get();

        $customer = Customer::leftJoin('users', 'users.id', '=', 'customers.user_id')
            ->where('customers.user_id', $user_id)
            ->select('customers.point_balance', 'users.name', DB::raw("'Gold' as tier"))
            ->first();

        return response()->json([
            'result' => true,
            'customer' => $customer,
            'deals' => $deals,
            'cart_base_coupons' => $cart_base_arr,
            'gift_base_coupons' => $gift_base_arr,
        ]);
    }

    public function battery_warranties($user_id)
    {
        $orders = DB::table('orders')
            ->where('orders.order_type', 'B')
            ->where('orders.battery_type', 'N')
            ->whereNotNull('orders.warranty_activation_date')
            ->where('orders.user_id', $user_id)
            ->leftJoin('order_details as od', 'od.order_id', 'orders.id')
            ->leftJoin('batteries', 'od.product_id', 'batteries.id')
            ->select('orders.battery_expiry_months', 'orders.warranty_activation_date', 'orders.car_plate', 'orders.model_name', 'batteries.attachment_id',
            'batteries.name','batteries.model')
            ->get();
        $array = $orders->map(function ($record) {
            return [
                'name' => $record->name,
                'model' => $record->model,
                'car_plate' => $record->car_plate,
                'car_model' => $record->model_name,
                'activation_date' => date(env('DATE_FORMAT'), strtotime($record->warranty_activation_date)),
                'warranty_period' => $record->battery_expiry_months.' months',
                'image' => $record->attachment_id ? api_asset($record->attachment_id) : ''
            ];
        });
        $data['battery_warranties'] = $array;
        $payments = DB::table('car_wash_payments as cwp')
            ->leftJoin('car_wash_products as wp', 'wp.id', 'cwp.car_wash_product_id')
            ->leftJoin('car_wash_categories as cwc', 'cwc.id', 'wp.category_id')
            ->join('users as u', 'u.id', '=', 'cwp.user_id')
            ->select('cwp.id', 'cwp.warranty', 'cwp.car_plate', 'cwp.updated_at', 'cwp.model_name', 'u.name', 'cwc.name as category')
            ->where('cwp.warranty', '>', 0)
            ->whereRaw('cwp.created_at != cwp.updated_at')
            ->where('cwp.user_id', $user_id)
            ->get();

        $data['carwash_warranties'] = [];
        foreach ($payments as $payment) {
            $date = date("Y-m-d", strtotime("+" . $payment->warranty . " years", strtotime($payment->updated_at)));
            if (strtotime(date('Y-m-d')) <= strtotime($date)) {
                $warranty = translate('You warranty will expire on ' . $date);
            } else {
                $warranty = translate('You warranty has expired');
            }
            $data['carwash_warranties'][] = array(
                'id' => $payment->id,
                'warranty' => $payment->warranty,
                'name' => $payment->name,
                'category' => $payment->category,
                'expiry' => $warranty,
                'years' => $payment->warranty . ' ' . (($payment->warranty <= 1) ? translate('year') : translate('years')),
                'car_plate' => $payment->car_plate,
                'model' => $payment->model_name,
            );
        }

        return response()->json([
            'result' => true,
            'data' => $data,
        ]);
    }

    public function remainDaysOrderDetails($order_id)
    {
        if ($order_id) {
            $order = Order::where('id', $order_id)->first();
            $user = User::where('id', $order->user_id)->first();
            $shop = DB::table('shops')->where('id', $order->seller_id)->first();
            return response()->json([
                'result' => true,
                'workshop_name' => $shop->name,
                'workshop_address' => $shop->address,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'order_code' => $order->code,
                'order_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'order_date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($order->user_id)),
                'payment_type' => ucfirst(str_replace('_', ' ', $order->payment_type))
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Order id is missing'
            ]);
        }
    }

    public function remainHourAlert($order_id)
    {
        if ($order_id) {
            $order = Order::where('id', $order_id)->first();
            $user = User::where('id', $order->user_id)->first();
            $shop = DB::table('shops')->where('id', $order->seller_id)->first();
            return response()->json([
                'result' => true,
                'workshop_name' => $shop->name ? $shop->name : '',
                'workshop_address' => $shop->address ? $shop->address : '',
                'user_name' => $user->name,
                'user_email' => $user->email,
                'order_code' => $order->code,
                'order_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'order_date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($order->user_id)),
                'payment_type' => ucfirst(str_replace('_', ' ', $order->payment_type))
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Order id is missing'
            ]);
        }
    }

    public function updateRequestStatus($availability_id)
    {
        $timing = DB::table('availability_requests')->where('id', $availability_id)->first();
        return response()->json([
            'result' => true,
            'date' => \Carbon\Carbon::parse($timing->date)->format('m-d-Y'),
            'previous_from_time' => \Carbon\Carbon::parse($timing->previous_from_time)->format('h: i a'),
            'previous_to_time' => \Carbon\Carbon::parse($timing->previous_to_time)->format('h: i a'),
            'current_from_time' => \Carbon\Carbon::parse($timing->from_time)->format('h: i a'),
            'current_to_time' => \Carbon\Carbon::parse($timing->to_time)->format('h: i a')
        ]);
    }

    public function editList($list_id)
    {
        if ($list_id) {
            $carlist = CarList::find($list_id);
            $list_data = [
                'list_id' => $carlist->id,
                'car_plate' => $carlist->car_plate ? $carlist->car_plate : '',
                'mileage' => $carlist->mileage ? $carlist->mileage : '',
                'chassis_number' => $carlist->chassis_number ? $carlist->chassis_number : '',
                'insurance' => $carlist->insurance ? $carlist->insurance : '',
                'image' => api_asset($carlist->image)
            ];
            return response()->json([
                'result' => true,
                'list_data' => $list_data,
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'List id is missing.'
            ]);
        }
    }

    public function createCarlist()
    {
        $brands = Brand::orderBy('name','asc')->select('id', 'name')->get();
        $brands_arr = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->getTranslation('name')
            ];
        });
        return response()->json([
            'result' => true,
            'brands' => $brands_arr,
        ]);
    }

    public function updateList(Request $request, $list_id)
    {
        if ($list_id) {
            $carlist = CarList::find($list_id);
            $carplate_exists = CarList::where('id', '!=', $list_id)->where('car_plate', $request->car_plate)->first();
            if ($carplate_exists) {
                return response()->json([
                    'result' => false,
                    'message' => 'Car plate must be unique.'
                ]);
            }

            if($request->hasfile('image')){
                $type = array(
                    "jpg" => "image",
                    "jpeg" => "image",
                    "png" => "image",
                    "svg" => "image",
                    "webp" => "image",
                    "gif" => "image",
                );
                $dir = public_path('uploads/all/');
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = str_replace(" ", "-", rand(10000000000,9999999999).date("YmdHis").$file->getClientOriginalName());
        
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
                }
                else{
                    $file->move($dir,$filename);
                }
        
                $upload->file_original_name = 'car_image';
                $upload->extension = $extension;
                $upload->file_name = 'uploads/all/'.$filename;
                $upload->user_id = $carlist->user_id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                $upload->save();
        
                $image_id = $upload->id;
                }
                else{
                    $image_id = $carlist->image;
                }
            $carlist->update([
                'car_plate' => $request->car_plate,
                'mileage' => ($request->mileage) ? $request->mileage : '',
                'chassis_number' => $request->chassis_number,
                'insurance' => $request->insurance,
                'image' => $image_id
            ]);
            return response()->json([
                'result' => true,
                'message' => 'Updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'List id is missing.'
            ]);
        }
    }

    public function storeCarlist(Request $request, $user_id)
    {
        $carplate_exists = CarList::where('car_plate', $request->car_plate)->first();
        if ($carplate_exists) {
            return response()->json([
                'result' => false,
                'message' => 'Car plate has already been taken.'
            ]);
        }
        if ($user_id) {
            if ($request->hasfile('image')) {
                $type = array(
                    "jpg" => "image",
                    "jpeg" => "image",
                    "png" => "image",
                    "svg" => "image",
                    "webp" => "image",
                    "gif" => "image",
                );
                $dir = public_path('uploads/all/');
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = str_replace(" ", "-", rand(10000000000,9999999999).date("YmdHis").$file->getClientOriginalName());
        
                $upload = new Upload;
                $size = $file->getSize();
        
                if (!isset($type[$extension])) {
                    return response()->json([
                        'result' => false,
                        'message' => "Only image can be uploaded"
                    ]);
                }
        
                $file->move($dir,$filename);

                $upload->file_original_name = 'car_image';
                $upload->extension = $extension;
                $upload->file_name = 'uploads/all/'.$filename;
                $upload->user_id = $user_id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                $upload->save();
                $image_id = $upload->id;
            } else {
                $image_id = 0;
            }
            $count = DB::table('car_lists')->where('user_id', $user_id)->count();
            $carlist = CarList::create([
                'user_id' => $user_id,
                'brand_id' => $request->brand_id,
                'model_id' => $request->model_id,
                'year_id' => $request->year_id,
                'variant_id' => $request->variant_id,
                'chassis_number' => $request->chassis_number,
                'car_plate' => $request->car_plate,
                'insurance' => $request->insurance,
                'mileage' => ($request->mileage) ? $request->mileage : '',
                'vehicle_size' => $request->vehicle_size,
                'size_alternative_id' => $request->size_alternative_id,
                'image' => $image_id
            ]);
            // create 2 free carwash usages for first time
            // if ($count == 0) {
                // order
                // $product = CarWashProduct::where('type', '!=', 'M')->first();
                // if ($product) {
                    // $car_model = DB::table('car_models')->select('name')->where('id', $request->model_id)->first();
                    // $order = new Order();
                    // $order->user_id = $user_id;
                    // $order->username = $request->user()->name;
                    // $order->carlist_id = $carlist->id;
                    // $order->brand_id = $carlist->brand_id;
                    // $order->model_id = $carlist->model_id;
                    // $order->order_type = 'CW';
                    // $order->seller_id = $product->user_id;
                    // $order->model_name = $car_model->name;
                    // $order->car_plate = $carlist->car_plate;
                    // $order->location = json_encode(['lat' => $request->latitude, 'long' => $request->longitude, 'loc' => $request->location]);
                    // $order->delivery_status = 'delivered';
                    // $order->payment_status = 'paid';
                    // $order->payment_status = 'paid';
                    // $order->payment_details = '{"status":"Success"}';
                    // $order->delivery_type = 'self delivery';
                    // $order->workshop_date = now();
                    // $order->workshop_time = now();
                    // $order->payment_type = 'FREE';
                    // $order->code = date('Ymd-His') . rand(10, 99);
                    // $order->date = strtotime(date('Y-m-d H:i:s'));
                    // if ($order->save()) {
                    //     $subtotal = 0;
                    //     $tax = 0;
                    //     $shipping = 0;
                    //     $subtotal += 0;
                    //     $tax += 0;
            
                        // $order_detail = new OrderDetail();
                        // $order_detail->order_id = $order->id;
                        // $order_detail->seller_id = $product->user_id;
                        // $order_detail->product_id = $product->id;
                        // $order_detail->price = 0;
                        // $order_detail->tax = 0;
                        // $order_detail->shipping_type = 'Car Wash';
                        // $order_detail->shipping_cost = 0;
                        // $shipping += $order_detail->shipping_cost;
                        // $order_detail->quantity = 1;
                        // $order_detail->type = 'C';
            
                        // $order_detail->save();
                        // $order->grand_total = $subtotal + $tax + $shipping;
            
                        // Car wash payments
                    //     $car_wash_payment = new CarWashPayment();
                    //     $car_wash_payment->car_wash_product_id = $product->id;
                    //     $car_wash_payment->carlist_id = $carlist->id;
                    //     $car_wash_payment->order_id = $order->id;
                    //     $car_wash_payment->user_id = $user_id;
                    //     $car_wash_payment->usage_limit = 2;
                    //     $car_wash_payment->amount = 0;
                    //     $car_wash_payment->membership_fee = 0;
                    //     $car_wash_payment->warranty = $product->warranty;
                    //     $car_wash_payment->car_plate = $carlist->car_plate;
                    //     $car_wash_payment->model_name = $car_model->name;
                    //     $car_wash_payment->status = 1;
                    //     $car_wash_payment->save();
    
                    //     $order->save();
                    // }
                // }
            // }
            return response()->json([
                'result' => true,
                'message' => 'Added successfully.'
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'You are logged out from app please login again.'
            ]);
        }
    }

    public function deleteList($list_id)
    {
        if ($list_id) {
            CarList::find($list_id)->delete();
            return response()->json([
                'result' => true,
                'message' => 'Deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'List id is missing.'
            ]);
        }
    }

    public function carwash_orders_history(Request $request, $user_id)
    {
        if ($user_id) {
            $orders = Order::leftJoin('car_models', 'car_models.id', '=', 'orders.model_id')
            ->select('car_models.name as model', 'orders.id', 'orders..code', 'orders.car_plate', 'orders.date', 'orders.grand_total', 'orders.delivery_status', 'orders.payment_status')
            ->where('orders.order_type', 'CW')
            ->where('orders.user_id', $user_id)
            ->orderBy('orders.id', 'desc')
            ->get();
            $timezone = user_timezone($user_id);
            $data = $orders->map(function ($order) use ($timezone) {
                return [
                    'id' => $order->id,
                    'code' => $order->code,
                    'model_name' => $order->model,
                    'car_plate' => $order->car_plate,
                    'date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), $timezone),
                    'amount' => single_price($order->grand_total),
                    'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                    'reassign_status' => 0,
                    'delivery_status' => $order->delivery_status,
                    'payment_status' => $order->payment_status,
                    'approve_status' => 0,
                    'tyre_purchased' => 0,
                    'package_purchased' => 0,
                    'cancel_btn' => false
                ];
            });
            return response()->json([
                'result' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'You are logged out from app please login again.'
            ]);
        }
    }

    public function carwash_order_details($id)
    {
        $order= Order::findOrFail($id);
        $products_arr = $order->orderDetails->map(function ($orderDetail){
            if ($orderDetail->carwashProduct != null){
            $name = $orderDetail->carwashProduct->name;
            }
            else{
            $name = 'Car Wash';
            }
            return [
                'name' => $name,
                'price' => single_price($orderDetail->price),
            ];
        });
        $order_arr = [
            'code' => $order->code,
            'order_date' => $order->date ? convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($order->user_id)) : '',
            'schedule_time' => '',
            'order_status' => '',
            'total_order_amount' => single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')),
            'payment_method' => ucfirst(str_replace('_', ' ', $order->payment_type)),
            'car_model' => $order->model_name,
            'products' => $products_arr,
            'subtotal' => single_price($order->orderDetails->sum('price')),
            'coupon' => single_price($order->coupon_discount),
            'total' => single_price($order->grand_total),
            'location' => '',
            'arrival_mints' => ''
        ];
        return response()->json([
            'result' => true,
            'data' => $order_arr
        ]);
    }

    public function transactionHistory(Request $request, $user_id, $type)
    {
        if ($user_id) {
            $orders = Order::leftJoin('car_models', 'car_models.id', '=', 'orders.model_id')
            ->where('orders.order_type', 'N')
            ->where('orders.user_id', $user_id);
            if ($type == 'new') {
                $orders = $orders->where('orders.user_date_update', '!=', 1)->where('orders.reassign_status', '!=', 2);
            } elseif ($type == 'reschedule') {
                $orders = $orders->where('orders.user_date_update', 1);
            } elseif ($type == 'reassign') {
                $orders = $orders->where('orders.reassign_status', 2);
            }

            $orders = $orders->select('car_models.name as model', 'orders.id', 'orders.code', 'orders.car_plate', 'orders.date', 'orders.grand_total', 'orders.delivery_status', 'orders.reassign_status', 'orders.delivery_status', 'orders.payment_status', 'orders.workshop_date_approve_status')->orderBy('orders.id', 'desc')->get();
            $timezone = user_timezone($user_id);
            $order_arr = $orders->map(function ($order) use ($timezone) {
                $cancel_btn = false;
                $is_tyre_exists = DB::table('order_details')->where('order_id', $order->id)->where('type', 'T')->first();
                $is_package_exists = DB::table('order_details')->where('order_id', $order->id)->where('type', 'P')->first();
                $hourdiff = round((strtotime(now()) - strtotime($order->created_at))/3600, 1);
                if(!in_array($order->delivery_status, ['cancelled', 'Rejected', 'Done', 'completed']) && $hourdiff <= 24){
                    $cancel_btn = true;
                }
                return [
                    'id' => $order->id,
                    'code' => $order->code,
                    'model_name' => $order->model,
                    'car_plate' => $order->car_plate,
                    'date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), $timezone),
                    'amount' => single_price($order->grand_total),
                    'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                    'reassign_status' => $order->reassign_status,
                    'delivery_status' => $order->delivery_status,
                    'payment_status' => $order->payment_status,
                    'approve_status' => $order->workshop_date_approve_status,
                    'tyre_purchased' => ($is_tyre_exists)?1:0,
                    'package_purchased' => ($is_package_exists)?1:0,
                    'cancel_btn' => $cancel_btn
                ];
            });
            return response()->json([
                'result' => true,
                'data' => $order_arr
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'You are logged out from app please login again.'
            ]);
        }
    }

    public function rescheduleDate($id)
    {
        $this_order = Order::where('id', $id)->first();
        $current_date = date('Y-m-d', strtotime('+3 days'));
        $datas = WorkshopAvailability::select('shop_id', 'date')->where('shop_id', $this_order->seller_id)->where('from_time', '!=', '')->where('to_time', '!=', '')->whereDate('date', '>=', $current_date)->get();
        if (count($datas) > 0) {
            $dates_arr = $datas->map(function ($data){
                $message = '';
                $time_array = [];
                $shop = WorkshopAvailability::where('shop_id', $data->shop_id)->where('date', '=', $data->date)->first();
                if ($shop && $shop->from_time && $shop->to_time) {
                    $shop_details = Shop::where('id', $data->shop_id)->select('availability_duration')->first();
                    $from_time = $shop->from_time;
                    $to_time = $shop->to_time;
                    $diff = abs(strtotime($from_time) - strtotime($to_time));
                    // Convert $diff to minutes
                    $tmins = $diff / 60;
                    // Get hours
                    $duration = ($shop_details->availability_duration) ? $shop_details->availability_duration : 60;
                    $total_appointments = round(floor($tmins / $duration));
                    if ($shop->booked_appointments < $total_appointments) {
                        $from_time = $shop->date . ' ' . $from_time;
                        for ($i = 0; $i < $total_appointments; $i++) {
                            $order = DB::table('orders')->where('availability_id', $shop->id)->whereDate('workshop_date', date('Y-m-d', strtotime($from_time)))->whereTime('workshop_time', date('h:i A', strtotime($from_time)))->first();
                            if (!$order) {
                                array_push($time_array, date('g:i A', strtotime($from_time)));
                            }
                            $from_time = strtotime($from_time . ' + ' . $duration . ' minute');
                            $from_time = date('Y-m-d H:i:00', $from_time);
                        }
                        $message = 'ok';
                    } else {
                        $message = 'Slots are already booked on this date for this workshop. Please select another date.';
                    }
                } else {
                    $message = 'Workshop is not available on this date. Please select another date.';
                }

                return [
                    'date' => $data->date,
                    'availability_id' => $shop->id,
                    'time_message' => $message,
                    'date_timings' => $time_array
                ];
            });
            return response()->json([
                'result' => true,
                'dates' => $dates_arr
            ], 200);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'No available dates found for this workshop.',
            ], 200);
        }
    }

    public function orderReAssign(Request $request)
    {
        $order_before_update = Order::find($request->order_id);
        $order_delivery_status = $order_before_update->delivery_status;
        $old_shop_id = $order_before_update->seller_id;
        $old_data = array();
        $old_data['old_workshop_date'] = $order_before_update->workshop_date;
        $old_data['old_workshop_time'] = $order_before_update->workshop_time;
        
        $order = Order::find($request->order_id);
        $order->reassign_date = Carbon::now();
        $order->reassign_status = 2;
        $order->old_workshop_id = $old_shop_id;
        $order->workshop_date = date('Y-m-d', strtotime($request->selected_date));
        $order->workshop_time = $request->selected_time;
        $order->availability_id = $request->availability_id;
        $order->reassign_data = json_encode($old_data);
        if($old_shop_id != $request->shop_id){
        $order->seller_id = $request->shop_id;
        $order->delivery_status = 'pending';
        $order->start_installation_status = 0;
        $order->done_installation_status = 0;
        }
        $order->update();

        $shop = DB::table('shops')->where('id', $request->shop_id)->select('user_id')->first();
        if($old_shop_id != $request->shop_id){
        DB::table('order_details')->where('order_id', $request->order_id)->update([
            'seller_id' => $shop->user_id,
            'received_status' => null
        ]);

        //now update the shop availability
        if ($request->availability_id) {
            $shop_availability = WorkshopAvailability::where('id', $request->availability_id)->first();
            $shop_availability->booked_appointments += 1;
            $shop_availability->update();
        }
        }

        // Generate Notification
        \App\Models\Notification::create([
            'user_id' => $shop->user_id,
            'is_admin' => 2,
            'type' => 'order_reassigned',
            'body' => translate('An order has been reassigned to you'),
            'order_id' => $order->id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $shop->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('An order has been reassigned to you')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }

        if($order_delivery_status != 'pending' && $old_shop_id != $request->shop_id){
        $old_shop = DB::table('shops')->where('id', $old_shop_id)->select('user_id')->first();    
        // Generate Notification to workshop to return the products to admin
        \App\Models\Notification::create([
            'user_id' => $old_shop->user_id,
            'is_admin' => 2,
            'type' => 'return_products',
            'body' => translate('Please return order products to Warehouse'),
            'order_id' => $order->id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $old_shop->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Please return order products to Warehouse')
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        }
        return response()->json([
            'result' => true,
            'message' => 'Order has been reassigned successfully',
        ], 200);
    }

    public function rescheduleDateSubmit(Request $request)
    {
        $order = Order::find($request->order_id);
        $noOfWeeks = (strtotime(now()) - strtotime($order->created_at)) / 604800;
        if($order->user_date_update != 0 || $noOfWeeks > env('RESCHEDULE_FREE_WEEKS')){
            return response()->json([
                'result' => true,
                'payment_screen' => 'yes',
                'reschedule_fee' => single_price(env('RESCHEDULE_FEE')),
                'workshop_name' => DB::table('shops')->where('id', $order->seller_id)->select('name')->first()->name,
                'message' => '',
            ], 200);
        }
        else{
            $order->update([
                'old_workshop_date' => $order->workshop_date,
                'old_workshop_time' => $order->workshop_time,
                'workshop_date' => date('Y-m-d', strtotime($request->wdate)),
                'workshop_time' => $request->wtime,
                'availability_id' => $request->availability_id,
                'user_date_update' => 1
            ]);
        // Generate Notification
        $shop = Shop::where('id',$order->seller_id)->select('user_id')->first();
        \App\Models\Notification::create([
            'user_id' => $shop->user_id,
            'is_admin' => 2,
            'type' => 'order_reschedule',
            'body' => translate('Order has been rescheduled by user'),
            'order_id' => $request->order_id,
        ]);
        try {
            // Send firebase notification
            $device_token = DB::table('device_tokens')->where('user_id', $shop->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Order has been rescheduled by user')
            );
            send_firebase_notification($array);
            } catch (\Exception $e) {
                // dd($e);
            }
            return response()->json([
                'result' => true,
                'payment_screen' => 'no',
                'message' => 'Order has been rescheduled successfully.',
            ], 200);
        }
    }

    public function rescheduleDatePaymentSubmit(Request $request)
    {
        $workshop_date = date('Y-m-d', strtotime($request->wdate));
        return response()->json([
            'result' => true,
            'url' => url('api/v2/ipay-webview/'.$request->order_id.'/yes').'?wd='.$workshop_date.'&wt='.$request->wtime.'&aid='.$request->availability_id
        ]);
    }

    public function transaction_history_details(Request $request, $order_id, $type = null)
    {
        if ($order_id) {
            $order = Order::findOrFail($order_id);
            $shop = Shop::where('id', $order->seller_id)->first();
            if ($order->model_id) {
                $model = CarModel::where('id', $order->model_id)->first();
            }

            $tyre_products = DB::table('order_details')
                ->where('order_details.order_id', $order_id)
                ->where('order_details.type', 'T')
                ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
                ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
                ->select('order_details.product_id','product_translations.name', 'order_details.quantity', 'order_details.price','order_details.received_status')
                ->get();
        
            $tyre_products_arr = $tyre_products->map(function ($tyre_product) {
                $product_name_with_choice = ($tyre_product->name != null) ? $tyre_product->name : translate('Product Unavailable');
                return [
                    'product_id' => $tyre_product->product_id,
                    'product' => $product_name_with_choice,
                    'quantity' => $tyre_product->quantity,
                    'price' => single_price($tyre_product->price),
                    'workshop_status' => $tyre_product->received_status ? $tyre_product->received_status : 'Not Received',
                    'package_name' => ''
                ];
            });
            
            $package_products = DB::table('order_details')
                ->where('order_details.order_id', $order_id)
                ->where('order_details.type', 'P')
                ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
                ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
                ->select('order_details.product_id','product_translations.name', 'order_details.quantity', 'order_details.price','order_details.received_status')
                ->get();

            $package_products_arr = $package_products->map(function ($package_product) {
                return [
                    'product_id' => $package_product->product_id,
                    'product' => ($package_product->name != null) ? $package_product->name : translate('Product Unavailable'),
                    'quantity' => $package_product->quantity,
                    'price' => single_price($package_product->price),
                    'workshop_status' => $package_product->received_status ? $package_product->received_status : 'Not Received',
                    'package_name' => translate('Package')
                ];
            });
        
            $gifts_arr = [];
            if ($order->is_gift_product_availed) {
                $gift_datas = json_decode($order->gift_product_data);
                $data = [
                    'gift_title' => $gift_datas->discount_title,
                    'gift_name' => $gift_datas->gift_name,
                    'gift_image' => api_asset($gift_datas->gift_image)
                ];
                array_push($gifts_arr, $data);
            }

            $imageName = 'qr-code-'.$order->user_id.'-'.$request->order_id.'.png';
            if (!file_exists(public_path().'/qr-codes/'.$imageName)) {
                $type = 'png';
                $user_order = $order->user_id . '/' . $request->order_id;
                $type = $type == 'jpg' ? 'png' : $type;
                \QrCode::format($type)
                    ->size(200)->errorCorrection('H')
                    ->margin(2)
                    ->generate($user_order, public_path().'/qr-codes/'.$imageName);
            }
            $appointment_date = $order->workshop_date ? date(env('DATE_FORMAT'), strtotime($order->workshop_date)) : '';
            $appointment_time = $order->workshop_time ? $order->workshop_time : '';
            $gift_discount_data = json_decode($order->gift_discount_data);
            $old_shop = DB::table('shops')->where('id', $order->old_workshop_id)->select('name')->first();
            $old_shop_reassign_data = $order->reassign_data?json_decode($order->reassign_data, true):[];
            $old_shop_app_date_time = '';
            if (!empty($old_shop_reassign_data)) {
                $old_shop_app_date_time = date(env('DATE_FORMAT'), strtotime($old_shop_reassign_data['old_workshop_date'])) . ' ' . $old_shop_reassign_data['old_workshop_time'];
            }
            $timezone = user_timezone($order->user_id);
            $order_arr = [
                'qr_code_link' => url('public/qr-codes/'.$imageName),
                'qr_code_name' => $imageName,
                'code' => $order->code,
                'email' => ($order->user_id != null) ? $order->user->email : '',
                'old_shop_name' => ($old_shop) ? $old_shop->name : '',
                'reassign_date' => ($order->reassign_date)?convert_datetime_to_local_timezone($order->reassign_date, $timezone):'',
                'old_shop_appointment_date' => $old_shop_app_date_time,
                'shop_name' => ($shop) ? $shop->name : '',
                'shop_address' => ($shop && $shop->address) ? $shop->address : '',
                'is_user_date_update' => $order->user_date_update,
                'old_appointment_date' => date(env('DATE_FORMAT'), strtotime($order->old_workshop_date)) . ' ' . $order->old_workshop_time,
                'appointment_date' => $appointment_date . ' ' . $appointment_time,
                'car_plate' => ($order->car_plate) ? $order->car_plate : '',
                'order_date' => $order->date ? convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), $timezone) : '',
                'order_status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'total_order_amount' => single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')),
                'payment_method' => ucfirst(str_replace('_', ' ', $order->payment_type)),
                'car_model' => (isset($model)) ? $model->name : '',
                'tyre_products' => $tyre_products_arr,
                'package_products' => $package_products_arr,
                'gifts_arr' => $gifts_arr,
                'subtotal' => single_price($order->orderDetails->sum('price')),
                'coupon' => single_price($order->coupon_discount),
                'is_gift_discount_applied' => $order->is_gift_discount_applied,
                'discount_title' => ($order->is_gift_discount_applied) ? $gift_discount_data->title : '',
                'gift_discount' => ($order->is_gift_discount_applied) ? single_price($gift_discount_data->discount) : '',
                'is_express_delivery' => ($order->express_delivery) ? true : false,
                'express_delivery' => ($order->express_delivery) ? single_price($order->express_delivery) : '',
                'total' => single_price($order->grand_total)
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

    public function installation_history(Request $request, $user_id, $order_id = null)
    {
        if ($user_id) {
            if ($order_id != null) {
                DB::table('orders')->where('id', $order_id)->update([
                    'notify_user_come_to_workshop_to_review_car' => 2
                ]);
            }
            $orders = Order::where('order_type', 'N')->where('user_id', $user_id)->orderBy('id', 'desc')->where('start_installation_status', 1)->get();
            $orders_arr = $orders->map(function ($order) use($user_id) {
                $model = DB::table('car_models')->where('id', $order->model_id)->first();
                return [
                    'order_id' => $order->id,
                    'code' => $order->code,
                    'car_model' => $model ? $model->name : '',
                    'car_plate' => $order->car_plate ? $order->car_plate : '',
                    'date' => $order->date ? convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($user_id)) : '',
                    'amount' => single_price($order->grand_total),
                    'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                    'done_installation_status' => $order->done_installation_status ? $order->done_installation_status : 0,
                    'payment_status' => $order->payment_status ? $order->payment_status : '',
                    'delivery_status' => $order->delivery_status
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

    public function reschedule_payment_history($user_id)
    {
        if ($user_id) {
            $payments = DB::table('payments')->where('payments.type', 'reshedule')
            ->where('payments.user_id', $user_id)
            ->leftJoin('orders', 'orders.id','payments.order_id')
            ->select('payments.*','orders.code')
            ->orderBy('payments.id', 'desc')
            ->get();
            $timezone = user_timezone($user_id);
            $payments_arr = $payments->map(function ($payment) use ($timezone) {
                return [
                    'order_id' => $payment->order_id,
                    'order_code' => $payment->code,
                    'amount' => single_price($payment->amount),
                    'payment_date' => $payment->created_at ? convert_datetime_to_local_timezone($payment->created_at, $timezone) : ''
                ];
            });
            return response()->json([
                'result' => true,
                'data' => $payments_arr
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'User id is missing.'
            ]);
        }
    }

    public function reviewPage($order_id, $user_id)
    {
        if ($order_id) {
            $chk_order = DB::table('rating_orders')->where('order_id', $order_id)->first();
            $features_arr = [];
            if ($chk_order && $chk_order->features != 'null' && $chk_order->features) {
                $features_arr = json_decode($chk_order->features);
            }
            $purchasing_concern_arr = [];
            if ($chk_order && $chk_order->purchasing_concern != 'null' && $chk_order->purchasing_concern) {
                $purchasing_concern_arr = json_decode($chk_order->purchasing_concern);
            }

            $tyre_products = DB::table('order_details')
            ->where('order_details.order_id', $order_id)
            ->where('order_details.type', 'T')
            ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('order_details.product_id','order_details.order_id','product_translations.name')
            ->get();

            $package_product = DB::table('order_details')
            ->where('order_details.order_id', $order_id)
            ->where('order_details.type', 'P')
            ->select('order_details.package_id')
            ->first();
            $package_review = DB::table('reviews')->select('id')->where('order_id', $order_id)->first();

            if ($package_product) {
                $package_data = [
                    'id' => $package_product->package_id,
                    'name' => translate('Package'),
                    'is_package_review_exists' => $package_review ? 'yes' : 'no'
                ];
            } else {
                $package_data = [
                    'id' => 0,
                    'name' => '',
                    'is_package_review_exists' => ''
                ];
            }
            $tyre_products_data = $tyre_products->map(function ($orderDetail) use ($user_id) {
                $commentable = false;
                    if (Review::where('order_id',$orderDetail->order_id)->where('user_id', $user_id)->where('product_id', $orderDetail->product_id)->first() == null) {
                        $commentable = true;
                    }
                $product_name = $orderDetail->name; 
                return [
                    'is_comment' => $commentable,
                    'product_name' => $product_name,
                    'product_id' => $orderDetail->product_id,
                ];
            });
            $data = [
                'order_id' => $order_id,
                'workshop_service' => ($chk_order && $chk_order->score) ? $chk_order->score : 0,
                'workshop_enviornment' => ($chk_order && $chk_order->workshop_enviornment) ? $chk_order->workshop_enviornment : 0,
                'website_use' => ($chk_order && $chk_order->website_use) ? $chk_order->website_use : 0,
                'money_of_product' => ($chk_order && $chk_order->money_of_product) ? $chk_order->money_of_product : 0,
                'buy_again' => ($chk_order && $chk_order->buy_again) ? $chk_order->buy_again : 0,
                'job_done_on_time' => $chk_order ? $chk_order->job_done_on_time : 'Yes',
                'features_arr' => $features_arr,
                'purchasing_concern_arr' => $purchasing_concern_arr,
                'improve_experience' => ($chk_order && $chk_order->description) ? $chk_order->description : '',
                'specification_of_products' => ($chk_order && $chk_order->specification_of_products) ? $chk_order->specification_of_products : '',
                'products_data' => $tyre_products_data,
                'is_package_present' => ($package_product)?true:false,
                'package_data' => $package_data
            ];
            return response()->json([
                'result' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Order id is missing.'
            ]);
        }
    }

    public function submitOrderReview(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->done_installation_status = 2;
        $order->update();
        $chk_order = DB::table('rating_orders')->where('order_id', $request->order_id)->first();
        if ($chk_order) {
            DB::table('rating_orders')->where('order_id', $request->order_id)->update([
                'score' => $request->workshop_service,
                'workshop_enviornment' => $request->workshop_enviornment,
                'job_done_on_time' => $request->job_done_on_time,
                'description' => $request->improve_experience,
                'features' => json_encode($request->features),
                'website_use' => $request->website_use,
                'money_of_product' => $request->money_of_product,
                'buy_again' => $request->buy_again,
                'purchasing_concern' => json_encode($request->purchasing_concern),
                'specification_of_products' => $request->specification_of_products
            ]);
        } else {
            DB::table('rating_orders')->insert([
                'user_id' => $request->user_id,
                'order_id' => $request->order_id,
                'seller_id' => DB::table('order_details')->where('order_id',$request->order_id)->first()->seller_id,
                'score' => $request->workshop_service,
                'workshop_enviornment' => $request->workshop_enviornment,
                'job_done_on_time' => $request->job_done_on_time,
                'description' => $request->improve_experience,
                'features' => json_encode($request->features),
                'website_use' => $request->website_use,
                'money_of_product' => $request->money_of_product,
                'buy_again' => $request->buy_again,
                'purchasing_concern' => json_encode($request->purchasing_concern),
                'specification_of_products' => $request->specification_of_products
            ]);
        }
        $shop = Shop::findOrFail($order->seller_id);
        $shop_reviews = DB::table('rating_orders')->where('seller_id', $shop->user_id)->count();
        if ($shop_reviews > 0) {
            $shop->rating = DB::table('rating_orders')->where('seller_id', $shop->user_id)->sum('score') / $shop_reviews;
        } else {
            $shop->rating = 0;
        }
        $shop->update();
        return response()->json([
            'result' => true,
            'message' => 'Order review has been submitted successfully'
        ]);
    }

    public function submitPackageReview(Request $request)
    {
        DB::table('reviews')->insert([
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'package_id' => $request->package_id,
            'rating' => $request->rating,
            'comment' => $request->description
        ]);

        // package review
        $package = Package::select('id', 'rating')->where('id', $request->package_id)->first();
        $package_reviews = DB::table('reviews')->where('package_id', $package->id)->where('status', 1)->count();
        if ($package_reviews) {
            $package->rating = Review::where('package_id', $package->id)->where('status', 1)->sum('rating') / $package_reviews;
        } else {
            $package->rating = 0;
        }
        $package->update();

        // package products review
        $package_products = DB::table('order_details')->where('order_id', $request->order_id)->where('package_id', $request->package_id)->select('product_id')->get();
        foreach($package_products as $package_product) {
            $review = new Review;
            $review->product_id = $package_product->product_id;
            $review->user_id = $request->user_id;
            $review->order_id = $request->order_id;
            $review->rating = $request->rating;
            $review->comment = $request->description;
            if ($review->save()) {
                $product = Product::select('id', 'rating')->where('id', $package_product->product_id)->first();
                $product_reviews = DB::table('reviews')->where('product_id', $product->id)->where('status', 1)->count();
                if ($product_reviews) {
                    $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating') / $product_reviews;
                } else {
                    $product->rating = 0;
                }
                $product->update();
            }
        }

        return response()->json([
            'result' => true,
            'message' => translate('Package review has been submitted successfully')
        ]);
    }

    public function storeProductReview(Request $request)
    {
        $review = new Review;
        $review->product_id = $request->product_id;
        $review->user_id = $request->user_id;
        $review->order_id = $request->order_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        if ($review->save()) {
            $product = Product::findOrFail($request->product_id);
            $product_reviews = Review::where('product_id', $product->id)->where('status', 1)->get();
            if (count($product_reviews) > 0) {
                $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating') / count($product_reviews);
            } else {
                $product->rating = 0;
            }
            $product->update();
            return response()->json([
                'result' => true,
                'message' => 'Product review has been submitted successfully'
            ], 200);
        }
        return response()->json([
            'result' => false,
            'message' => 'Something went wrong'
        ]);
    }

    public function carConditionList(Request $request)
    {
        $conditions = DB::table('user_car_conditions')->where('carlist_id', $request->vehicle_id)->get();
        $data = $conditions->map(function ($condition) {
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
            'data' => $data
        ]);
    }

    public function carConditionListDetails($list_id, $order_id = null)
    {
        if ($list_id != 0) {
            $condition = DB::table('user_car_conditions')->where('id', $list_id)->first();
        } else {
            $condition = DB::table('user_car_conditions')->where('order_id', $order_id)->first();
        }
        if ($condition) {
        $car_details = DB::table('car_lists')
        ->leftJoin('brands', 'brands.id', '=', 'car_lists.brand_id')
        ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
        ->leftJoin('car_years', 'car_years.id', '=', 'car_lists.year_id')
        ->leftJoin('car_variants', 'car_variants.id', '=', 'car_lists.variant_id')
        ->select('brands.name as brand_name', 'car_models.name as model_name', 'car_years.name as year_name',
        'car_variants.name as variant_name', 'car_lists.image', 'car_lists.car_plate')
        ->where('car_lists.id', $condition->carlist_id)
        ->first();

        $red = 0;
        $green = 0;
        $yellow = 0;

        $car_details_arr = [
            'id' => 0,
            'car_plate' => $car_details->car_plate,
            'brand_id' => 0,
            'model_id' => 0,
            'year_id' => 0,
            'variant_id' => 0,
            'brand_name' => $car_details->brand_name,
            'model_name' => $car_details->model_name,
            'year_name' => $car_details->year_name,
            'variant_name' => $car_details->variant_name,
            'image' => api_asset($car_details->image)
        ];

        $photos = explode(',', $condition->photos);
        $photos = collect($photos);
        $photos_arr = $photos->map(function ($photo) {
            return [
                'photo_path' => $photo ? uploaded_asset($photo) : static_asset('assets/img/placeholder.jpg'),
            ];
        });

        $interior_exterior_array = [];
        $battery_performance_array = [];
        $tyres_array = [];
        array_push($interior_exterior_array, $condition->horn_operation);
        array_push($interior_exterior_array, $condition->headlights);
        array_push($interior_exterior_array, $condition->front_wiper_blades);
        array_push($interior_exterior_array, $condition->rear_wiper_blade);
        array_push($interior_exterior_array, $condition->tail_lights);
        array_push($interior_exterior_array, $condition->in_cabin);
        array_push($interior_exterior_array, $condition->system_check_lights);
        array_push($interior_exterior_array, $condition->engine_oil);
        array_push($interior_exterior_array, $condition->coolant);
        array_push($interior_exterior_array, $condition->power);
        array_push($interior_exterior_array, $condition->brake_fluid);
        array_push($interior_exterior_array, $condition->windscreen);
        array_push($interior_exterior_array, $condition->automatic);
        array_push($interior_exterior_array, $condition->cooling_system);
        array_push($interior_exterior_array, $condition->radiator_case);
        array_push($interior_exterior_array, $condition->engine_air);
        array_push($interior_exterior_array, $condition->driver_belt);
        array_push($interior_exterior_array, $condition->front_shocks);
        array_push($interior_exterior_array, $condition->drivershaft);
        array_push($interior_exterior_array, $condition->subframe);
        array_push($interior_exterior_array, $condition->fluid_leaks);
        array_push($interior_exterior_array, $condition->brake_hose);
        array_push($interior_exterior_array, $condition->real_shocks);
        array_push($interior_exterior_array, $condition->differential);
        array_push($interior_exterior_array, $condition->exhuast);
        array_push($interior_exterior_array, $condition->wheel_bearing);

        array_push($battery_performance_array, $condition->battery_terminals);

        array_push($tyres_array, $condition->tyre_left_front);
        array_push($tyres_array, $condition->tyre_right_front);
        array_push($tyres_array, $condition->tyre_left_rear);
        array_push($tyres_array, $condition->tyre_right_rear);
        array_push($tyres_array, $condition->front_left_brake);
        array_push($tyres_array, $condition->right_left_brake);
        array_push($tyres_array, $condition->front_brake_disc);
        array_push($tyres_array, $condition->front_right_brake);
        array_push($tyres_array, $condition->rear_right_brake_pads);
        array_push($tyres_array, $condition->rear_brake_disc);
        array_push($tyres_array, $condition->rear_right_brake_shoes);
        array_push($tyres_array, $condition->rear_right_brake_cylinders);

        $red +=  count(array_keys($interior_exterior_array, "Red"));
        $green +=  count(array_keys($interior_exterior_array, "Green"));
        $yellow +=  count(array_keys($interior_exterior_array, "Yellow"));

        $red +=  count(array_keys($battery_performance_array, "Red"));
        $green +=  count(array_keys($battery_performance_array, "Green"));
        $yellow +=  count(array_keys($battery_performance_array, "Yellow"));

        $red +=  count(array_keys($tyres_array, "Red"));
        $green +=  count(array_keys($tyres_array, "Green"));
        $yellow +=  count(array_keys($tyres_array, "Yellow"));
           
        $car_info = [
            'red' => $red,
            'green' => $green,
            'yellow' => $yellow,
            'customer' => $condition->customer ? $condition->customer : '',
            'contact_no' => $condition->contact_number ? $condition->contact_number : '',
            'model' => $condition->model ? $condition->model : '',
            'number_plate' => $condition->number_plate ? $condition->number_plate : '',
            'mileage' => $condition->mileage ? $condition->mileage : '',
            'vin' => $condition->vin ? $condition->vin : '',
            'service_advisor' => $condition->service_advisor ? $condition->service_advisor : '',
            'techician' => $condition->techician ? $condition->techician : '',
            'car_condition_date' => $condition->car_condition_date ? date(env('DATE_FORMAT'), strtotime($condition->car_condition_date)) : '',
            'car_condition_time' => $condition->car_condition_time ? $condition->car_condition_time : '',
            'front_end_body' => $condition->front_end_body ? 'ok' : 'not ok',
            'rear_end_body' => $condition->rear_end_body ? 'ok' : 'not ok',
            'driver_side_body' => $condition->driver_side_body ? 'ok' : 'not ok',
            'pass_side_body' => $condition->pass_side_body ? 'ok' : 'not ok',
            'roof' => $condition->roof ? 'ok' : 'not ok',
            'windshield' => $condition->windshield ? 'ok' : 'not ok',
            'window_glass' => $condition->window_glass ? 'ok' : 'not ok',
            'wheels_rim' => $condition->wheels_rim ? 'ok' : 'not ok',
            'fuel_tank_cover' => $condition->fuel_tank_cover ? 'ok' : 'not ok',
            'wing_cover' => $condition->wing_cover ? 'ok' : 'not ok',
        ];

        $interior_exterior_data = [
            // interior/exterior
            'horn_operation' => $condition->horn_operation ? $condition->horn_operation : '',
            'headlights' => $condition->headlights ? $condition->headlights : '',
            'front_wiper_blades' => $condition->front_wiper_blades ? $condition->front_wiper_blades : '',
            'rear_wiper_blade' => $condition->rear_wiper_blade ? $condition->rear_wiper_blade : '',
            'tail_lights' => $condition->tail_lights ? $condition->tail_lights : '',
            'in_cabin' => $condition->in_cabin ? $condition->in_cabin : '',
            'system_check_lights' => $condition->system_check_lights ? $condition->system_check_lights : '',
            'interior_comment' => $condition->interior_comment ? $condition->interior_comment : '',
            // under hood
            'engine_oil' => $condition->engine_oil ? $condition->engine_oil : '',
            'coolant' => $condition->coolant ? $condition->coolant : '',
            'power' => $condition->power ? $condition->power : '',
            'brake_fluid' => $condition->brake_fluid ? $condition->brake_fluid : '',
            'windscreen' => $condition->windscreen ? $condition->windscreen : '',
            'automatic' => $condition->automatic ? $condition->automatic : '',
            'cooling_system' => $condition->cooling_system ? $condition->cooling_system : '',
            'radiator_case' => $condition->radiator_case ? $condition->radiator_case : '',
            'engine_air' => $condition->engine_air ? $condition->engine_air : '',
            'driver_belt' => $condition->driver_belt ? $condition->driver_belt : '',
            'under_hood_comment' => $condition->under_hood_comment ? $condition->under_hood_comment : '',
            // under vehicle
            'front_shocks' => $condition->front_shocks ? $condition->front_shocks : '',
            'drivershaft' => $condition->drivershaft ? $condition->drivershaft : '',
            'subframe' => $condition->subframe ? $condition->subframe : '',
            'subframe' => $condition->subframe ? $condition->subframe : '',
            'fluid_leaks' => $condition->fluid_leaks ? $condition->fluid_leaks : '',
            'brake_hose' => $condition->brake_hose ? $condition->brake_hose : '',
            'real_shocks' => $condition->real_shocks ? $condition->real_shocks : '',
            'differential' => $condition->differential ? $condition->differential : '',
            'exhuast' => $condition->exhuast ? $condition->exhuast : '',
            'wheel_bearing' => $condition->wheel_bearing ? $condition->wheel_bearing : '',
            'under_vehicle_comment' => $condition->under_vehicle_comment ? $condition->under_vehicle_comment : '',
            // photos
            'photos' => $photos_arr
        ];

        $battery_performance_data = [
            'battery_terminals' => $condition->battery_terminals ? $condition->battery_terminals : '',
            'battery_capacity_test' => $condition->battery_capacity_test ? $condition->battery_capacity_test : '',
            'battery_performance_comment' => $condition->battery_performance_comment ? $condition->battery_performance_comment : '',
        ];

        $tyres_data = [
            // tyres condition
            'tyre_left_front' => $condition->tyre_left_front ? $condition->tyre_left_front : '',
            'tyre_right_front' => $condition->tyre_right_front ? $condition->tyre_right_front : '',
            'tyre_left_rear' => $condition->tyre_left_rear ? $condition->tyre_left_rear : '',
            'tyre_right_rear' => $condition->tyre_right_rear ? $condition->tyre_right_rear : '',
            'tyre_comment' => $condition->tyre_comment ? $condition->tyre_comment : '',
            // brake condition
            'front_left_brake' => $condition->front_left_brake ? $condition->front_left_brake : '',
            'right_left_brake' => $condition->right_left_brake ? $condition->right_left_brake : '',
            'front_brake_disc' => $condition->front_brake_disc ? $condition->front_brake_disc : '',
            'front_right_brake' => $condition->front_right_brake ? $condition->front_right_brake : '',
            'rear_right_brake_pads' => $condition->rear_right_brake_pads ? $condition->rear_right_brake_pads : '',
            'rear_brake_disc' => $condition->rear_brake_disc ? $condition->rear_brake_disc : '',
            'rear_right_brake_shoes' => $condition->rear_right_brake_shoes ? $condition->rear_right_brake_shoes : '',
            'rear_right_brake_cylinders' => $condition->rear_right_brake_cylinders ? $condition->rear_right_brake_cylinders : '',
            'brake_condition_comment' => $condition->brake_condition_comment ? $condition->brake_condition_comment : '',
        ];
        return response()->json([
            'result' => true,
            'car_details' => $car_details_arr,
            'car_info' => $car_info,
            'interior_exterior_data' => $interior_exterior_data,
            'battery_performance_data' => $battery_performance_data,
            'tyres_data' => $tyres_data
        ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'No data found.'
            ]);
        }
    }

    public function track_order($order_id)
    {
        $order = DB::table('orders')->where('orders.id', $order_id)
        ->leftJoin('car_lists as cl', 'cl.id','orders.carlist_id')
        ->leftJoin('shops', 'shops.id','orders.seller_id')
        ->select('orders.id','orders.code','shops.name as shop_name','shops.rating as shop_rating','orders.workshop_date',
        'orders.workshop_time','shops.phone','cl.image as car_image','cl.car_plate','orders.delivery_status','orders.start_installation_status',
        'orders.notify_user_come_to_workshop_to_review_car')
        ->first();

        $order_details = DB::table('order_details')->where('order_id', $order->id)->select('received_status')->first();
        // 0 = not started
        // 1 = done
        // 2 = in progress
        $collected = 0;
        $service_start = 0; 
        $product_recieved = 0; 
        $installation_satus = 0; 
        $ready_for_collection = 0; 
        if($order->delivery_status != 'pending' || $order->delivery_status != 'cancelled' || $order->delivery_status != 'Rejected'){
            $service_start = 1; 
        }

        if($order_details->received_status == 'Received'){
            $product_recieved = 1; 
        }

        if($order->start_installation_status == 1){
            $installation_satus = 2; 
        }
        else if($order->notify_user_come_to_workshop_to_review_car == 1){
            $installation_satus = 1; 
        }

        if($order->notify_user_come_to_workshop_to_review_car == 1){
            $ready_for_collection = 1; 
        }

        if($order->delivery_status == 'completed' || $order->delivery_status == 'Done'){
            $collected = 1; 
        }
        $data = [
            'code' => $order->code,
            'shop_name' => $order->shop_name,
            'shop_rating' => $order->shop_rating,
            'slot_time' => $order->workshop_date ? date(env('DATE_FORMAT'), strtotime($order->workshop_date)).' '.$order->workshop_time : '',
            'phone_no' => $order->phone,
            'car_image' => api_asset($order->car_image),
            'car_plate' => $order->car_plate,
            'service_start' => $service_start,
            'products_recieved_by_workshop' => $product_recieved,
            'installation' => $installation_satus,
            'ready_for_collection' => $ready_for_collection,
            'collected' => $collected
        ];
        return response()->json([
            'result' => true,
            'data' => $data
        ]);
    }

    public function scanBatteryWarrantyQR(Request $request)
    {
        $data = DB::table('orders')
        ->where('id', $request->order_id)
        ->whereNull('warranty_activation_date')
        ->where('user_id', $request->user_id)
        ->select('payment_status', 'delivery_status', 'battery_expiry_months', 'warranty_activation_date')
        ->first();
        if (!$data) {
            return response()->json([
                'result' => false,
                'rewards' => [],
                'battery_data' => [],
                'message' => 'Battery QR is invalid'
            ]);
        }
        
        if ($data->payment_status != 'paid') {
            return response()->json([
                'result' => false,
                'rewards' => [],
                'battery_data' => [],
                'message' => 'Order against this battery is unpaid'
            ]);
        }
        if ($data->delivery_status != 'completed') {
            return response()->json([
                'result' => false,
                'rewards' => [],
                'battery_data' => [],
                'message' => 'Order is not completed yet please wait for order completion'
            ]);
        }
        if ($data->warranty_activation_date) {
            return response()->json([
                'result' => false,
                'rewards' => [],
                'battery_data' => [],
                'message' => 'Warranty activation is already done for this battery'
            ]);
        }
        $user_id = $request->user_id;
        // save user uploaded image
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
        );
        $dir = public_path('uploads/battery_activation/');
        $file = $request->file('photo');
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(" ", "-", rand(10000000000,9999999999).date("YmdHis").$file->getClientOriginalName());

        $upload = new Upload();
        $size = $file->getSize();
        if (!isset($type[$extension])) {
            return response()->json([
                'result' => false,
                'rewards' => [],
                'battery_data' => [],
                'message' => 'Only image can be uploaded'
            ]);
        }

        if (env('FILESYSTEM_DRIVER') == 's3') {
            $newPath = "uploads/battery_activation/$filename";
            Storage::disk('s3')->put($newPath, file_get_contents(base_path('public/') . $newPath));
        }
        else{
            $file->move($dir,$filename);
        }

        $upload->file_original_name = $file->getClientOriginalName();
        $upload->extension = $extension;
        $upload->file_name = 'uploads/battery_activation/'.$filename;
        $upload->user_id = $user_id;
        $upload->type = $type[$upload->extension];
        $upload->file_size = $size;
        $upload->save();
        $photo = $upload->id;

        // check if order is a package
        $warranty_activation_date = date('Y-m-d');
        $expiry_notification_date = NULL;
        if ($data->battery_expiry_months) {
            // calculate next notification date and package expiry date
            $datediff = (strtotime(date('Y-m-d') . ' +' . $data->battery_expiry_months . ' months') - strtotime(date('Y-m-d')));
            $days = round($datediff / (60 * 60 * 24));
            if ($days > 30) {
                $next_notification = $days - 30;
                $expiry_notification_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $next_notification . ' days'));
            } elseif ($days == 7) {
                $next_notification = 7 - $days;
                $expiry_notification_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $next_notification . ' days'));
            } elseif ($days == 2) {
                $expiry_notification_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . 1 . ' days'));
            }
        }

        $rewards = DB::table('coupons')->where('type', 'warranty_reward')
        ->where('start_date', '<=' ,strtotime(date('Y-m-d')))
        ->where('end_date', '>=', strtotime(date('Y-m-d')))
        ->where('limit', '>', 0)
        ->where(function ($query) use($user_id) {
            $query->whereJsonDoesntContain('claimed_user_id', $user_id)
            ->orWhere('claimed_user_id', null);
        })
        ->select('id')
        ->get()
        ->toArray();
        DB::table('orders')->where('id', $request->order_id)->update([
            'warranty_activation_date' => $warranty_activation_date,
            'expiry_notification_date' => $expiry_notification_date,
        ]);
        $image_exists = BatteryActivationImage::where('order_id', $request->order_id)->where('user_id', $user_id)->first();
        if($image_exists){
            $image_exists->image = $photo;
            $image_exists->update();
        }
        else{
        $battery_millage_image = new BatteryActivationImage();
        $battery_millage_image->user_id = $user_id;
        $battery_millage_image->order_id = $request->order_id;
        $battery_millage_image->image = $photo;
        $battery_millage_image->save();
        }

        $battery_data = DB::table('orders')
        ->where('orders.id', $request->order_id)
        ->leftJoin('order_details as od', 'od.order_id', 'orders.id')
        ->leftJoin('batteries', 'od.product_id', 'batteries.id')
        ->select('orders.battery_expiry_months', 'orders.warranty_activation_date', 'orders.car_plate', 'orders.model_name', 'batteries.attachment_id',
        'batteries.name','batteries.model')
        ->first();
        $battery_data_arr =  [
                'name' => $battery_data->name,
                'model' => $battery_data->model,
                'car_plate' => $battery_data->car_plate,
                'car_model' => $battery_data->model_name,
                'activation_date' => ($battery_data->warranty_activation_date != null) ? date(env('DATE_FORMAT'), strtotime($battery_data->warranty_activation_date)): '',
                'warranty_period' => $battery_data->battery_expiry_months.' months',
                'image' => $battery_data->attachment_id ? api_asset($battery_data->attachment_id) : ''
            ];

        return response()->json([
            'result' => true,
            'rewards' => $rewards,
            'battery_data' => $battery_data_arr,
            'message' => '',
        ]);
    }

    public function claimBatteryWarrantyReward(Request $request)
    {
        $inserted_data = DB::table('coupons')->where('id', $request->coupon_id)->select('claimed_user_id')->first();
        if($inserted_data->claimed_user_id == null){
            $claimed_user_id = json_encode([]);
        }
        else{
            $claimed_user_id = $inserted_data->claimed_user_id;
        }
        $arr1 = json_decode($claimed_user_id, true);
        $arr2 = (array) $request->user_id;
        $new_arr = array_merge($arr1, $arr2);
        DB::table('coupons')->where('id', $request->coupon_id)->update(['claimed_user_id' => json_encode($new_arr)]);
        return response()->json([
            'result' => true,
            'message' => 'Claimed successfully'
        ]);
    }

    public function carlistOrders(Request $request)
    {
        $normal_orders = Order::where('order_type', 'N')->where('carlist_id', $request->carlist_id)
        ->select('id','code','model_name','car_plate','date','grand_total','delivery_status','payment_status')
        ->orderBy('id', 'desc')->get();
        $timezone = user_timezone($request->user_id);
        $normal_orders_arr = $normal_orders->map(function ($order) use ($timezone) {
            return [
                'id' => $order->id,
                'code' => $order->code,
                'model_name' => $order->model_name,
                'car_plate' => $order->car_plate,
                'date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), $timezone),
                'amount' => single_price($order->grand_total),
                'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'delivery_status' => $order->delivery_status,
                'payment_status' => $order->payment_status,
            ];
        });

        $emergency_orders = Order::whereIn('order_type', ['B','P','T'])->where('carlist_id', $request->carlist_id)
        ->select('id','code','model_name','car_plate','date','grand_total','delivery_status','payment_status')
        ->orderBy('id', 'desc')->get();
        $emergency_orders_arr = $emergency_orders->map(function ($order) use ($timezone) {
            return [
                'id' => $order->id,
                'code' => $order->code,
                'model_name' => $order->model_name,
                'car_plate' => $order->car_plate,
                'date' => convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), $timezone),
                'amount' => single_price($order->grand_total),
                'status' => translate(ucfirst(str_replace('_', ' ', $order->delivery_status))),
                'delivery_status' => $order->delivery_status,
                'payment_status' => $order->payment_status,
            ];
        });

        return response()->json([
            'result' => true,
            'normal_orders' => $normal_orders_arr,
            'emergency_orders' => $emergency_orders_arr
        ]); 
    }

    public function completeUserOrder($order_id)
    {
        $order = Order::find($order_id);
        $order->delivery_status = 'Done';
        // check if order is a package
        if (DB::table('order_details')->select('package_id')->where('order_id', $order_id)->where('package_id', '!=', NULL)->first()) {
            $order->installation_completed_date = date('Y-m-d');
            // calculate next notification date and package expiry date
            $datediff = (strtotime(date('Y-m-d') . ' +' . $order->package_expiry_months . ' months') - strtotime(date('Y-m-d')));
            $days = round($datediff / (60 * 60 * 24));
            if ($days > 30) {
                $next_notification = $days - 30;
                $expiry_notification_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $next_notification . ' days'));
            } elseif ($days == 7) {
                $next_notification = 7 - $days;
                $expiry_notification_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $next_notification . ' days'));
            } elseif ($days == 2) {
                $expiry_notification_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . 1 . ' days'));
            } else {
                $expiry_notification_date = NULL;
            }
            $order->expiry_notification_date = $expiry_notification_date;
        }
        $order->update();

        return response()->json([
            'result' => true,
            'message' => 'Order completed successfully'
        ]); 
    }

    public function cancel_order($order_id)
    {
        $order = Order::find($order_id);
        $order->delivery_status = 'cancelled';
        $order->update();
        foreach ($order->orderDetails as $orderDetail) {
            if($order->order_type == "N"){
                    $product = Product::where('id', $orderDetail->product_id)->first();
                    if ($product != null) {
                        $product->qty += $orderDetail->quantity;
                        $product->update();
                    }
                }
                else if($order->order_type == "B" && $order->battery_type == "N"){
                    $product = Battery::where('id', $orderDetail->product_id)->first();
                    if ($product != null) {
                        $product->stock += $orderDetail->quantity;
                        $product->update();
                    }
                }
        }
           
        // Generate Notification to admin
        \App\Models\Notification::create([
            'user_id' => User::where('user_type', 'admin')->select('id')->first()->id,
            'is_admin' => 1,
            'type' => 'order',
            'body' => translate('Order status has been updated') . ' - cancelled',
            'order_id' => $order->id,
        ]);
        // Generate Notification to customer
        \App\Models\Notification::create([
            'user_id' => $order->user_id,
            'is_admin' => 3,
            'type' => 'order',
            'body' => translate('Your order status has been updated') . ' - cancelled',
            'order_id' => $order->id,
        ]);
        try {
            // Send firebase notification to customer
            $device_token = DB::table('device_tokens')->where('user_id', $order->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Your order status has been updated') . ' - cancelled'
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        
        if($order->order_type == "N")
        {
        // Generate Notification to workshop
        $shop = Shop::where('id',$order->seller_id)->select('user_id')->first();
        \App\Models\Notification::create([
            'user_id' => $shop->user_id,
            'is_admin' => 2,
            'type' => 'order',
            'body' => translate('Your order status has been updated') . ' - cancelled',
            'order_id' => $order->id,
        ]);
         try {
            // Send firebase notification to workshop
            $device_token = DB::table('device_tokens')->where('user_id', $shop->user_id)->select('token')->get()->toArray();
            $array = array(
                'device_token' => $device_token,
                'title' => translate('Your order status has been updated') . ' - cancelled'
            );
            send_firebase_notification($array);
        } catch (\Exception $e) {
            // dd($e);
        }
        }
        return response()->json([
            'result' => true,
            'message' => 'Order has been cancelled successfully'
        ]); 
    }

    public function show_message_content(Request $request)
    {
        $data = DB::table('notifications')->where('id', $request->id)->select('content')->first();
        return response()->json([
            'result' => true,
            'data' => $data->content
        ]); 
    }

}
