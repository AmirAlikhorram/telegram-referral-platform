<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\ReferralUnlockRule;
use Illuminate\Database\Seeder;

class ReferralUnlockRuleSeeder extends Seeder
{
    public function run(): void
    {

        $rules = [

            [
                'slug' => 'starter',
                'threshold_amount' => 10,
                'unlock_percent' => 50,
            ],

            [
                'slug' => 'professional',
                'threshold_amount' => 25,
                'unlock_percent' => 75,
            ],

            [
                'slug' => 'vip',
                'threshold_amount' => 50,
                'unlock_percent' => 100,
            ],

        ];


        foreach ($rules as $rule) {


            $level = Level::where(
                'slug',
                $rule['slug']
            )->first();


            if (! $level) {

                continue;

            }


            ReferralUnlockRule::updateOrCreate(

                [
                    'level_id' => $level->id,
                ],

                [

                    'threshold_amount' => $rule['threshold_amount'],

                    'unlock_percent' => $rule['unlock_percent'],

                    'is_active' => true,

                ]

            );

        }

    }
}
