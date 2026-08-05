<?php

namespace App\Filament\Admin\Resources\WithdrawalRequests\Pages;

use App\Filament\Admin\Resources\WithdrawalRequests\WithdrawalRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWithdrawalRequest extends EditRecord
{
    protected static string $resource = WithdrawalRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
