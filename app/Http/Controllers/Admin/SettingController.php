<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck(
            'value',
            'key'
        );

        return view(
            'admin.settings.index',
            compact('settings')
        );
    }

    public function update(Request $request)
    {
        $data = $request->validate([

            'telegram_bot_username' => 'required|string',

            'telegram_required_channel' => 'required|string',

            'telegram_channel_url' => 'required|url',

            'referral_reward' => 'required|numeric|min:0',

            'minimum_withdraw' => 'required|numeric|min:1',

            'bot_enabled' => 'nullable',

            'maintenance_mode' => 'nullable',

        ]);

        foreach ($data as $key => $value) {

            Setting::updateOrCreate(

                [
                    'key' => $key,
                ],

                [
                    'value' => $value,
                ]

            );

        }

        return back()->with(

            'success',

            'تنظیمات با موفقیت ذخیره شد.'

        );
    }
}
