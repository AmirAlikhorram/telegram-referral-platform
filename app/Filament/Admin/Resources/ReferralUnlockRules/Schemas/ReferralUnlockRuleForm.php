<?php

namespace App\Filament\Admin\Resources\ReferralUnlockRules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReferralUnlockRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('level_id')
                    ->relationship(
                        'level',
                        'name'
                    )
                    ->required(),

                TextInput::make('threshold_amount')
                    ->numeric()
                    ->required(),

                TextInput::make('unlock_percent')
                    ->numeric()
                    ->suffix('%')
                    ->required(),

                Toggle::make('is_active')
                    ->default(true),

            ]);
    }
}
