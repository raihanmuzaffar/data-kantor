<?php

namespace App\Policies;

use App\Models\Reimbursement;
use App\Models\User;

class ReimbursementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('reimburse.view');
    }

    public function view(User $user, Reimbursement $reimbursement): bool
    {
        if ($user->hasRole('karyawan')) {
            return $user->can('reimburse.view')
                && $user->employee
                && $reimbursement->employee_id === $user->employee->id;
        }

        return $user->can('reimburse.view');
    }

    public function create(User $user): bool
    {
        return $user->can('reimburse.create');
    }

    public function update(User $user, Reimbursement $reimbursement): bool
    {
        if ($user->hasRole('karyawan')) {
            return $user->can('reimburse.update')
                && $reimbursement->isPending()
                && $user->employee
                && $reimbursement->employee_id === $user->employee->id;
        }

        return $user->can('reimburse.update') && $reimbursement->isPending();
    }

    public function delete(User $user, Reimbursement $reimbursement): bool
    {
        return $user->can('reimburse.delete');
    }

    public function approve(User $user, Reimbursement $reimbursement): bool
    {
        return $user->can('reimburse.approve') && $reimbursement->isPending();
    }

    public function reject(User $user, Reimbursement $reimbursement): bool
    {
        return $user->can('reimburse.approve') && $reimbursement->isPending();
    }
}
