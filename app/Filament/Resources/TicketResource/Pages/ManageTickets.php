<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTickets extends ManageRecords
{
    protected static string $resource = TicketResource::class;

    protected function getActions(): array
    {
        return [
         //   Actions\CreateAction::make(),
        ];
    }

//    protected function getHeaderWidgets(): array
//    {
//        return [
//            TicketResource\Widgets\TicketCall::class,
//        ];
//    }
}
