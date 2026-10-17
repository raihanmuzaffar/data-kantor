<?php

namespace App\Policies;

use App\Models\Division;
use App\Models\User;

class DivisionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('divisi.view');
    }

    public function view(User $user, Division $division): bool
    {
        return $user->can('divisi.view');
    }

    public function create(User $user): bool
    {
        return $user->can('divisi.create');
    }

    public function update(User $user, Division $division): bool
    {
        return $user->can('divisi.update');
    }

    public function delete(User $user, Division $division): bool
    {
        return $user->can('divisi.delete');
    }

    public function restore(User $user, Division $division): bool
    {
        return $user->can('divisi.delete');
    }

    public function forceDelete(User $user, Division $division): bool
    {
        return $user->can('divisi.delete');
    }
}
