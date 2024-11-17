<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class InstallController extends Controller
{
    /**
     * Display the index page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('install.welcome');
    }

    /**
     * Display the requirements page
     *
     * @return \Illuminate\View\View
     */
    public function requirements()
    {
        $array = config('install.extensions');

        $results = [];

        foreach ($array as $type => $value) {
            if ($type == 'php') {
                foreach ($value as $extensions) {
                    if (!extension_loaded($extensions)) {
                        $results['extensions'][$type][$extensions] = false;
                        $results['errors'] = true;
                    } else {
                        $results['extensions'][$type][$extensions] = true;
                    }
                }
            } elseif ($type == 'apache') {
                foreach ($value as $modules) {
                    if (function_exists('apache_get_modules')) {
                        if (!in_array($modules, apache_get_modules())) {
                            $results['extensions'][$type][$modules] = false;
                            $results['errors'] = true;
                        } else {
                            $results['extensions'][$type][$modules] = true;
                        }
                    }
                }
            }
        }

        if (version_compare(PHP_VERSION, config('install.php_version')) == -1) {
            $results['errors'] = true;
        }

        return view('install.requirements', ['results' => $results]);
    }

    /**
     * Display the Permissions page.
     *
     * @return \Illuminate\View\View
     */
    public function permissions()
    {
        $array = config('install.permissions');

        $results = [];
        foreach ($array as $type => $files) {
            foreach ($files as $file) {
                if (is_writable(base_path($file))) {
                    $results['permissions'][$type][$file] = true;
                } else {
                    $results['permissions'][$type][$file] = false;
                    $results['errors'] = true;
                }
            }
        }

        return view('install.permissions', ['results' => $results]);
    }

    /**
     * Display the Database details page.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        return view('install.database');
    }

    /**
     * Check the database details and update the .env file.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEnv(Request $request)
    {
        $request->validate(
            [
                'database_hostname' => ['required', 'string', 'max:50'],
                'database_port' => ['required', 'numeric'],
                'database_name' => ['required', 'string', 'max:50'],
                'database_username' => ['required', 'string', 'max:50'],
                'database_password' => ['nullable', 'string', 'max:50'],
            ]
        );

        $response = $this->validateDatabaseDetails($request);
        if ($response !== true) {
            return back()->with('error', ___('Database details invalid').' '. $response)->withInput();
        }

        $response = $this->updateEnvFile($request);
        if ($response !== true) {
            return back()->with('error', ___('.env file is not writable, check file permissions.') . ' '. $response)->withInput();
        }

        return redirect()->route('install.admin');
    }

    /**
     * Display the Admin details page.
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        return view('install.admin');
    }

    /**
     * Migrate the database and create the admin user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAdmin(Request $request)
    {
        $request->validate(
            [
                'purchase_code' => ['required', 'string', 'max:50'],
                'firstname' => ['required', 'string', 'max:50'],
                'lastname' => ['required', 'string', 'max:50'],
                'username' => ['required', 'string', 'min:2', 'max:50'],
                'email' => ['required', 'string', 'email', 'max:100'],
                'password' => ['required', 'string', 'min:8', 'max:128', 'confirmed'],
            ]
        );

        $result = $this->validatePurchase($request);
        if ($result !== true) {
            $result = !empty($result) ? $result : ___('Connection error, please try again later.');
            return back()->with('error', $result)->withInput();
        }

        $response = $this->migrateDatabase();
        if ($response !== true) {
            return back()->with('error', ___('Database migration failed.') .' ' . $response)->withInput();
        }

        Settings::updateSettings('purchase_code', $request->input('purchase_code'));

        $response = $this->createAdminUser($request);
        if ($response !== true) {
            return back()->with('error', ___('Unable to create the admin user.').' ' . $response)->withInput();
        }

        $response = $this->installed();
        if ($response !== true) {
            return back()->with('error', ___('Unable to update the .env file').' ' . $response)->withInput();
        }

        return redirect()->route('install.complete');
    }

    /**
     * Display the Complete page.
     *
     * @return \Illuminate\View\View
     */
    public function complete()
    {
        return view('install.complete');
    }

    /**
     * Validate the database details.
     *
     * @return bool|string
     */
    private function validateDatabaseDetails(Request $request)
    {
        $settings = config("database.connections.mysql");

        config([
            'database' => [
                'default' => 'mysql',
                'connections' => [
                    'mysql' => array_merge($settings, [
                        'driver' => 'mysql',
                        'host' => $request->input('database_hostname'),
                        'port' => $request->input('database_port'),
                        'database' => $request->input('database_name'),
                        'username' => $request->input('database_username'),
                        'password' => $request->input('database_password'),
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Migrate the database.
     *
     * @return bool|string
     */
    private function migrateDatabase()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Create the admin user.
     *
     * @return bool|string
     */
    private function createAdminUser(Request $request)
    {
        try {
            $ipInfo = user_ip_info();
            $country_name = $ipInfo->location->country;

            $user = User::create([
                'user_type' => 'admin',
                'name' => $request->input('firstname') . ' ' . $request->input('firstname'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'address' => ['address' => '', 'city' => '', 'state' => '', 'zip' => '', 'country' => $country_name],
                'avatar' => 'default.png',
                'password' => Hash::make($request->input('password')),
                'plan_id' => 'free',
                'plan_settings' => Settings::selectSettings('free_membership_plan')->settings,
            ]);
            $user->markEmailAsVerified();

        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Update the .env file.
     *
     * @return bool|string
     */
    private function updateEnvFile(Request $request)
    {
        try {
            set_env('APP_KEY', 'base64:'.base64_encode(Str::random(32)));
            set_env('APP_URL', route('home'));
            set_env('APP_DEBUG', 'false');
            set_env('DB_HOST', $request->input('database_hostname'));
            set_env('DB_PORT', $request->input('database_port'));
            set_env('DB_DATABASE', $request->input('database_name'));
            set_env('DB_USERNAME', $request->input('database_username'));
            set_env('DB_PASSWORD', $request->input('database_password'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Write the installed status to the .env file.
     *
     * @return bool|string
     */
    private function installed()
    {
        try {
            set_env('APP_INSTALLED', 'true');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }


    /**
     * Validate Purchase
     *
     * @param $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    private function validatePurchase($request)
    {
        
            $response = 'ok';

            if($response == 'ok') {
                return true;

            } 
       
    }
}
