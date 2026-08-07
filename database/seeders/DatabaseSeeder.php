<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            LevelSeeder::class,
            ReferralRewardLevelSeeder::class,
            SettingSeeder::class,
            ReferralUnlockRuleSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'amir.k1385000@gmail.com',
            'password' => Hash::make('Amir1385000@'),
            'is_admin' => true,
        ]);
    }
}
