<?php

namespace App\Services\Setting;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    /**
     * دریافت مقدار تنظیم
     */
    public function get(
        string $key,
        mixed $default = null,
    ): mixed {

        return Cache::rememberForever(
            "setting:{$key}",
            fn () => Setting::query()
                ->where('key', $key)
                ->value('value')
                ?? $default,
        );
    }

    /**
     * ذخیره مقدار تنظیم
     */
    public function set(
        string $key,
        mixed $value,
    ): void {

        Setting::updateOrCreate(
            [
                'key' => $key,
            ],
            [
                'value' => $value,
            ],
        );

        Cache::forever(
            "setting:{$key}",
            $value,
        );
    }

    /**
     * حذف کش
     */
    public function forget(
        string $key,
    ): void {

        Cache::forget(
            "setting:{$key}",
        );
    }

    /**
     * بروزرسانی کش
     */
    public function refresh(
        string $key,
    ): mixed {

        $this->forget($key);

        return $this->get($key);
    }
}
