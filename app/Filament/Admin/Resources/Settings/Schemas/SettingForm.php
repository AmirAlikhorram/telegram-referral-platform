<?php

namespace App\Filament\Admin\Resources\Settings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required()
                    ->disabled(fn ($operation) => $operation === 'edit'),

                Textarea::make('value')
                    ->rows(4)
                    ->required(),

                TextInput::make('group'),

                Textarea::make('description')
                    ->rows(2),
            ]);
    }
}
