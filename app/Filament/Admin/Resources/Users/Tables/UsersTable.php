<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('telegram_id')
                    ->label('Telegram ID')
                    ->searchable(),

                TextColumn::make('level.name')
                    ->label('Level')
                    ->badge(),

                TextColumn::make('wallet.withdrawable_balance')
                    ->label('Balance')
                    ->numeric(2),

                IconColumn::make('status')
                    ->boolean(fn ($record) => $record->status === 'active')
                    ->label('Active'),

                IconColumn::make('is_admin')
                    ->boolean()
                    ->label('Admin'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])

            ->defaultSort('id', 'desc')

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
