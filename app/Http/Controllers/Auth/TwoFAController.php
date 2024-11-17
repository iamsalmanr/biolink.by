<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class TwoFAController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();
    }

    /**
     * Display 2fa form
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showTwoFAVerifyForm()
    {
        if (request()->user()->google2fa_status) {
            if (Session::has('2fa')) {
                return redirect(RouteServiceProvider::USER);
            }
        } else {
            return redirect(RouteServiceProvider::USER);
        }
        return view($this->activeTheme.'auth.2fa');
    }

    /**
     * Verify 2fa
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyTwoFA(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back();
        }

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey(request()->user()->google2fa_secret, $request->otp_code);
        if (!$valid) {
            quick_alert_error(___('Invalid 2FA OTP Code'));
            return back();
        }
        Session::put('2fa', request()->user()->id);
        return redirect(RouteServiceProvider::USER);
    }
}
