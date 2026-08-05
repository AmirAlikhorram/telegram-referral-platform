<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {

        $settings = [

            [
                'key' => 'bot_token',
                'value' => '',
            ],

            [
                'key' => 'channel_username',
                'value' => '',
            ],

            [
                'key' => 'minimum_deposit',
                'value' => '10',
            ],

            [
                'key' => 'referral_reward',
                'value' => '2',
            ],

            [
                'key' => 'withdraw_minimum',
                'value' => '5',
            ],

            [
                'key' => 'deposit_trc20_address',
                'value' => 'YOUR_TRC20_WALLET_ADDRESS',
            ],

            [
                'key' => 'deposit_bep20_address',
                'value' => 'YOUR_BEP20_WALLET_ADDRESS',
            ],

            [
                'key' => 'deposit_erc20_address',
                'value' => 'YOUR_ERC20_WALLET_ADDRESS',
            ],

            [
                'key' => 'telegram_support_url',
                'value' => 'https://t.me/YOUR_SUPPORT_USERNAME',
            ],

            [
                'key' => 'telegram_channel_url',
                'value' => 'https://t.me/YOUR_CHANNEL_USERNAME',
            ],

        ];


        foreach ($settings as $setting) {

            Setting::updateOrCreate(

                [
                    'key' => $setting['key'],
                ],

                [
                    'value' => $setting['value'],
                ]

            );

        }

    }
}
