<?php

namespace App\Filament\Admin\Resources\WalletTransactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WalletTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('wallet.user.name')
                    ->label('User')
                    ->searchable(),

                TextColumn::make('type')
                    ->badge(),

                TextColumn::make('amount')
                    ->numeric(2),

                TextColumn::make('balance_after')
                    ->numeric(2),

                TextColumn::make('description')
                    ->limit(40),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'reward' => 'Reward',
                        'withdraw' => 'Withdraw',
                        'bonus' => 'Bonus',
                        'deposit' => 'Deposit',
                        'penalty' => 'Penalty',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
