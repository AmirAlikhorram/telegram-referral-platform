<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('telegram_id')->nullable()->unique()->after('id');
            $table->string('telegram_username')->nullable()->after('telegram_id');
            $table->string('first_name')->nullable()->after('telegram_username');
            $table->string('last_name')->nullable()->after('first_name');

            $table->string('referral_code', 20)->nullable()->unique()->after('last_name');
            $table->foreignId('referred_by_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->after('referral_code');

            $table->string('status', 20)->default('active')->after('referred_by_user_id');
            $table->timestamp('telegram_joined_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by_user_id']);
            $table->dropUnique(['telegram_id']);
            $table->dropUnique(['referral_code']);

            $table->dropColumn([
                'telegram_id',
                'telegram_username',
                'first_name',
                'last_name',
                'referral_code',
                'referred_by_user_id',
                'status',
                'telegram_joined_at',
            ]);
        });
    }
};
