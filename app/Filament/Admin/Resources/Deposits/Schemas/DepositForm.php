<?php

namespace App\Filament\Admin\Resources\Deposits\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepositForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextInput::make('txid')
                ->disabled(),

            TextInput::make('amount')
                ->disabled(),

            TextInput::make('network')
                ->disabled(),

            TextInput::make('status')
                ->disabled(),

        ]);
    }
}
