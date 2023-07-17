<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PermissionResource;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class OperatorsStat extends BarChartWidget
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
        return 'Операторлар';
    }

    protected function getData(): array
    {
        $query = DB::table('users')
            ->join('tickets', 'users.id', '=', 'tickets.operator_id')
            ->select('users.name', DB::raw('count(*) as count'))
            ->whereDate('tickets.created_at',Carbon::today())
            ->where('tickets.status',Ticket::STATUS_IN_PROGRESS)
            ->groupBy('users.name')
            ->orderBy('count','desc')
            ->limit(10)
            //->asArray()
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Қабылданған талондар саны',
                    'data' => $query->pluck('count'),
                    'backgroundColor' => [
                        'rgba(230, 5, 68, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                        'rgba(54, 162, 235, .6)',
                    ],
                    'borderColor' => [
                        'rgba(54, 162, 235, .8)'
                    ],
                ],
            ],
            'labels' => $query->pluck('name'),
        ];
    }
}
