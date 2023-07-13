<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OperatorsStat;
use App\Filament\Widgets\ServicesStat;
use App\Filament\Widgets\TicketsStat;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected static bool $shouldRegisterNavigation = false;

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
