<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [

        'key',

        'value',

    ];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::query()
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public static function set(string $key, mixed $value): self
    {
        return static::updateOrCreate(

            [
                'key' => $key,
            ],

            [
                'value' => $value,
            ]

        );
    }

    public static function has(string $key): bool
    {
        return static::query()
            ->where('key', $key)
            ->exists();
    }

    public static function remove(string $key): void
    {
        static::query()
            ->where('key', $key)
            ->delete();
    }
}
