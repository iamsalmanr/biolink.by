<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class SettingsController extends Controller
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
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $QR_Image = null;
        $user = User::find(request()->user()->id);
        if (!request()->user()->google2fa_status) {
            $google2fa = app('pragmarx.google2fa');
            $secretKey = $google2fa->generateSecretKey();

            $user->update(['google2fa_secret' => encrypt($secretKey)]);

            $QR_Image = $google2fa->getQRCodeInline(config('settings.site_title'), $user->email, $secretKey);
        }
        return view($this->activeTheme.'.user.settings', ['user' => $user, 'QR_Image' => $QR_Image]);
    }

    /**
     * Edit user details
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function editProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . request()->user()->id],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:150'],
            'state' => ['required', 'string', 'max:150'],
            'zip' => ['required', 'string', 'max:100'],
            'country' => ['required', 'integer', 'exists:countries,id'],
        ]);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back();
        }

        if ($request->has('avatar')) {
            if (request()->user()->avatar == 'default.png') {
                $image = image_upload($request->file('avatar'), 'storage/users/', '150x150');
            } else {
                $image = image_upload($request->file('avatar'), 'storage/users/', '150x150', null, request()->user()->avatar);
            }
        } else {
            $image = request()->user()->avatar;
        }

        $update = request()->user()->update([
            'name' => $request->firstname . ' ' . $request->lastname,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'avatar' => $image,
            'address' => [
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'country' => Country::find($request->country)->name,
            ],
        ]);
        if ($update) {
            if (config('settings.enable_email_verification') && request()->user()->email != $request->email) {
                request()->user()->forceFill(['email_verified_at' => null])->save();
                request()->user()->sendEmailVerificationNotification();
            }
            quick_alert_success(___('User details updated successfully'));
            return back();
        }
    }

    /**
     * Edit user password
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            'new_password_confirmation' => ['required'],
        ]);
        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            quick_alert_error(implode('<br>', $errors));
            return back();
        }

        if (!(Hash::check($request->get('old_password'), request()->user()->password))) {
            quick_alert_error(___('Current password is incorrect.'));
            return back();
        }
        if (strcmp($request->get('old_password'), $request->get('new_password')) == 0) {
            quick_alert_error(___('New password and old password can not be same.'));
            return back();
        }
        $update = request()->user()->update([
            'password' => bcrypt($request->get('new_password')),
        ]);
        if ($update) {
            quick_alert_success(___('Password changed successfully'));
            return back();
        }
    }

    /**
     * Enable 2fa
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function towFAEnable(Request $request)
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
        $valid = $google2fa->verifyGoogle2FA(request()->user()->google2fa_secret, $request->otp_code);

        if (!$valid) {
            quick_alert_error(___('Invalid 2FA OTP Code'));
            return back();
        }

        $update = User::where('id', request()->user()->id)->update(['google2fa_status' => true]);
        if ($update) {
            Session::put('2fa', request()->user()->id);
            quick_alert_success(___('2FA Authentication enabled successfully'));
            return back();
        }

    }

    /**
     * Disable 2fa
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function towFADisable(Request $request)
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
        $valid = $google2fa->verifyGoogle2FA(request()->user()->google2fa_secret, $request->otp_code);
        if (!$valid) {
            quick_alert_error(___('Invalid 2FA OTP Code'));
            return back();
        }

        $update = User::where('id', request()->user()->id)->update(['google2fa_status' => false]);
        if ($update) {
            if ($request->session()->has('2fa')) {
                Session::forget('2fa');
            }
            quick_alert_success(___('2FA Authentication disabled successfully'));
            return back();
        }
    }
}
