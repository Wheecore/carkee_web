<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Coupon;
use App\User;
use Illuminate\Support\Str;
use App\Mail\InvoiceEmailManager;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Ipay88Controller extends Controller
{
    public function getCheckout()
    {
        $amount = 0;
        $order = Order::findOrFail(Session::get('order_id'));
        if (Session::has('date_change_request') && Session::get('date_change_request') == 1) {
            $amount = round(20 * 100);
        } else {
            $amount = round($order->grand_total);
        }
        Session::put('order_amount', $amount);
        $currency = 'MYR';
        $hash = $this->generateSignature(env('IPAY88_MERCHANT_KEY'), env('IPAY88_MERCHANT_CODE'), $order->code, $amount, $currency);
        Session::put('sha256', $hash);

        return view('frontend.payment.ipay88', compact('order', 'hash', 'amount'));
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

    public function _hex2bin($source)
    {
        $bin = '';
        for ($i = 0; $i < strlen($source); $i += 2) {
            $bin .= chr(hexdec(substr($source, $i, 2)));
        }
        return $bin;
    }

    public function response(Request $request)
    {
        $merchantcode = $request->request->get('MerchantCode');
        $paymentid = $request->request->get('PaymentId');
        $refno = $request->request->get('RefNo');
        $amount = $request->request->get('Amount');
        $ecurrency = $request->request->get('Currency');
        $remark = $request->request->get('Remark');
        $transid = $request->request->get('TransId');
        $authcode = $request->request->get('AuthCode');
        $estatus = $request->request->get('Status');
        $errdesc = $request->request->get('ErrDesc');
        $signature = $request->request->get('Signature');
        $ccname = $request->request->get('CCName');
        $ccno = $request->request->get('CCNo');
        $s_bankname = $request->request->get('S_bankname');
        $s_country = $request->request->get('S_country');

        $data = env('IPAY88_MERCHANT_KEY') . $merchantcode . $paymentid . $refno . $amount . 'MYR' . $estatus;
        // $hash = hash('sha256', $data);

        if ($estatus == 1) {
            if (Session::has('date_change_request') && Session::get('date_change_request') == 1) {
                $order = Order::where('id', Session::get('order_id'))->update([
                    'workshop_date' => Session::get('wdate'),
                    'workshop_time' => Session::get('wtime'),
                    'availability_id' => Session::get('availability_id'),
                    'user_date_update' => 1
                ]);
                Session::forget('order_id');
                Session::forget('wdate');
                Session::forget('wtime');
                Session::forget('availability_id');
                Session::forget('date_change_request');
                flash(translate('updated successfully'))->success();
                return redirect('purchase_history');
            } else {
                $payment = ["status" => "Success"];

                $obj = array(
                    'paymentid' => $paymentid,
                    'refno' => $refno,
                    'amount' => $amount,
                    'ecurrency' => $ecurrency,
                    'remark' => $remark,
                    'transid' => $transid,
                    'ccname' => $ccname,
                    'ccno' => $ccno,
                    's_bankname' => $s_bankname,
                    's_country' => $s_country,
                );

                $order = Order::findOrFail(Session::get('order_id'));
                $order->payment_details = json_encode($obj);
                $order->save();

                $start_date = date('d-m-Y', strtotime(Carbon::now()));
                $end_date_format = Carbon::now()->addDays(30);
                $end_date = date('d-m-Y', strtotime($end_date_format));

                $coupon = new Coupon;
                if (Auth::user()->referred_by && Auth::user()->referral_status == 0) {
                    $coupon->user_id = Auth::user()->referred_by;
                    $coupon->type             = 'cart_base';
                    $coupon->code             = Str::random(11);
                    $coupon->discount         = 10;
                    $coupon->discount_type    = 'amount';
                    $coupon->start_date       = strtotime($start_date);
                    $coupon->end_date         = strtotime($end_date);
                    $coupon->details = '{"min_buy":"3","max_discount":"5"}';
                    $coupon->limit         = 1;

                    $coupon->save();

                    DB::table('users')->where('id', Auth::id())->update([
                        'referral_status' => 1
                    ]);
                }

                $array['view'] = 'emails.invoice';
                $array['subject'] = translate('Your order has been placed') . ' - ' . $order->code;
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['order'] = $order;

                //sends email to customer with the invoice pdf attached
                if (env('MAIL_USERNAME') != null) {
                    try {
                        Mail::to(Auth::user()->email)->queue(new InvoiceEmailManager($array));
                        Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                    } catch (\Exception $e) {
                    }
                }
                Cart::where('id', Session::get('session_cart_id'))->delete();
                try {
                    $payment_type = Session::get('payment_type');
                    if ($payment_type == 'cart_payment') {
                        $checkoutController = new \App\Http\Controllers\CheckoutController;
                        return $checkoutController->checkout_done(session()->get('order_id'), json_encode($payment));
                    }
                    if ($payment_type == 'wallet_payment') {
                        $walletController = new WalletController;
                        return $walletController->wallet_payment_done(session()->get('payment_data'), json_encode($payment));
                    }
                } catch (\Exception $e) {
                    flash(translate('Payment failed'))->error();
                    return redirect()->route('home');
                }
            }
        } else {
            flash(translate('Payment failed'))->error();
            return redirect()->route('home');
        }
    }

    public function backend(Request $request)
    {
        echo 'RECEIVEOK';
        // dd($request);
        // flash(translate('Payment is cancelled'))->error();
        // return redirect()->route('home');
    }

    public function requery($MerchantCode, $RefNo, $Amount)
    {
        $query = "https://payment.ipay88.com.my/epayment/enquiry.asp?MerchantCode=" .
            $MerchantCode . "&RefNo=" . $RefNo . "&Amount=" . $Amount;
        $url = parse_url($query);
        $host = $url["host"];
        $sslhost = "ssl://" . $host;
        $path = $url["path"] . "?" . $url["query"];
        $timeout = 5;
        $fp = fsockopen($sslhost, 443, $errno, $errstr, $timeout);
        if ($fp) {
            fputs($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
            while (!feof($fp)) {
                $buf .= fgets($fp, 128);
            }
            $lines = preg_split("/\n/", $buf);
            $response = $lines[count($lines) - 1];
            fclose($fp);
        } else {
            # enter error handing code here
        }
        return $response;
    }

    public function cancel(Request $request)
    {
        flash(translate('Payment is cancelled'))->error();
        return redirect()->route('home');
    }
}
