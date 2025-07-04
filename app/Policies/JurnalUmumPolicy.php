<?php

namespace App\Policies;

use App\Models\User;
use App\Models\jurnal_umum;
use Illuminate\Auth\Access\Response;

class JurnalUmumPolicy
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
    public function view(User $user, jurnal_umum $jurnalUmum): bool
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
    public function update(User $user, jurnal_umum $jurnalUmum): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, jurnal_umum $jurnalUmum): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, jurnal_umum $jurnalUmum): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, jurnal_umum $jurnalUmum): bool
    {
        return false;
    }
}
