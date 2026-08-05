<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Owner
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Deposit
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 18, 8);

            $table->string('currency')
                ->default('USDT');

            $table->enum('network', [
                'TRC20',
                'ERC20',
                'BEP20',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Blockchain
            |--------------------------------------------------------------------------
            */

            $table->string('txid')
                ->unique();

            $table->string('wallet_address');

            /*
            |--------------------------------------------------------------------------
            | Optional Proof
            |--------------------------------------------------------------------------
            */

            $table->string('proof_image')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Admin
            |--------------------------------------------------------------------------
            */

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('admin_note')
                ->nullable();

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Extra
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');

            $table->index('status');

            $table->index('network');

            $table->index('currency');

            $table->index('approved_by');

            $table->index([
                'user_id',
                'status',
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Add Foreign Key To Users
        |--------------------------------------------------------------------------
        |
        | چون users قبل از deposits ساخته می‌شود،
        | این Foreign Key را اینجا اضافه می‌کنیم
        | تا مشکل Circular Dependency نداشته باشیم.
        |
        */

        Schema::table('users', function (Blueprint $table) {

            $table->foreign('activation_deposit_id')
                ->references('id')
                ->on('deposits')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign([
                'activation_deposit_id',
            ]);

        });

        Schema::dropIfExists('deposits');
    }
};
