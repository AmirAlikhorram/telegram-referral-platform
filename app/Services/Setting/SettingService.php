<?php

namespace App\Services\Setting;

use App\Models\Setting;

class SettingService
{
    protected array $cache = [];

    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        }

        $value = Setting::where('key', $key)->value('value');

        $this->cache[$key] = $value ?? $default;

        return $this->cache[$key];
    }

    public function set(string $key, $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        $this->cache[$key] = $value;
    }
}
