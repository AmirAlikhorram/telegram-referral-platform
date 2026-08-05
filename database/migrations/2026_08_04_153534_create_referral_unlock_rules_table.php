<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral_unlock_rules', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Level
            |--------------------------------------------------------------------------
            |
            | قانون آزادسازی بر اساس Level کاربر
            |
            */

            $table->foreignId('level_id')
                ->constrained()
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Threshold
            |--------------------------------------------------------------------------
            |
            | حداقل مقدار reward_balance
            | برای فعال شدن آزادسازی
            |
            */

            $table->decimal(
                'threshold_amount',
                18,
                8
            );


            /*
            |--------------------------------------------------------------------------
            | Unlock Percent
            |--------------------------------------------------------------------------
            |
            | چند درصد از پاداش آزاد شود
            |
            */

            $table->decimal(
                'unlock_percent',
                5,
                2
            );


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->unique('level_id');

            $table->index('is_active');

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('referral_unlock_rules');
    }
};
