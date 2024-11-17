<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Methods\ReCaptchaValidation;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        abort_if(!config('settings.enable_user_registration'), 404);

        $this->middleware('guest');
        $this->activeTheme = active_theme();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        return view($this->activeTheme . 'auth.register');
    }

    /**
     * Before register a new user
     *
     * @return //redirect
     */
    public function register(Request $request)
    {
        Validator::make($request->all(), [
                'firstname' => ['required', 'string', 'max:50'],
                'lastname' => ['required', 'string', 'max:50'],
                'username' => ['required', 'string', 'min:2', 'max:50', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'terms' => ['sometimes', 'required'],
            ] + validate_recaptcha())
            ->validate();

        $ipInfo = user_ip_info();

        $data = array_merge($request->all(), [
            'country_name' => $ipInfo->location->country,
        ]);

        $user = User::create([
            'name' => $data['firstname'] . ' ' . $data['lastname'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'address' => ['address' => '', 'city' => '', 'state' => '', 'zip' => '', 'country' => $data['country_name']],
            'avatar' => 'default.png',
            'password' => Hash::make($data['password']),
            'plan_id' => 'free',
            'plan_settings' => config('settings.free_membership_plan')->settings,
        ]);
        if ($user) {

            /* Add admin notification */
            $title = $user->name . ' ' . ___('has registered');
            create_notification($title, 'new_user', route('admin.users.edit', $user->id));

            update_user_logs($user);
        }

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

}
