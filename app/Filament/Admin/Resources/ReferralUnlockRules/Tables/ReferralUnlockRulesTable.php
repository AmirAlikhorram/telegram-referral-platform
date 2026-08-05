<?php

namespace App\Filament\Admin\Resources\ReferralUnlockRules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReferralUnlockRulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('level.name')
                    ->label('Level'),

                TextColumn::make('threshold_amount')
                    ->label('Threshold'),

                TextColumn::make('unlock_percent')
                    ->label('Unlock %'),

                IconColumn::make('is_active')
                    ->boolean(),

            ])
            ->defaultSort('level_id')
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
