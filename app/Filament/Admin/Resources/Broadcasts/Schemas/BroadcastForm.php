<?php

namespace App\Filament\Admin\Resources\Broadcasts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BroadcastForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('message')
                    ->required()
                    ->rows(10)
                    ->columnSpanFull(),
                Select::make('target')
                    ->options([
                        'all'=>'All Users',
                        'active'=>'Active Users',
                        'professional'=>'Professional Users',
                    ])
                    ->required()
            ]);
    }
}
