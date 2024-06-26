<?php

namespace App\Policies;

use App\Models\Crop;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CropPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Crop $crop): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->id > 0;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Crop $crop): bool
    {
        return $user->id === $crop->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Crop $crop): bool
    {
        return $user->id === $crop->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Crop $crop): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Crop $crop): bool
    {
        return $user->isAdmin();
    }
}
