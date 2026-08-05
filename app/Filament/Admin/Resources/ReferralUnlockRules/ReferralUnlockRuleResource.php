<?php

namespace App\Filament\Admin\Resources\ReferralUnlockRules;

use App\Filament\Admin\Resources\ReferralUnlockRules\Pages\CreateReferralUnlockRule;
use App\Filament\Admin\Resources\ReferralUnlockRules\Pages\EditReferralUnlockRule;
use App\Filament\Admin\Resources\ReferralUnlockRules\Pages\ListReferralUnlockRules;
use App\Filament\Admin\Resources\ReferralUnlockRules\Schemas\ReferralUnlockRuleForm;
use App\Filament\Admin\Resources\ReferralUnlockRules\Tables\ReferralUnlockRulesTable;
use App\Models\ReferralUnlockRule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReferralUnlockRuleResource extends Resource
{
    protected static ?string $model = ReferralUnlockRule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ReferralUnlockRuleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReferralUnlockRulesTable::configure($table);
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
            'index' => ListReferralUnlockRules::route('/'),
            'create' => CreateReferralUnlockRule::route('/create'),
            'edit' => EditReferralUnlockRule::route('/{record}/edit'),
        ];
    }
}
