<?php

namespace App\Filament\Admin\Resources\Referrals\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReferralForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('referrer_id')
                    ->relationship('referrer', 'name')
                    ->required(),
                Select::make('referred_id')
                    ->relationship('referred', 'name')
                    ->required(),
                TextInput::make('referral_code')
                    ->required(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'verified' => 'Verified', 'rewarded' => 'Rewarded'])
                    ->default('pending')
                    ->required(),
                DateTimePicker::make('verified_at'),
                DateTimePicker::make('rewarded_at'),
            ]);
    }
}
