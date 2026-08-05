<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Services\Telegram\TelegramUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_telegram_user_receives_wallet_and_starter_level(): void
    {
        $this->seed(\Database\Seeders\LevelSeeder::class);

        $telegramUser = [
            'id' => 123456789,
            'username' => 'test_user',
            'first_name' => 'Test',
            'last_name' => 'User',
        ];

        $user = app(TelegramUserService::class)
            ->createOrUpdate($telegramUser);

        $this->assertNotNull($user);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'telegram_id' => 123456789,
        ]);

        $this->assertNotNull($user->wallet);

        $this->assertEquals(
            Level::where('slug', 'starter')->first()->id,
            $user->level_id
        );
    }
}
