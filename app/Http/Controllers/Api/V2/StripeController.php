<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\V2\CheckoutController;
use App\Models\BusinessSetting;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Order;

class StripeController extends Controller
{
    public function stripe(Request $request, $payment_type, $order_id, $amount)
    {
        $user_id = $request->user_id;
        $html = view('frontend.payment.stripe_app', compact('payment_type', 'order_id', 'amount', 'user_id'))->render();
        return response()->json([
            'result' => true,
            'htmlCode' => $html,
        ]);
    }

    public function create_checkout_session(Request $request)
    {
        $amount = 0;
        if ($request->payment_type == 'cart_payment') {
            $order = Order::findOrFail($request->order_id);
            $amount = round($order->grand_total * 100);
        } elseif ($request->payment_type == 'wallet_payment') {
            $amount = round($request->amount * 100);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => Currency::findOrFail(BusinessSetting::where('type', 'system_default_currency')->first()->value)->code,
                        'product_data' => [
                            'name' => "Payment"
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('api.stripe.success', ["payment_type" => $request->payment_type, "order_id" => $request->order_id, "amount" => $request->amount, "user_id" => $request->user_id]),
            'cancel_url' => route('api.stripe.cancel'),
        ]);

        return response()->json(['id' => $session->id, 'status' => 200]);
    }

    public function success(Request $request)
    {
        try {
            $payment = ["status" => "Success"];
            $payment_type = 'cart_payment';
            if ($payment_type == 'cart_payment') {
                $checkout_controller = new CheckoutController;
                $result = $checkout_controller->checkout_done($request->order_id, json_encode($payment), $request->cart_id);
            }
            return response()->json([
                'result' => true,
                'inoice' => $result,
                'message' => "Payment is successful"
            ]);
        } catch (\Exception $e) {
            return response()->json(['result' => false, 'message' => "Payment is unsuccessful"]);
        }
    }

    public function cancel(Request $request)
    {
        return response()->json(['result' => false, 'message' => "Payment is cancelled"]);
    }
}
