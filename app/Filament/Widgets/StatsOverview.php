<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use App\Models\Division;
use App\Models\Employee;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $activeEmployees = Employee::where('is_active', true)->count();
        $totalEmployees = Employee::count();
        $divisions = Division::where('is_active', true)->count();
        $publishedAnnouncements = Announcement::where('is_published', true)->count();
        $users = User::count();

        return [
            Stat::make('Karyawan Aktif', $activeEmployees)
                ->description("dari {$totalEmployees} total")
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 4, 9, 2, 6, 8, 5, 10, 7, 12]),

            Stat::make('Divisi', $divisions)
                ->description('Divisi aktif')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info')
                ->chart([3, 4, 4, 5, 5, 6, 6, 6]),

            Stat::make('Pengumuman', $publishedAnnouncements)
                ->description('Sudah dipublish')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning')
                ->chart([2, 5, 3, 8, 6, 9, 7, 12]),

            Stat::make('Users', $users)
                ->description('Terdaftar di sistem')
                ->descriptionIcon('heroicon-m-user-circle')
                ->color('primary')
                ->chart([1, 1, 1, 2, 2, 2, 2, 2]),
        ];
    }
}
