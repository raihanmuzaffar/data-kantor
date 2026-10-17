<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;

class LeaveRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('cuti.view');
    }

    public function view(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->can('cuti.view');
    }

    public function create(User $user): bool
    {
        return $user->can('cuti.create');
    }

    public function update(User $user, LeaveRequest $leaveRequest): bool
    {
        // Karyawan hanya bisa edit jika statusnya masih pending
        return $user->can('cuti.update') && $leaveRequest->status === 'pending';
    }

    public function delete(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->can('cuti.delete');
    }

    public function approve(User $user, LeaveRequest $leaveRequest): bool
    {
        // Hanya role yang punya izin cuti.approve yang bisa menyetujui
        return $user->can('cuti.approve') && $leaveRequest->status === 'pending';
    }

    public function reject(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->can('cuti.approve') && $leaveRequest->status === 'pending';
    }

    public function restore(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->can('cuti.delete');
    }

    public function forceDelete(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->can('cuti.delete');
    }
}
