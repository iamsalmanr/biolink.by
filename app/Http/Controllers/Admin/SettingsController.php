<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        /**
         * General Setting
         **/
        if ($request->has('general_setting')) {
            $validator = Validator::make($request->all(), [
                'site_title' => 'required|string|max:255',
                'contact_email' => 'required|email',
                'terms_of_service_link' => 'nullable|url',
                'cookie_policy_link' => 'nullable|url',
                'date_format' => 'required',
                'time_format' => 'required',
                'timezone' => 'required|in:' . implode(',', array_keys(config('timezones')))
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $requestData = $request->except('general_setting', 'enable_debug');
            foreach ($requestData as $key => $value) {
                Settings::updateSettings($key, $value);
            }

            set_env('APP_TIMEZONE', $requestData['timezone'], true);

            set_env('APP_DEBUG', $request->enable_debug);


            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /**
         * Logo & Favicon Setting
         **/
        if ($request->has('logo_setting')) {
            $validator = Validator::make($request->all(), [
                'media.dark_logo' => 'nullable|mimes:png,jpg,jpeg,svg',
                'media.light_logo' => 'nullable|mimes:png,jpg,jpeg,svg',
                'media.admin_logo' => 'nullable|mimes:png,jpg,jpeg,svg',
                'media.favicon' => 'nullable|mimes:png,jpg,jpeg,ico',
                'media.social_image' => 'nullable|mimes:jpg,jpeg',
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $requestData = $request->except('logo_setting');

            if ($request->has('media.dark_logo') && $request->file('media.dark_logo') != null) {
                $darkLogo = image_upload($request->file('media.dark_logo'), 'storage/brand/', null,null, config('settings.media')->dark_logo);
                $requestData['media']['dark_logo'] = $darkLogo;
            } else {
                $requestData['media']['dark_logo'] = config('settings.media')->dark_logo;
            }

            if ($request->has('media.light_logo') && $request->file('media.light_logo') != null) {
                $lightLogo = image_upload($request->file('media.light_logo'), 'storage/brand/',null, null, config('settings.media')->light_logo);
                $requestData['media']['light_logo'] = $lightLogo;
            } else {
                $requestData['media']['light_logo'] = config('settings.media')->light_logo;
            }

            if ($request->has('media.admin_logo') && $request->file('media.admin_logo') != null) {
                $adminLogo = image_upload($request->file('media.admin_logo'), 'storage/brand/',null, null, config('settings.media')->admin_logo);
                $requestData['media']['admin_logo'] = $adminLogo;
            } else {
                $requestData['media']['admin_logo'] = config('settings.media')->admin_logo;
            }

            if ($request->has('media.favicon') && $request->file('media.favicon') != null) {
                $favicon = image_upload($request->file('media.favicon'), 'storage/brand/',null, null, config('settings.media')->favicon);
                $requestData['media']['favicon'] = $favicon;
            } else {
                $requestData['media']['favicon'] = config('settings.media')->favicon;
            }

            if ($request->has('media.social_image') && $request->file('media.social_image') != null) {
                $ogImage = image_upload($request->file('media.social_image'), 'storage/brand/', '600x315', null, config('settings.media')->social_image);
                $requestData['media']['social_image'] = $ogImage;
            } else {
                $requestData['media']['social_image'] = config('settings.media')->social_image;
            }

            foreach ($requestData as $key => $value) {
                Settings::updateSettings($key, $value);
            }

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /**
         * Colors Setting
         **/
        if ($request->has('colors_setting')) {
            $validator = Validator::make($request->all(), [
                'colors.primary_color' => 'required|regex:/^#[A-Fa-f0-9]{6}$/',
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $requestData = $request->except('colors_setting');
            foreach ($requestData as $key => $value) {
                Settings::updateSettings($key, $value);
            }

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /**
         * Currency Setting
         **/
        if ($request->has('currency_setting')) {
            $validator = Validator::make($request->all(), [
                'currency.code' => ['required', 'string', 'max:4', 'regex:/^[A-Z]{3}$/'],
                'currency.symbol' => ['required', 'string', 'max:4'],
                'currency.position' => ['required', 'integer', 'min:1', 'max:2'],
            ]);
            $errors = [];
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $requestData = $request->except('currency_setting');
            foreach ($requestData as $key => $value) {
                Settings::updateSettings($key, $value);
            }

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /*
         * SMTP Settings
         **/
        if ($request->has('smtp_settings')) {

            $validator = Validator::make($request->all(), [
                'smtp.from_email' => ['required', 'email'],
                'smtp.from_name' => ['required'],
                'smtp.mailer' => ['required', 'in:smtp,sendmail,log'],
                'smtp.encryption' => ['required', 'in:ssl,tls']
            ]);

            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->all() as $error) {
                    $errors[] = $error;
                }
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            $data = $request->smtp;
            $update = Settings::updateSettings('smtp', $data);

            if ($update) {
                set_env('MAIL_MAILER', $data['mailer']);
                set_env('MAIL_HOST', $data['host']);
                set_env('MAIL_PORT', $data['port']);
                set_env('MAIL_USERNAME', $data['username']);
                set_env('MAIL_PASSWORD', $data['password']);
                set_env('MAIL_ENCRYPTION', $data['encryption']);
                set_env('MAIL_FROM_ADDRESS', $data['from_email']);
                set_env('MAIL_FROM_NAME', $data['from_name'], true);

                $result = array('success' => true, 'message' => ___('Updated Successfully'));
                return response()->json($result, 200);
            } else {
                $result = array('success' => false, 'message' => ___('Error in updating, please try again.'));
                return response()->json($result, 200);
            }
        }

        /*
         * SMTP Testing
         **/
        if ($request->has('smtp_test')) {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
            ]);
            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->all() as $error) {$errors[] = $error;}
                $result = array('success' => false, 'message' => implode('<br>', $errors));
                return response()->json($result, 200);
            }

            try {
                $email = $request->email;
                \Mail::raw('Hi, This is a test mail to ' . $email, function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Test mail to ' . $email);
                });
                $result = array('success' => true, 'message' => ___('Sent Successfully'));
                return response()->json($result, 200);

            } catch (\Exception $e) {
                $result = array('success' => false, 'message' => ___('Error in sending, please try again.') .' '. $e->getMessage());
                return response()->json($result, 200);
            }
        }

        /*
         * Invoice Billing Settings
         **/
        if ($request->has('billing_settings')) {

            Settings::updateSettings('invoice_billing', $request->invoice_billing);

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /*
         * Social Logins Settings
         **/
        if ($request->has('social_logins_settings')) {

            $requestData = $request->except('social_logins_settings');
            foreach ($requestData as $key => $value) {
                Settings::updateSettings($key, $value);
            }

            set_env('FACEBOOK_CLIENT_ID', $requestData['facebook_login']['app_id']);
            set_env('FACEBOOK_CLIENT_SECRET', $requestData['facebook_login']['app_secret']);

            set_env('GOOGLE_CLIENT_ID', $requestData['google_login']['client_id']);
            set_env('GOOGLE_CLIENT_SECRET', $requestData['google_login']['client_secret']);

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /*
         * Addons Settings
         **/
        if ($request->has('addons_settings')) {

            $requestData = $request->except('addons_settings');
            foreach ($requestData as $key => $value) {
                Settings::updateSettings($key, $value);
            }

            set_env('NOCAPTCHA_SITEKEY', $requestData['google_recaptcha']['site_key']);
            set_env('NOCAPTCHA_SECRET', $requestData['google_recaptcha']['secret_key']);

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /*
         * Blog Settings
         **/
        if ($request->has('blog_settings')) {

            Settings::updateSettings('blog', $request->blog);

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /*
         * Testimonial Settings
         **/
        if ($request->has('testimonial_settings')) {

            Settings::updateSettings('testimonials', $request->testimonials);

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /*
         * Custom Code Settings
         **/
        if ($request->has('custom_code_setting')) {

            Settings::updateSettings('custom_css', $request->custom_css);

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }

        /*
         * Clear all cache
         **/
        if ($request->has('clear_cache')) {
            Artisan::call('optimize:clear');
            remove_file(storage_path('logs/laravel.log'));
            $result = array('success' => true, 'message' => ___('Cache Cleared Successfully'));
            return response()->json($result, 200);
        }

    }
}
