<?php

namespace App\Filament\Admin\Resources\WithdrawalRequests\Pages;

use App\Filament\Admin\Resources\WithdrawalRequests\WithdrawalRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWithdrawalRequest extends CreateRecord
{
    protected static string $resource = WithdrawalRequestResource::class;
}
