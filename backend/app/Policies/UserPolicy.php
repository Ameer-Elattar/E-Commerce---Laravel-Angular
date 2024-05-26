<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny( $admin): bool
    {
        return Auth::guard('api-admins')->check();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view( $user, User $model): bool
    {
        // dd(auth()->user()->id);
        return Auth::guard('api-admins')->check() || (Auth::guard('api')->check() && auth()->user()->id == $model->id);
    }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(Admin $admin): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $admin, User $model): bool
    {
        return Auth::guard('api-admins')->check() || (Auth::guard('api')->check() && auth()->user()->id == $model->id);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $admin, User $model): bool
    {
        return Auth::guard('api-admins')->check() || (Auth::guard('api')->check() && auth()->user()->id == $model->id);

    }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(Admin $admin, User $model): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(Admin $admin, User $model): bool
    // {
    //     //
    // }
}
