<?php

namespace App\Helpers;

use App\Models\Setting;
class SettingHelper
{
    public static function setting($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        if (isset($setting)) {
            return $setting->value;
        } else {
            return $default;
        }
    }
}
