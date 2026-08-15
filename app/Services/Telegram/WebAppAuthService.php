<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Hash;

class WebAppAuthService
{

    public function validate(string $initData): array|null
    {

        parse_str(
            $initData,
            $data
        );


        if (!isset($data['hash'])) {

            return null;

        }
        if (
            isset($data['auth_date']) &&
            now()->timestamp - (int) $data['auth_date'] > 86400
        ) {

            return null;

        }


        $hash = $data['hash'];


        unset($data['hash']);


        ksort($data);


        $dataCheckString = collect($data)
            ->map(
                fn($value, $key)
                =>
                "{$key}={$value}"
            )
            ->implode("\n");


        $secretKey = hash_hmac(
            'sha256',
            config('telegram.bot_token'),
            'WebAppData',
            true
        );


        $calculatedHash = hash_hmac(
            'sha256',
            $dataCheckString,
            $secretKey
        );


        if (
            !hash_equals(
                $calculatedHash,
                $hash
            )
        ) {

            return null;

        }


        return [
            'user' =>
                isset($data['user'])
                    ? json_decode(
                    $data['user'],
                    true
                )
                    : null,

            'auth_date' =>
                $data['auth_date'] ?? null,

        ];

    }

}
