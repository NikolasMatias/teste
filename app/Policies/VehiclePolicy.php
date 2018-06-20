<?php

namespace FederalSt\Policies;

use FederalSt\User;
use FederalSt\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the vehicle.
     *
     * @param  \FederalSt\User  $user
     * @param  \FederalSt\Vehicle  $vehicle
     * @return mixed
     */
    public function view(User $user, Vehicle $vehicle)
    {
        return ($user->role >= User::ROLE_USER);
    }

    /**
     * Determine whether the user can create vehicles.
     *
     * @param  \FederalSt\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role >= User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can update the vehicle.
     *
     * @param  \FederalSt\User  $user
     * @param  \FederalSt\Vehicle  $vehicle
     * @return mixed
     */
    public function update(User $user, Vehicle $vehicle)
    {
        return $user->role >= User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can delete the vehicle.
     *
     * @param  \FederalSt\User  $user
     * @param  \FederalSt\Vehicle  $vehicle
     * @return mixed
     */
    public function delete(User $user, Vehicle $vehicle)
    {
        return $user->role >= User::ROLE_ADMIN;
    }
}
