<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Cart;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CartPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(Admin $admin): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Cart $cart): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create( $admin): bool
    {
        dd(Auth::guard('api')->user());
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Cart $cart): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Cart $cart): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(Admin $admin, Cart $cart): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(Admin $admin, Cart $cart): bool
    // {
    //     //
    // }
}
