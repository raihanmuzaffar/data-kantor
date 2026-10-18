<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AttendanceTodayWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $today = today();
        $activeEmployees = Employee::where('is_active', true)->count();

        $present = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'late', 'early_leave', 'half_day'])
            ->count();

        $late = Attendance::whereDate('date', $today)
            ->where('status', 'late')
            ->count();

        $absent = max(0, $activeEmployees - $present);

        $clockedInOnly = Attendance::whereDate('date', $today)
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->count();

        return [
            Stat::make('Hadir Hari Ini', $present)
                ->description("dari {$activeEmployees} karyawan aktif")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Terlambat', $late)
                ->description('Clock-in setelah jam masuk + toleransi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Belum Absen', $absent)
                ->description('Belum ada record absensi hari ini')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Masih di Kantor', $clockedInOnly)
                ->description('Sudah clock-in, belum clock-out')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info'),
        ];
    }
}
