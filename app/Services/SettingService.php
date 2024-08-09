<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Spatie\Valuestore\Valuestore;

class SettingService
{
    public static function getSettingsValuestore()
    {
        return Valuestore::make(config_path('settings.json'));
    }

    public static function data()
    {
        return self::getSettingsValuestore()->all();
    }

    public static function put($data)
    {
        Cache::forget('settings');
        self::getSettingsValuestore()->put($data);
    }
}
