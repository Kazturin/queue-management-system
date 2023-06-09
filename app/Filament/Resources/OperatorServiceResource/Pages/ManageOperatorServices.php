<?php

namespace App\Filament\Resources\OperatorServiceResource\Pages;

use App\Filament\Resources\OperatorServiceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOperatorServices extends ManageRecords
{
    protected static string $resource = OperatorServiceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
