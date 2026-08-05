<?php

namespace App\Filament\Admin\Resources\Deposits\Pages;

use App\Filament\Admin\Resources\Deposits\DepositResource;
use App\Services\Deposit\DepositService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewDeposit extends ViewRecord
{
    protected static string $resource = DepositResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('approve')
                ->label('Approve')
                ->color('success')
                ->icon('heroicon-o-check')
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function () {

                    app(DepositService::class)
                        ->approve(
                            $this->record,
                            auth()->user()
                        );

                    Notification::make()
                        ->title('Deposit approved')
                        ->success()
                        ->send();

                    $this->refreshFormData([
                        'status',
                    ]);
                }),

            Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->icon('heroicon-o-x-mark')
                ->visible(fn () => $this->record->status === 'pending')
                ->requiresConfirmation()
                ->action(function () {

                    app(DepositService::class)
                        ->reject(
                            $this->record,
                            auth()->user(),
                            'Rejected from admin panel'
                        );

                    Notification::make()
                        ->title('Deposit rejected')
                        ->danger()
                        ->send();

                    $this->refreshFormData([
                        'status',
                    ]);
                }),

        ];
    }
}
