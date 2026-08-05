<?php

namespace App\Filament\Admin\Resources\WithdrawalRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WithdrawalRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),

                TextColumn::make('amount')
                    ->money('USDT'),

                TextColumn::make('wallet_address'),

                TextColumn::make('network')
                    ->badge(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'primary' => 'paid',
                        'danger' => 'rejected',
                    ]),

                TextColumn::make('created_at')
                    ->dateTime(),

                TextColumn::make('approved_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'=>'Pending',
                        'approved'=>'Approved',
                        'paid'=>'Paid',
                        'rejected'=>'Rejected',
                    ])
            ])
            ->recordActions([
                Action::make('approve')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record)=>$record->status=='pending')
                    ->requiresConfirmation()
                    ->action(function($record){

                        app(\App\Services\Withdrawal\WithdrawalService::class)
                            ->approve($record);

                    }),
                Action::make('reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn($record)=>$record->status=='pending')
                    ->requiresConfirmation()
                    ->action(function($record){

                        app(\App\Services\Withdrawal\WithdrawalService::class)
                            ->reject($record);

                    }),
                Action::make('paid')
                    ->color('primary')
                    ->icon('heroicon-o-banknotes')
                    ->visible(fn($record)=>$record->status=='approved')
                    ->requiresConfirmation()
                    ->action(function($record){

                        app(\App\Services\Withdrawal\WithdrawalService::class)
                            ->markAsPaid($record);

                    })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
