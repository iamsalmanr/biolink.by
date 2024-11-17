<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if (env('APP_INSTALLED')) {
            try {
                $settings = Settings::all()->pluck('value', 'key');

                // Update the app's name
                config(['app.name' => $settings['site_title']]);

                // Save all the settings in a config array
                foreach ($settings as $key => $value) {
                    config(['settings.' . $key => $value]);
                }
            } catch (\Exception $e) {
            }
        }
    }
}
