<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Authentication
            |--------------------------------------------------------------------------
            */

            $table->string('name')->nullable();

            $table->string('email')->nullable()->unique();

            $table->timestamp('email_verified_at')->nullable();

            $table->string('password')->nullable();

            $table->rememberToken();

            /*
            |--------------------------------------------------------------------------
            | Telegram
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('telegram_id')
                ->nullable()
                ->unique();

            $table->string('telegram_username')
                ->nullable();

            $table->string('first_name')
                ->nullable();

            $table->string('last_name')
                ->nullable();

            $table->timestamp('telegram_joined_at')
                ->nullable();

            $table->unsignedBigInteger('last_bot_message_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Referral
            |--------------------------------------------------------------------------
            */

            $table->string('referral_code',20)
                ->unique()
                ->nullable();

            $table->foreignId('referred_by_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | User Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status',[
                'active',
                'blocked',
                'pending',
            ])->default('active');

            $table->boolean('is_admin')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Level
            |--------------------------------------------------------------------------
            */

            $table->foreignId('level_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Professional Activation
            |--------------------------------------------------------------------------
            */

            $table->foreignId('activation_deposit_id')
                ->nullable();

            $table->timestamp('professional_activated_at')
                ->nullable();

            $table->timestamp('withdraw_unlocked_at')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('telegram_id');

            $table->index('status');

            $table->index('level_id');

            $table->index('is_admin');
        });

        /*
        |--------------------------------------------------------------------------
        | Password Reset
        |--------------------------------------------------------------------------
        */

        Schema::create('password_reset_tokens', function (Blueprint $table) {

            $table->string('email')->primary();

            $table->string('token');

            $table->timestamp('created_at')->nullable();

        });

        /*
        |--------------------------------------------------------------------------
        | Sessions
        |--------------------------------------------------------------------------
        */

        Schema::create('sessions', function (Blueprint $table) {

            $table->string('id')->primary();

            $table->foreignId('user_id')
                ->nullable()
                ->index();

            $table->string('ip_address',45)
                ->nullable();

            $table->text('user_agent')
                ->nullable();

            $table->longText('payload');

            $table->integer('last_activity')
                ->index();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('users');
    }
};
