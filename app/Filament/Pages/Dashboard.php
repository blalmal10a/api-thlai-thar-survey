<?php

namespace App\Filament\Pages;

use App\Filament\Resources\EntryResource\Widgets\Statistic;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\ChartWidget;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int | string | array
    {
        return  1;
    }

    public function widgets(): array
    {
        return [

            // Additional widgets...
        ];
    }
}
