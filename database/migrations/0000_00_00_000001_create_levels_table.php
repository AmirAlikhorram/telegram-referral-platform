<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('slug')->unique();

            $table->unsignedInteger('priority');

            /*
            |--------------------------------------------------------------------------
            | Activation
            |--------------------------------------------------------------------------
            */

            $table->decimal('activation_fee',18,8)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Referral System
            |--------------------------------------------------------------------------
            */

            $table->unsignedTinyInteger('referral_levels')
                ->default(1);

            /*
            |--------------------------------------------------------------------------
            | Withdraw Rules
            |--------------------------------------------------------------------------
            */

            $table->boolean('withdraw_enabled')
                ->default(false);

            $table->decimal('withdraw_limit',18,8)
                ->default(0);

            $table->decimal('daily_withdraw_limit',18,8)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Reward Rules
            |--------------------------------------------------------------------------
            */

            $table->decimal('reward_multiplier',8,2)
                ->default(1);

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

            $table->index('priority');

            $table->index('slug');

            $table->index('is_active');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
