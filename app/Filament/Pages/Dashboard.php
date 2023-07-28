<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OperatorsStat;
use App\Filament\Widgets\ServicesStat;
use App\Filament\Widgets\TicketsStat;
use Carbon\Carbon;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static bool $shouldRegisterNavigation = false;

    protected function getHeading(): string
    {
        return "Дашборд ".Carbon::now()->format('d-m-Y');
    }

    protected function getColumns(): int | array
    {
        return 6;
    }


    protected function getWidgets(): array
    {
        return [
            OperatorsStat::class,
            ServicesStat::class,
            TicketsStat::class
        ];
    }
}
