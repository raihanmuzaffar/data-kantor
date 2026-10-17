<?php

namespace App\Policies;

use App\Models\DocumentCategory;
use App\Models\User;

class DocumentCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('dokumen_category.view');
    }

    public function view(User $user, DocumentCategory $documentCategory): bool
    {
        return $user->can('dokumen_category.view');
    }

    public function create(User $user): bool
    {
        return $user->can('dokumen_category.create');
    }

    public function update(User $user, DocumentCategory $documentCategory): bool
    {
        return $user->can('dokumen_category.update');
    }

    public function delete(User $user, DocumentCategory $documentCategory): bool
    {
        return $user->can('dokumen_category.delete');
    }
}
