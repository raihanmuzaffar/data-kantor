<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('pengumuman.view');
    }

    public function view(User $user, Announcement $announcement): bool
    {
        return $user->can('pengumuman.view');
    }

    public function create(User $user): bool
    {
        return $user->can('pengumuman.create');
    }

    public function update(User $user, Announcement $announcement): bool
    {
        return $user->can('pengumuman.update');
    }

    public function delete(User $user, Announcement $announcement): bool
    {
        return $user->can('pengumuman.delete');
    }

    public function restore(User $user, Announcement $announcement): bool
    {
        return $user->can('pengumuman.delete');
    }

    public function forceDelete(User $user, Announcement $announcement): bool
    {
        return $user->can('pengumuman.delete');
    }
}
