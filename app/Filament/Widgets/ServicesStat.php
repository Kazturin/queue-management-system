<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class ServicesStat extends BarChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';
    protected int|string|array $columnSpan = [
        'sm' => 1,
        'md' => 6,
        'lg' => 3
    ];

    protected function getHeading(): string
    {
        return 'Білім бағдарламалары(талон) '.Carbon::now()->format('d-m-Y');
    }

    protected function getData(): array
    {
        $query = DB::table('services')
            ->join('tickets', 'services.id', '=', 'tickets.service_id')
            ->select('services.abbreviation', DB::raw('count(*) as count'))
            ->whereDate('created_at',Carbon::today())
            ->where('tickets.status',Ticket::STATUS_IN_PROGRESS)
            ->groupBy('services.abbreviation')
            ->orderBy('count','desc')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Қабылданған талондар саны',
                    'data' => $query->pluck('count'),
                    'backgroundColor' => [
                        'rgba(54, 162, 235, .6)',
                    ],
                    'borderColor' => [
                        'rgba(54, 162, 235, .8)'
                    ],
                ],
            ],
            'labels' => $query->pluck('abbreviation'),
        ];
    }
}
