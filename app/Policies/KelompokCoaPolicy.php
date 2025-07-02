<?php

namespace App\Policies;

use App\Models\User;
use App\Models\kelompok_coa;
use Illuminate\Auth\Access\Response;

class KelompokCoaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, kelompok_coa $kelompokCoa): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, kelompok_coa $kelompokCoa): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, kelompok_coa $kelompokCoa): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, kelompok_coa $kelompokCoa): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, kelompok_coa $kelompokCoa): bool
    {
        return false;
    }
}
