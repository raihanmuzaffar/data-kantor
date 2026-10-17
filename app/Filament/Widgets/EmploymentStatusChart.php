<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Widgets\ChartWidget;

class EmploymentStatusChart extends ChartWidget
{
    protected ?string $heading = 'Status Kepegawaian';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $statuses = Employee::query()
            ->selectRaw('employment_status, count(*) as count')
            ->groupBy('employment_status')
            ->pluck('count', 'employment_status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => array_values($statuses),
                    'backgroundColor' => ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6'],
                    'borderWidth' => 0,
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => ['Tetap', 'Kontrak', 'Probation', 'Magang'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => ['usePointStyle' => true, 'boxWidth' => 8],
                ],
            ],
            'cutout' => '75%',
        ];
    }
}
