<?php

namespace App\Filament\Widgets;

use App\Models\Division;
use Filament\Widgets\ChartWidget;

class EmployeesPerDivisionChart extends ChartWidget
{
    protected ?string $heading = 'Karyawan per Divisi';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $data = Division::query()
            ->withCount(['employees' => fn ($q) => $q->where('is_active', true)])
            ->orderByDesc('employees_count')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Karyawan',
                    'data' => $data->pluck('employees_count')->toArray(),
                    'backgroundColor' => '#10b981', // Emerald 500
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => ['legend' => ['display' => false]],
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['grid' => ['display' => false]],
            ],
        ];
    }
}
