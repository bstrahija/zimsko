<?php

namespace App\Services;

use App\Models\Setting;

class Settings
{
    protected static array $cache = [];

    public function all() {}

    public function allInGroup() {}

    public static function get($key, $default = null)
    {
        // Try the cache
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        // Try the DB
        $keys    = self::parseGroupAndKey($key);
        $payload = Setting::where(['group' => $keys['group'], 'name' => $keys['name']])->first()?->payload;

        // Update cache
        self::$cache[$key] = $payload;

        return $payload !== null ? $payload : $default;
    }

    public static function set($key, $value)
    {
        $keys = self::parseGroupAndKey($key);

        if (Setting::query()->updateOrCreate(['group' => $keys['group'], 'name' => $keys['name']], ['payload' => $value])) {
            return self::$cache[$key] = $value;
        };
    }

    protected static function parseGroupAndKey($key): array
    {
        $keys = explode('.', $key);

        return [
            'group' => $keys[0],
            'name'  => $keys[1],
        ];
    }
}
