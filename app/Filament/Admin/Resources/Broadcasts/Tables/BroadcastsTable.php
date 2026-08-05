<?php

namespace App\Filament\Admin\Resources\Broadcasts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BroadcastsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('target')
                    ->badge(),

        TextColumn::make('status')
            ->badge(),

        TextColumn::make('success'),

        TextColumn::make('failed'),

        TextColumn::make('total'),

        TextColumn::make('started_at')
            ->dateTime(),

        TextColumn::make('finished_at')
            ->dateTime()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('send')
                    ->color('success')
                    ->icon('heroicon-o-paper-airplane')
                    ->visible(fn($record)=>$record->status=='pending')
                    ->requiresConfirmation()
                    ->action(function($record){

                        dispatch(new \App\Jobs\BroadcastJob($record));

                    })

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
