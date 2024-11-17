<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\PaymentGateway;
use App\Models\Plan;
use App\Models\Tax;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class CheckoutController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();
    }

    /**
     * Display the page
     */
    public function index(Request $request)
    {
        abort_if(!$request->get('plan'), 404);

        $user = request()->user();

        /* check if user already using this plan */
        if ($user->plan_id == $request->get('plan')) {
            quick_alert_error(___('You are already using this plan.'));
            return redirect()->route('pricing');
        }

        $tax = $coupon = $interval = null;
        $calculated_tax = $total = $price = $price_after_discount = $tax_after_discount = 0;

        if ($request->get('plan') == 'free') {

            quick_alert_error(___('You will get the free plan automatically after your current plan expires.'));
            return redirect()->route('pricing');

        } else if ($request->get('plan') == 'trial') {

            /* check trial done */
            if ($user->plan_trial_done) {
                quick_alert_error(___("Your trial option was already used, you can't use it anymore."));
                return redirect()->route('pricing');
            }

            $plan = config('settings.trial_membership_plan');

            abort_if($plan->status != 1, 404);

            $planEndDate = Carbon::now()->addDays($plan->days);

        } else {

            $plan = Plan::where('status', 1)->findOrFail($request->get('plan'));

            if ($request->input('interval') == 'monthly') {
                $price = $plan['monthly_price'];
                $interval = 'MONTHLY';
                $planEndDate = Carbon::now()->addMonth();
            } else if ($request->input('interval') == 'yearly') {
                $price = $plan['annual_price'];
                $interval = 'YEARLY';
                $planEndDate = Carbon::now()->addYear();
            } else if ($request->input('interval') == 'lifetime') {
                $price = $plan['lifetime_price'];
                $interval = 'LIFETIME';
                $planEndDate = Carbon::now()->addYears(100);
            } else {
                /* redirect to monthly interval */
                return redirect()->route('checkout.index', ['interval' => 'monthly', 'plan' => $request->get('plan')]);
            }

            /* calculate tax */
            if ($country = get_user_country($user->address->country)) {
                $tax = Tax::where('country_id', $country->id)->first();
                if (!$tax) {
                    $tax = Tax::whereNull('country_id')->first();
                }
            } else {
                $tax = Tax::whereNull('country_id')->first();
            }

            $calculated_tax = $tax ? ($price * $tax->percentage) / 100 : 0;
            $total = ($price + $calculated_tax);

            /* If coupon was applied */
            if ($request->has('coupon_code')) {
                $coupon = Coupon::where('code', $request->get('coupon_code'))
                    /* check coupon is not expired */
                    ->where('expiry_at', '>', Carbon::now())
                    ->first();

                if ($coupon) {
                    if ($coupon->used < $coupon->limit) {
                        $price_after_discount = ($price - ($price * $coupon->percentage) / 100);
                        $tax_after_discount = $tax ? ($price_after_discount * $tax->percentage) / 100 : 0;
                        $total = ($price_after_discount + $tax_after_discount);
                    } else {
                        quick_alert_error(___('Coupon code usage limit exceeded.'));
                        return redirect()->back()->withInput();
                    }
                } else {
                    quick_alert_error(___('Coupon code is expired or invalid.'));
                    return redirect()->back()->withInput();
                }

            }
        }


        /* form submit */
        if ($request->has('payment_submit')) {

            $validator = Validator::make($request->all(), [
                'address' => ['required', 'string'],
                'city' => ['required', 'string'],
                'state' => ['required', 'string'],
                'zip' => ['required', 'string'],
                'country' => ['required', 'integer', 'exists:countries,id'],
            ]);
            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                quick_alert_error(implode('<br>', $errors));
                return back()->withInput();
            }

            $address = [
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'country' => Country::find($request->country)->name,
            ];

            if ($request->input('plan') == 'trial') {

                $user->update([
                    'plan_id' => 'trial',
                    'plan_settings' => $plan->settings,
                    'plan_expiration_date' => $planEndDate,
                    'plan_interval' => null,
                    'plan_trial_done' => true,
                    'plan_about_to_expire_reminder' => false,
                    'address' => $address
                ]);

                quick_alert_success(___('Subscribed Successfully'));
                return redirect()->route('subscription');

            } else {

                $user->update(['address' => $address]);

                /* create transaction */
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'details' => ['title' => $plan->name, 'price' => $price, 'interval' => $interval],
                    'total' => $total,
                    'coupon' => (
                    $coupon
                        ? ['id' => $coupon->id, 'code' => $coupon->code, 'percentage' => $coupon->percentage]
                        : null
                    ),
                    'taxes' => (
                    $tax
                        ? [['id' => $tax->id, 'title' => $tax->title, 'percentage' => $tax->percentage]]
                        : null
                    ),
                    'customer' => [
                        'name' => $user->name,
                        'address' => $request->address,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip' => $request->zip,
                        'country' => Country::find($request->country)->name,
                    ],
                    'seller' => config('settings.invoice_billing'),
                    'status' => ($total > 0 ? Transaction::STATUS_UNPAID : Transaction::STATUS_PAID)
                ]);

                /* Process zero price subscription (100% coupon off) */
                if ($total == 0) {

                    /* Increase the coupon usage */
                    $coupon->increment('used');

                    $user->update([
                        'plan_id' => $plan->id,
                        'plan_settings' => $plan->settings,
                        'plan_expiration_date' => $planEndDate,
                        'plan_interval' => $interval,
                        'plan_about_to_expire_reminder' => false,
                    ]);

                    quick_alert_success(___('Subscribed Successfully'));
                    return redirect()->route('subscription');
                }

                $gateway = PaymentGateway::where('id', $request->payment_method)->where('status', 1)->firstOrFail();
                $paymentController = __NAMESPACE__ . '\PaymentMethods\\' . ucfirst($gateway->key) . 'Controller';
                return $paymentController::pay($transaction);
            }
        }

        $paymentGateways = PaymentGateway::where('status', 1)->get();

        $planStartDate = date_formating(Carbon::now());
        $planEndDate = date_formating($planEndDate);

        return view($this->activeTheme . '.user.checkout', compact('user', 'plan', 'interval', 'price', 'tax', 'calculated_tax', 'total', 'coupon', 'price_after_discount', 'tax_after_discount', 'paymentGateways', 'planStartDate', 'planEndDate'));
    }

    /**
     * Update Subscription data
     *
     * @param Transaction $trx
     */
    public static function updateUserPlan(Transaction $trx)
    {
        /* Increase the coupon usage if exist */
        if($trx->coupon) {
            $coupon = Coupon::find($trx->coupon->id);
            $coupon->increment('used');
        }

        $planEndDate = null;
        if ($trx->details->interval == 'MONTHLY') {
            $planEndDate = Carbon::now()->addMonth();
        } else if ($trx->details->interval == 'YEARLY') {
            $planEndDate = Carbon::now()->addYear();
        } else if ($trx->details->interval == 'LIFETIME') {
            $planEndDate = Carbon::now()->addYears(100);
        }

        request()->user()->update([
            'plan_id' => $trx->plan_id,
            'plan_settings' => $trx->plan->settings,
            'plan_expiration_date' => $planEndDate,
            'plan_interval' => $trx->details->interval,
            'plan_about_to_expire_reminder' => false,
        ]);
    }
}
