<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('first_name')
                    ->maxLength(255),

                TextInput::make('last_name')
                    ->maxLength(255),

                TextInput::make('telegram_username')
                    ->prefix('@'),

                TextInput::make('telegram_id')
                    ->numeric()
                    ->disabled(),

                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'blocked' => 'Blocked',
                    ])
                    ->required(),

                Toggle::make('is_admin')
                    ->label('Administrator'),

                Select::make('level_id')
                    ->relationship('level', 'name')
                    ->searchable(),

            ]);
    }
}
