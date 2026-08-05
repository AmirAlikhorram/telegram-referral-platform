<?php

namespace App\Filament\Resources\Deposits\Tables;

use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;

class DepositsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->defaultSort('created_at', 'desc')

            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.telegram_username')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount'),

                Tables\Columns\TextColumn::make('network'),

                Tables\Columns\TextColumn::make('txid')
                    ->limit(20),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),

            ])

            ->filters([

            ])

            ->recordActions([

                Action::make('approve')
                    ->color('success')
                    ->requiresConfirmation(),

                Action::make('reject')
                    ->color('danger')
                    ->requiresConfirmation(),

            ]);
    }
}
