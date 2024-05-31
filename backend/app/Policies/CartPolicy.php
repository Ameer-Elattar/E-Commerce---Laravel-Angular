<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isInstanceOf;

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
         
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Cart $cart): bool
    {
        
        return $user->id==$cart->user_id || $user instanceof Admin;    
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Cart $cart): bool
    {
        return $user->id==$cart->user_id  || $user instanceof Admin;
    }
    public function destroyAllCartItems($authUser, User $user): bool
    {
        return $authUser->id == $user->id || $authUser instanceof Admin;
    }
    public function FindAllUserCartItems(  $authUser, User $user)
    {
        
        return $authUser->id == $user->id || $authUser instanceof Admin;
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
