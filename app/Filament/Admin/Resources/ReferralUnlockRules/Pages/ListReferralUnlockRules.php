<?php

namespace App\Filament\Admin\Resources\ReferralUnlockRules\Pages;

use App\Filament\Admin\Resources\ReferralUnlockRules\ReferralUnlockRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReferralUnlockRules extends ListRecords
{
    protected static string $resource = ReferralUnlockRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
