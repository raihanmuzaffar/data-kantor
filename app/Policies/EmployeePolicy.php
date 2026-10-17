<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('karyawan.view');
    }

    public function view(User $user, Employee $employee): bool
    {
        return $user->can('karyawan.view');
    }

    public function create(User $user): bool
    {
        return $user->can('karyawan.create');
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->can('karyawan.update');
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->can('karyawan.delete');
    }

    public function restore(User $user, Employee $employee): bool
    {
        return $user->can('karyawan.delete');
    }

    public function forceDelete(User $user, Employee $employee): bool
    {
        return $user->can('karyawan.delete');
    }
}
