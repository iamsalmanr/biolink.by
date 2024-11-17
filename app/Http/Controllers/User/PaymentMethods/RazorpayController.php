<?php

namespace App\Http\Controllers\User\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\CheckoutController;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{

    /**
     * Process the payment
     *
     * @param Transaction $transaction
     */
    public static function pay(Transaction $transaction)
    {

        $gateway = PaymentGateway::where('key', 'razorpay')->first();

        $title = "Payment for " . $transaction->details->title . " Plan (" . $transaction->details->interval .')';

        $fees = ($transaction->total * $gateway->fees) / 100;
        $price = round(($transaction->total + $fees), 2);
        $price = $price * 100; // convert to paisa

        try {
            $api = new Api($gateway->credentials->key_id, $gateway->credentials->key_secret);
            $order = $api->order->create([
                'receipt' => (string)$transaction->id,
                'amount' => $price,
                'currency' => config('settings.currency')->code,
                'payment_capture' => '0',
            ]);

            $order_id = $order['id'];
            $details = [
                'key' => $gateway->credentials->key_id,
                'name' => config('settings.site_title'),
                'currency' => config('settings.currency')->code,
                'amount' => $price,
                'order_id' => $order_id,
                'description' => $title,
                'prefill.name' => request()->user()->name,
                'prefill.email' => request()->user()->email,
                'theme.color' => config('settings.colors')->primary_color,
                'buttontext' => ___('Pay Now'),
                'image' => '',
            ];

            $transaction->update(['payment_id' => $order_id, 'fees' => $fees]);

            /* display payment gateway form */
            return view(active_theme()."user.gateways." . $gateway->key, compact('details', 'transaction'));
        } catch (\Exception $e) {
            error_log($e->getMessage());
            quick_alert_error($e->getMessage());
            return back();
        }
    }

    /**
     * Handle the IPN
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function ipn(Request $request)
    {
        try {
            $order_id = $request->razorpay_order_id;

            $transaction = Transaction::where([
                ['user_id', request()->user()->id],
                ['payment_id', $order_id],
                ['status', Transaction::STATUS_UNPAID],
            ])->first();

            if (is_null($transaction)) {
                quick_alert_error(___('Invalid transaction, please try again.'));
                return redirect()->route('subscription');
            }

            $gateway = PaymentGateway::where('key', 'razorpay')->first();

            $signature = hash_hmac('sha256', $request->razorpay_order_id . "|" . $request->razorpay_payment_id, $gateway->credentials->key_secret);

            if ($signature == $request->razorpay_signature) {
                $update = $transaction->update([
                    'gateway' => $gateway->id,
                    'payment_id' => $request->razorpay_payment_id,
                    'total' => ($transaction->total + $transaction->fees),
                    'status' => Transaction::STATUS_PAID,
                ]);
                if ($update) {
                    CheckoutController::updateUserPlan($transaction);
                    quick_alert_success(___('Payment successful'));
                }
            } else {
                quick_alert_error(___('Payment failed, please try again.'));
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            quick_alert_error(___('Payment failed, please try again.'));
        }

        return redirect()->route('subscription');
    }
}
