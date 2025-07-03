<?php
if (! function_exists('setting')) {
    function setting($key, $default = null) {
        return \App\Models\Setting::where('setting_key', $key)->value('setting_value') ?? $default;
    }
}