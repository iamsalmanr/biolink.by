<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Validator;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
     */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::USER;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->activeTheme = active_theme();
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        if (config('settings.enable_email_verification')) {
            return $request->user()->hasVerifiedEmail()
                ? redirect($this->redirectPath())
                : view($this->activeTheme . 'auth.verify');
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Change email address
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeEmailAddress(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => ['string', 'email', 'required', 'unique:users,email,' . $user->id],
        ]);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back();
        }

        if ($user->email != $request->email) {
            $response = $user->update(['email' => $request->email]);
            if ($response) {
                $user->sendEmailVerificationNotification();
                quick_alert_success(___('Email changed successfully'));
                return back();
            }
        }
        return back();
    }
}
