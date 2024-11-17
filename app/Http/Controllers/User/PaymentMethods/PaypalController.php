<?php

namespace App\Http\Controllers\User\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\CheckoutController;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{

    /**
     * Get paypal provider
     *
     * @return PayPalClient
     */
    public static function getPaypalProvider()
    {
        $gateway = PaymentGateway::where('key', 'paypal')->first();

        if($gateway->test_mode){
            $config = [
                'mode'    => 'sandbox',
                'sandbox' => [
                    'client_id'         => $gateway->credentials->client_id,
                    'client_secret'     => $gateway->credentials->client_secret,
                    'app_id'            => 'APP-80W284485P519543T',
                ],

                'payment_action' => 'Sale',
                'currency'       => config('settings.currency')->code,
                'notify_url'     => '',
                'validate_ssl'   => false,
                'locale' => get_lang()
            ];
        }else{
            $config = [
                'mode'    => 'live',
                'live' => [
                    'client_id'         => $gateway->credentials->client_id,
                    'client_secret'     => $gateway->credentials->client_secret,
                    'app_id'            => $gateway->credentials->app_id,
                ],

                'payment_action' => 'Sale',
                'currency'       => config('settings.currency')->code,
                'notify_url'     => '',
                'validate_ssl'   => true,
                'locale' => get_lang()
            ];
        }

        $provider = new PayPalClient($config);
        $provider->getAccessToken();
        return $provider;
    }

    /**
     * Process the payment
     *
     * @param Transaction $transaction
     */
    public static function pay(Transaction $transaction)
    {

        $gateway = PaymentGateway::where('key', 'paypal')->first();

        $fees = ($transaction->total * $gateway->fees) / 100;
        $price = ($transaction->total + $fees);

        try {
            $provider = self::getPaypalProvider();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                'application_context' => [
                    'brand_name' => config('settings.site_title'),
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                    "return_url" => route('ipn.paypal'),
                    "cancel_url" => route('subscription')
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => config('settings.currency')->code,
                            "value" => number_format((float) $price, 2)
                        ]
                    ]
                ]
            ]);

            $redirect_url = '';

            if (isset($response['id']) && $response['id'] != null) {
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        $redirect_url = $links['href'];
                        break;
                    }
                }

                $transaction->update(['payment_id' => $response['id'], 'fees' => $fees]);
                /* redirect to payment gateway page */
                return redirect($redirect_url);

            } else {
                error_log($response);
                quick_alert_error(!empty($response['error']['message'])
                    ? ___('Payment failed') .' : '. $response['error']['message']
                    : ___('Payment failed, check the credentials.'));
                return back();
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
            $provider = self::getPaypalProvider();

            $response = $provider->capturePaymentOrder($request['token']);

            $transaction = Transaction::where([
                ['user_id', request()->user()->id],
                ['payment_id', $request['token']],
                ['status', Transaction::STATUS_UNPAID],
            ])->first();

            if (is_null($transaction)) {
                quick_alert_error(___('Invalid transaction, please try again.'));
                return redirect()->route('subscription');
            }

            $gateway = PaymentGateway::where('key', 'paypal')->first();

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {

                $update = $transaction->update([
                    'gateway' => $gateway->id,
                    'payment_id' => $request['token'],
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
