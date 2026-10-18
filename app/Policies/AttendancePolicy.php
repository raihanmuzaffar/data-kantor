<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('absensi.view');
    }

    public function view(User $user, Attendance $attendance): bool
    {
        if ($user->hasRole('karyawan')) {
            return $user->can('absensi.view')
                && $user->employee
                && $attendance->employee_id === $user->employee->id;
        }

        return $user->can('absensi.view');
    }

    public function create(User $user): bool
    {
        return $user->can('absensi.create');
    }

    public function update(User $user, Attendance $attendance): bool
    {
        if ($user->hasRole('karyawan')) {
            return false;
        }

        return $user->can('absensi.update');
    }

    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->can('absensi.delete');
    }

    public function restore(User $user, Attendance $attendance): bool
    {
        return $user->can('absensi.delete');
    }

    public function forceDelete(User $user, Attendance $attendance): bool
    {
        return $user->can('absensi.delete');
    }

    public function clock(User $user): bool
    {
        return $user->can('absensi.create') && $user->employee !== null;
    }
}
