<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;

class UserChart extends ChartWidget
{
    protected ?string $heading = 'User Chart';

    protected function getData(): array
    {
        $users = User::query()
            ->whereDate(
                'created_at',
                '>=',
                now()->subDays(30)
            )
            ->selectRaw('DATE(created_at) as day,count(*) as total')
            ->groupBy('day')
            ->pluck('total','day');

        return [

            'datasets'=>[
                [
                    'label'=>'Users',
                    'data'=>$users->values(),
                ]
            ],

            'labels'=>$users->keys(),

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
