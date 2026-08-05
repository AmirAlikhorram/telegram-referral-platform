<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral_reward_levels', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Referral Level
            |--------------------------------------------------------------------------
            */

            // سطح پورسانت
            // مثال:
            // 1 = معرفی مستقیم
            // 2 = زیرمجموعه سطح دوم
            // ...

            $table->unsignedTinyInteger('level')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Reward
            |--------------------------------------------------------------------------
            */

            // درصد پورسانت

            $table->decimal('percent',5,2);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            $table->string('title')
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('level');

            $table->index('is_active');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_reward_levels');
    }
};
