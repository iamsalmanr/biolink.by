<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'object',
    ];

    /**
     * Get settings
     */
    public static function selectSettings($key)
    {
        $setting = Settings::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }
        return false;
    }

    /**
     * Update settings
     */
    public static function updateSettings($key, $value)
    {
        $setting = Settings::where('key', $key)->first();
        if ($setting) {
            $setting->value = $value;
            return $setting->save();
        } else {
            $setting = new Settings();
            $setting->key = $key;
            $setting->value = $value;
            return $setting->save();
        }
    }
}
