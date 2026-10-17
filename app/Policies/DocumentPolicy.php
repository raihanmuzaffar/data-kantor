<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('dokumen.view');
    }

    public function view(User $user, Document $document): bool
    {
        return $user->can('dokumen.view');
    }

    public function create(User $user): bool
    {
        return $user->can('dokumen.create');
    }

    public function update(User $user, Document $document): bool
    {
        return $user->can('dokumen.update');
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->can('dokumen.delete');
    }

    public function restore(User $user, Document $document): bool
    {
        return $user->can('dokumen.delete');
    }

    public function forceDelete(User $user, Document $document): bool
    {
        return $user->can('dokumen.delete');
    }
}
