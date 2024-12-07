<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;

class SupplierPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    // sembunyikan kolom opsi di Produk untuk Kasir
    public function viewOpsi(User $user) : bool
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Supplier $supplier): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Supplier $supplier): bool
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Supplier $supplier): bool
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Supplier $supplier): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Supplier $supplier): bool
    {
        return false;
    }
}
