<?php

namespace App\Http\Controllers\User\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\CheckoutController;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * Process the payment
     *
     * @param Transaction $transaction
     */
    public static function pay(Transaction $transaction)
    {

        $gateway = PaymentGateway::where('key', 'stripe')->first();

        $title = "Payment for " . $transaction->details->title . " Plan (" . $transaction->details->interval .')';

        $fees = ($transaction->total * $gateway->fees) / 100;
        $price = round(($transaction->total + $fees), 2);
        $price = $price * 100;

        try {
            Stripe::setApiKey($gateway->credentials->secret_key);
            $session = Session::create([
                'line_items' => [[
                    'price_data' => [
                        'product_data' => [
                            'name' => $title,
                            'description' => $title,
                        ],
                        'unit_amount' => $price,
                        'currency' => config('settings.currency')->code,
                    ],
                    'quantity' => 1,
                ]],
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'cancel_url' => route('subscription'),
                'success_url' => route('ipn.stripe') . '?payment_id={CHECKOUT_SESSION_ID}',
            ]);

            if ($session) {
                $transaction->update(['payment_id' => $session->id, 'fees' => $fees]);

                /* redirect to payment gateway page */
                return redirect($session->url);
            }
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
            $gateway = PaymentGateway::where('key', 'stripe')->first();

            Stripe::setApiKey($gateway->credentials->secret_key);

            $payment_id = $request->payment_id;
            $transaction = Transaction::where([
                ['user_id', request()->user()->id],
                ['status', Transaction::STATUS_UNPAID],
                ['payment_id', $payment_id],
            ])->first();

            if (is_null($transaction)) {
                quick_alert_error(___('Invalid transaction, please try again.'));
                return redirect()->route('subscription');
            }

            $session = Session::retrieve($payment_id);

            if ($session->payment_status == "paid" && $session->status == "complete") {

                $update = $transaction->update([
                    'gateway' => $gateway->id,
                    'payment_id' => $session->id,
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
