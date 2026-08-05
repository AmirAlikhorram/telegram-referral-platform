<?php

namespace App\Filament\Admin\Resources\WithdrawalRequests;

use App\Filament\Admin\Resources\WithdrawalRequests\Pages\CreateWithdrawalRequest;
use App\Filament\Admin\Resources\WithdrawalRequests\Pages\EditWithdrawalRequest;
use App\Filament\Admin\Resources\WithdrawalRequests\Pages\ListWithdrawalRequests;
use App\Filament\Admin\Resources\WithdrawalRequests\Schemas\WithdrawalRequestForm;
use App\Filament\Admin\Resources\WithdrawalRequests\Tables\WithdrawalRequestsTable;
use App\Models\WithdrawalRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WithdrawalRequestResource extends Resource
{
    protected static ?string $model = WithdrawalRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return WithdrawalRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WithdrawalRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWithdrawalRequests::route('/'),
            'create' => CreateWithdrawalRequest::route('/create'),
            'edit' => EditWithdrawalRequest::route('/{record}/edit'),
        ];
    }
}
