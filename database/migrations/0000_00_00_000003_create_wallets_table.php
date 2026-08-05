<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Owner
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Balances
            |--------------------------------------------------------------------------
            */

            // پورسانت هایی که هنوز آزاد نشده اند
            $table->decimal('reward_balance', 18, 8)
                ->default(0);

            // موجودی قابل برداشت
            $table->decimal('withdrawable_balance', 18, 8)
                ->default(0);

            // موجودی قفل شده
            $table->decimal('locked_balance', 18, 8)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            // مجموع پورسانت دریافتی
            $table->decimal('total_earned', 18, 8)
                ->default(0);

            // مجموع برداشت ها
            $table->decimal('total_withdrawn', 18, 8)
                ->default(0);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('reward_balance');

            $table->index('withdrawable_balance');

            $table->index('locked_balance');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
