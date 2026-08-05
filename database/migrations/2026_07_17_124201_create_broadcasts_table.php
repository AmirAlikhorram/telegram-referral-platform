<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('broadcasts', function (Blueprint $table) {

            $table->id();

            $table->enum('target', [
                'all',
                'active',
                'professional',
            ]);

            $table->longText('message');

            $table->unsignedInteger('total')->default(0);

            $table->unsignedInteger('success')->default(0);

            $table->unsignedInteger('failed')->default(0);

            $table->enum('status', [
                'pending',
                'sending',
                'finished',
                'failed',
            ])->default('pending');

            $table->foreignId('admin_id')->nullable()->constrained('users');

            $table->timestamp('started_at')->nullable();

            $table->timestamp('finished_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcasts');
    }
};
