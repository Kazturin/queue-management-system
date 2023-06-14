<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PermissionResource;
use App\Models\User;
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
                        'rgba(54, 162, 235, .6)'
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
