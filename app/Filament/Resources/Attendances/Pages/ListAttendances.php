<?php

namespace App\Filament\Resources\Attendances\Pages;

use App\Filament\Resources\Attendances\AttendanceResource;
use App\Models\Attendance;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        $employee = $user?->employee;
        $todayAttendance = null;

        if ($employee) {
            $todayAttendance = Attendance::query()
                ->where('employee_id', $employee->id)
                ->whereDate('date', today())
                ->first();
        }

        $actions = [];

        if ($employee && (! $todayAttendance || ! $todayAttendance->hasClockedIn())) {
            $actions[] = Action::make('clockIn')
                ->label('Clock In')
                ->icon('heroicon-o-arrow-right-on-rectangle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Clock In')
                ->modalDescription('Konfirmasi clock-in untuk hari ini?')
                ->visible(fn () => $user->can('clock', Attendance::class))
                ->action(function () use ($employee) {
                    $now = now();
                    $status = Attendance::determineStatus($now);

                    Attendance::updateOrCreate(
                        [
                            'employee_id' => $employee->id,
                            'date' => today()->toDateString(),
                        ],
                        [
                            'clock_in' => $now,
                            'status' => $status,
                            'ip_address' => request()->ip(),
                        ]
                    );

                    $label = $status === 'late' ? 'Clock-in berhasil (Terlambat)' : 'Clock-in berhasil';

                    Notification::make()
                        ->title($label)
                        ->success()
                        ->send();
                });
        }

        if ($employee && $todayAttendance && $todayAttendance->hasClockedIn() && ! $todayAttendance->hasClockedOut()) {
            $actions[] = Action::make('clockOut')
                ->label('Clock Out')
                ->icon('heroicon-o-arrow-left-on-rectangle')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Clock Out')
                ->modalDescription('Konfirmasi clock-out untuk hari ini?')
                ->visible(fn () => $user->can('clock', Attendance::class))
                ->action(function () use ($todayAttendance) {
                    $now = now();
                    $workEnd = $now->copy()->setTimeFromTimeString(Attendance::WORK_END);
                    $status = $todayAttendance->status;

                    if ($now->lt($workEnd) && $status === 'present') {
                        $status = 'early_leave';
                    }

                    $todayAttendance->update([
                        'clock_out' => $now,
                        'status' => $status,
                    ]);

                    Notification::make()
                        ->title('Clock-out berhasil')
                        ->body('Durasi kerja: '.$todayAttendance->fresh()->work_duration)
                        ->success()
                        ->send();
                });
        }

        if ($user && ! $user->hasRole('karyawan')) {
            $actions[] = CreateAction::make();
        }

        return $actions;
    }
}
