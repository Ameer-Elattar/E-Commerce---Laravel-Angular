<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Order;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user instanceof Admin; ; 
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Order $order): bool
    {
        return $user->id==$order->user_id || $user instanceof Admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Order $order): bool
    {
        return $user->id==$order->user_id || $user instanceof Admin;
    }
    public function done($user, Order $order): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Order $order): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Order $order): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Order $order): bool
    {
        //
    }
}
