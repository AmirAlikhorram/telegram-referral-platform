<?php

namespace App\Filament\Admin\Resources\ReferralUnlockRules\Pages;

use App\Filament\Admin\Resources\ReferralUnlockRules\ReferralUnlockRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReferralUnlockRule extends EditRecord
{
    protected static string $resource = ReferralUnlockRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
