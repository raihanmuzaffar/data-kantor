<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    public const WORK_START = '09:00';
    public const LATE_TOLERANCE_MINUTES = 15;
    public const WORK_END = '17:00';

    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
        'notes',
        'ip_address',
        'location_in',
        'location_out',
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public static function determineStatus(?\Carbon\Carbon $clockIn): string
    {
        if (! $clockIn) {
            return 'absent';
        }

        $workStart = $clockIn->copy()->setTimeFromTimeString(self::WORK_START);
        $lateThreshold = $workStart->copy()->addMinutes(self::LATE_TOLERANCE_MINUTES);

        if ($clockIn->gt($lateThreshold)) {
            return 'late';
        }

        return 'present';
    }

    public function getWorkDurationAttribute(): ?string
    {
        if (! $this->clock_in || ! $this->clock_out) {
            return null;
        }

        $minutes = $this->clock_in->diffInMinutes($this->clock_out);
        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;

        return sprintf('%d jam %d menit', $hours, $mins);
    }

    public function hasClockedIn(): bool
    {
        return $this->clock_in !== null;
    }

    public function hasClockedOut(): bool
    {
        return $this->clock_out !== null;
    }
}
