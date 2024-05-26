<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny( $admin): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(Admin $admin, Product $product): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can create models.
     */
    public function create( $admin): bool
    {
        return Auth::guard('api-admins')->check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $admin, Product $product): bool
    {
        return Auth::guard('api-admins')->check();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $admin, Product $product): bool
    {
        return Auth::guard('api-admins')->check();
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(Admin $admin, Product $product): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(Admin $admin, Product $product): bool
    // {
    //     //
    // }
}
