<?php

namespace App\Filament\Admin\Resources\Broadcasts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BroadcastInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('message')
                    ->columnSpanFull(),
                TextEntry::make('sent')
                    ->numeric(),
                TextEntry::make('failed')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
