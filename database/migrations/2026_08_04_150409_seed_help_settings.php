<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'telegram_support_url'],
            ['value' => 'https://t.me/YOUR_SUPPORT_USERNAME']
        );

        DB::table('settings')->updateOrInsert(
            ['key' => 'telegram_channel_url'],
            ['value' => 'https://t.me/YOUR_CHANNEL_USERNAME']
        );
    }

    public function down(): void
    {
        DB::table('settings')
            ->whereIn('key', [
                'telegram_support_url',
                'telegram_channel_url',
            ])
            ->delete();
    }
};
