<?php

namespace FederalSt\Policies;

use FederalSt\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \FederalSt\User  $user
     * @param  \FederalSt\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->role >= User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \FederalSt\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \FederalSt\User  $user
     * @param  \FederalSt\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \FederalSt\User  $user
     * @param  \FederalSt\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }
}
