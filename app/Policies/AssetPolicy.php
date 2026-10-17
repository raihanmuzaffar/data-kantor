<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;

class AssetPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('aset.view');
    }

    public function view(User $user, Asset $asset): bool
    {
        return $user->can('aset.view');
    }

    public function create(User $user): bool
    {
        return $user->can('aset.create');
    }

    public function update(User $user, Asset $asset): bool
    {
        return $user->can('aset.update');
    }

    public function delete(User $user, Asset $asset): bool
    {
        return $user->can('aset.delete');
    }

    public function restore(User $user, Asset $asset): bool
    {
        return $user->can('aset.delete');
    }

    public function forceDelete(User $user, Asset $asset): bool
    {
        return $user->can('aset.delete');
    }
}
