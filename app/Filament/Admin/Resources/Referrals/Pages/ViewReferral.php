<?php

namespace App\Filament\Admin\Resources\Referrals\Pages;

use App\Filament\Admin\Resources\Referrals\ReferralResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReferral extends ViewRecord
{
    protected static string $resource = ReferralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
