<?php

namespace App\Http\Controllers\User\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\CheckoutController;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class MollieController extends Controller
{

    /**
     * Process the payment
     *
     * @param Transaction $transaction
     */
    public static function pay(Transaction $transaction)
    {

        $gateway = PaymentGateway::where('key', 'mollie')->first();

        $title = "Payment for " . $transaction->details->title . " Plan (" . $transaction->details->interval .')';

        $fees = ($transaction->total * $gateway->fees) / 100;
        $price = $transaction->total + $fees;
        $price = number_format((float)$price, 2);

        config(['mollie.key' => trim($gateway->credentials->api_key)]);
        try {
            $mollie = Mollie::api()->payments->create([
                "description" => $title,
                "amount" => ["currency" => config('settings.currency')->code, "value" => $price],
                "redirectUrl" => route('ipn.mollie') . '?order_id=' . $transaction->id,
            ]);

            $payment = Mollie::api()->payments()->get($mollie->id);

            $transaction->update(['payment_id' => $payment->id, 'fees' => $fees]);

            /* redirect to payment gateway page */
            return redirect($payment->getCheckoutUrl());

        } catch (\Exception $e) {
            error_log($e->getMessage());
            quick_alert_error($e->getMessage());
            return back()->withInput();
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
            $id = $request->get('order_id');

            $transaction = Transaction::where([
                ['id', $id],
                ['user_id', request()->user()->id],
                ['status', Transaction::STATUS_UNPAID],
                ['payment_id', '!=', null],
            ])->first();

            if (is_null($transaction)) {
                quick_alert_error(___('Invalid transaction, please try again.'));
                return redirect()->route('subscription');
            }

            $gateway = PaymentGateway::where('key', 'mollie')->first();

            config(['mollie.key' => trim($gateway->credentials->api_key)]);
            $mollie = Mollie::api()->payments()->get($transaction->payment_id);

            if ($mollie->status == "paid") {
                $update = $transaction->update([
                    'gateway' => $gateway->id,
                    'payment_id' => $mollie->id,
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
