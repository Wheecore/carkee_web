<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\Api\V2\CheckoutController;
use App\Http\Controllers\Api\V2\WalletController;
use stdClass;

class Ipay88Controller extends Controller
{
    public function getCheckout($order_id, $type = null, $wallet_amount = null)
    {
        if($type == 'wallet_recharge'){
            // consider order_id as wallet_id
            return response()->json([
                'result' => true,
                'url' => url('api/v2/ipay-webview/'.$order_id.'/'.$type).'?amount='.$wallet_amount
            ]);
        }
        else{
        return response()->json([
            'result' => true,
            'url' => url('api/v2/ipay-webview/'.$order_id.'/'.$type)
        ]);
    }
    }

    public function ipayWebView($order_id, $reschedule = null)
    {
        $data_arr = [];
        $currency = 'MYR';
        $data_arr['reschedule'] = $reschedule;
        if($reschedule == 'wallet_recharge'){
            $data_arr['order_id'] = $order_id;
            $user_data = DB::table('wallets')->where('id', $order_id)->select('user_id')->first();
            $data_arr = json_encode($data_arr);
            $amount = request('amount');
            $order = new stdClass();
            $order->code = time();
            $hash = $this->generateSignature(env('IPAY88_MERCHANT_KEY'), env('IPAY88_MERCHANT_CODE'), $order->code, $amount, $currency);
            $user = DB::table('users')->where('id', $user_data->user_id)->select('name', 'email', 'phone')->first();
            return view('frontend.payment.ipay88_webview', compact('currency', 'order', 'hash', 'amount', 'user', 'data_arr'));
        }
        else if (in_array($reschedule, ['bypass_payment'])){
            $order = Order::findOrFail($order_id);
            return view('frontend.order_invoice', compact('order'));
        }
        else{
        $order = Order::findOrFail($order_id);
        $user = DB::table('users')->where('id', $order->user_id)->select('name', 'email', 'phone')->first();
        if ($reschedule == 'yes') {
            // just for bypass payment then will remove this
            $order = Order::find($order_id);
            $obj = array(
                'status' => 'Success',
                'paymentid' => 1234,
                'refno' => $order->code,
                'amount' => env('RESCHEDULE_FEE'),
                'ecurrency' => 'MYR',
                'transid' => 123
            );
            $data_arr['workshop_date'] = request('wd');
            $data_arr['workshop_time'] = request('wt');
            $data_arr['availability_id'] = request('aid');
            
            $checkoutController = new CheckoutController;
            $checkoutController->reschedule_done($order_id, $data_arr, json_encode($obj));
            return view('frontend.payment.reschedule_success', compact('order'));
            // remove until this

            $data_arr['workshop_date'] = request('wd');
            $data_arr['workshop_time'] = request('wt');
            $data_arr['availability_id'] = request('aid');
            $amount = round(env('RESCHEDULE_FEE'));
        }
        else{
         $amount = round($order->grand_total);
        }
        $data_arr['order_id'] = $order_id;
        $data_arr = json_encode($data_arr);
        $hash = $this->generateSignature(env('IPAY88_MERCHANT_KEY'), env('IPAY88_MERCHANT_CODE'), $order->code, $amount, $currency);
        return view('frontend.payment.ipay88_webview', compact('currency', 'order', 'hash', 'amount', 'user', 'data_arr'));
        }
    }

    public function response(Request $request)
    {
        $paymentid = $request->request->get('PaymentId');
        $refno = $request->request->get('RefNo');
        $amount = $request->request->get('Amount');
        $ecurrency = $request->request->get('Currency');
        $transid = $request->request->get('TransId');
        $estatus = $request->request->get('Status');
        $remark = $request->request->get('Remark');
        $data_arr = json_decode($remark, true);
        $reschedule = $data_arr['reschedule'];
        $order_id = $data_arr['order_id'];

        if ($estatus == 1) {
            $obj = array(
                'status' => 'Success',
                'paymentid' => $paymentid,
                'refno' => $refno,
                'amount' => $amount,
                'ecurrency' => $ecurrency,
                'transid' => $transid
            );

            if ($reschedule == 'yes') {
                $checkoutController = new CheckoutController;
                $checkoutController->reschedule_done($order_id, $data_arr, json_encode($obj));
                $order = Order::find($order_id);
                return view('frontend.payment.reschedule_success', compact('order'));
            } 
            else if ($reschedule == 'wallet_recharge') {
                $walletController = new WalletController;
                // consider order_id as wallet_id
                $walletController->wallet_recharge_done($order_id, json_encode($obj));
                return view('frontend.payment.wallet_success');
            } else {
                $checkoutController = new CheckoutController;
                $checkoutController->checkout_done($order_id, json_encode($obj));
                $order = Order::find($order_id);
                return view('frontend.order_invoice', compact('order', 'reschedule'));                
            }
        } else {
            if (in_array($reschedule, ['wallet_recharge'])) {
                $walletController = new WalletController;
                // consider order_id as wallet_id
                $walletController->wallet_recharge_failed($order_id);
                return view('frontend.payment.reschedule_failed');
            }
            else if (in_array($reschedule, ['yes'])) {
                return view('frontend.payment.reschedule_failed');
            }
            else{
                $checkoutController = new CheckoutController;
                $checkoutController->checkout_failed($order_id);
                return view('frontend.payment.ipay88_failed_webview');
            }
        }
    }

    public function backend(Request $request)
    {
        echo 'RECEIVEOK';
    }

    public function byPassPayment($order_id, $type = null)
    {
        $payment = ["status" => "Success"];
        $checkoutController = new CheckoutController;
        $checkoutController->checkout_done($order_id, json_encode($payment));
        return response()->json([
            'result' => true,
            'url' => url('api/v2/ipay-webview/' . $order_id . '/' . $type)
        ]);
    }

    public function byPassWalletPayment($wallet_id)
    {
        $payment = ["status" => "Success"];
        $walletController = new WalletController;
        $walletController->wallet_recharge_done($wallet_id, json_encode($payment));
        return response()->json([
            'result' => true,
            'url' => url('api/v2/wallet-webview')
        ]);
    }

    public function wallet_webview()
    {
        return view('frontend.payment.wallet_success');
    }

    public function generateSignature($merchant_key, $MerchantCode, $RefNo, $amount, $currency)
    {
        $signature = '';
        $signature .= $merchant_key;
        $signature .= $MerchantCode;
        $signature .= $RefNo;
        $signature .= str_replace('.', '', str_replace(',', '', $amount));
        $signature .= $currency;
        // Hash the signature.
        $signature = hash('sha256', $signature);

        return $signature;
    }
}
