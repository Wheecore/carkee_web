<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SellerPackage;
use Carbon\Carbon;
use App\Models\Coupon;
use App\User;
use Illuminate\Support\Str;
use App\Mail\InvoiceEmailManager;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('frontend.payment.stripe');
    }

    public function create_checkout_session(Request $request)
    {
        $amount = 0;
        if ($request->session()->has('payment_type')) {
            if ($request->session()->get('payment_type') == 'cart_payment') {
                $order = Order::findOrFail(Session::get('order_id'));
                if (Session::has('date_change_request') && Session::get('date_change_request') == 1) {
                    $amount = round(20 * 100);
                } else {
                    $amount = round($order->grand_total * 100);
                }
            } elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                $amount = round($request->session()->get('payment_data')['amount'] * 100);
            } elseif ($request->session()->get('payment_type') == 'seller_package_payment') {
                $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
                $amount = round($seller_package->amount * 100);
            }
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code,
                        'product_data' => [
                            'name' => "Payment"
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return response()->json(['id' => $session->id, 'status' => 200]);
    }

    public function success()
    {

        $order = Order::findOrFail(Session::get('order_id'));
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

            $order = Order::where('id', Session::get('order_id'))->first();
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
                $payment = ["status" => "Success"];

                $payment_type = Session::get('payment_type');

                if ($payment_type == 'cart_payment') {
                    $checkoutController = new CheckoutController;
                    return $checkoutController->checkout_done(session()->get('order_id'), json_encode($payment));
                }
            } catch (\Exception $e) {
                flash(translate('Payment failed'))->error();
                return redirect()->route('home');
            }
        }
    }
    public function cancel(Request $request)
    {
        flash(translate('Payment is cancelled'))->error();
        return redirect()->route('home');
    }
}
