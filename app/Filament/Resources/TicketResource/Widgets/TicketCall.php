<?php

namespace App\Filament\Resources\TicketResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;
use Illuminate\Support\HtmlString;

class TicketCall extends Widget
{
  //  protected static string $view = 'filament.resources.ticket-resource.widgets.ticket-call';

    protected function getCards(): array
    {
        $favoriteProjects = auth()->user()->services;
        $cards = [];
        foreach ($favoriteProjects as $project) {
            $cards[] = Card::make('', new HtmlString('
                    <div class="flex items-center gap-2 -mt-2 text-lg">
                        <span>' . $project->name . '</span>
                    </div>
                '))
                ->color('success')
                ->extraAttributes([
                    'class' => 'hover:shadow-lg'
                ]);
        }
        return $cards;
    }

    public function call(){

    }
}
