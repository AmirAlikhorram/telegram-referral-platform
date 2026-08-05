<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralRewardLevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('referral_reward_levels')->truncate();

        DB::table('referral_reward_levels')->insert([

            [

                'level'=>1,

                'percent'=>10,

                'created_at'=>now(),

                'updated_at'=>now(),

            ],

            [

                'level'=>2,

                'percent'=>5,

                'created_at'=>now(),

                'updated_at'=>now(),

            ],

            [

                'level'=>3,

                'percent'=>3,

                'created_at'=>now(),

                'updated_at'=>now(),

            ],

            [

                'level'=>4,

                'percent'=>2,

                'created_at'=>now(),

                'updated_at'=>now(),

            ],

            [

                'level'=>5,

                'percent'=>1,

                'created_at'=>now(),

                'updated_at'=>now(),

            ],

        ]);
    }
}
