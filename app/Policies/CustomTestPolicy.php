<?php

namespace App\Policies;

use App\Models\Pendaftaran\CustomTest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomTestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin dan Guru bisa view list test
        return $user->isAdmin() || $user->isGuru();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomTest $customTest): bool
    {
        // Admin bisa view semua
        if ($user->isAdmin()) {
            return true;
        }

        // Guru hanya bisa view test dari mapel yang dia pegang
        if ($user->isGuru()) {
            return $user->canManageMapel($customTest->mapel_id);
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin dan Guru dengan mapel bisa create custom test
        return $user->canCreateCustomTest();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomTest $customTest): bool
    {
        // Admin bisa update semua
        if ($user->isAdmin()) {
            return true;
        }

        // Guru hanya bisa update test dari mapelnya
        if ($user->isGuru()) {
            return $user->canManageCustomTest($customTest);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomTest $customTest): bool
    {
        // Admin bisa delete semua
        if ($user->isAdmin()) {
            return true;
        }

        // Guru hanya bisa delete test dari mapelnya
        if ($user->isGuru()) {
            return $user->canManageCustomTest($customTest);
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomTest $customTest): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomTest $customTest): bool
    {
        return $user->isAdmin();
    }
}
