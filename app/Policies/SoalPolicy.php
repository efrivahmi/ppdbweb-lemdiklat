<?php

namespace App\Policies;

use App\Models\Pendaftaran\CustomTestQuestion;
use App\Models\Pendaftaran\CustomTest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SoalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin dan Guru bisa view list soal
        return $user->isAdmin() || $user->isGuru();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomTestQuestion $customTestQuestion): bool
    {
        $customTest = $customTestQuestion->customTest;

        // Admin bisa view semua
        if ($user->isAdmin()) {
            return true;
        }

        // Guru hanya bisa view soal dari mapel yang dia pegang
        if ($user->isGuru() && $customTest) {
            return $user->canManageMapel($customTest->mapel_id);
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin dan Guru yang memiliki mapel bisa create soal
        return $user->isAdmin() || $user->canManageSoal();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomTestQuestion $customTestQuestion): bool
    {
        $customTest = $customTestQuestion->customTest;

        // Admin bisa update semua
        if ($user->isAdmin()) {
            return true;
        }

        // Guru hanya bisa update soal dari mapel yang dia pegang
        if ($user->isGuru() && $customTest) {
            return $user->canManageMapel($customTest->mapel_id);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomTestQuestion $customTestQuestion): bool
    {
        // Hanya admin yang bisa delete soal
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomTestQuestion $customTestQuestion): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomTestQuestion $customTestQuestion): bool
    {
        return $user->isAdmin();
    }
}
