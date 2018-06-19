<?php

namespace FederalSt\Providers;

use FederalSt\Policies\UserPolicy;
use FederalSt\Policies\VehiclePolicy;
use FederalSt\User;
use FederalSt\Vehicle;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'FederalSt\Model' => 'FederalSt\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Vehicle::class, VehiclePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Para os Usuáiros
        Gate::define('users.index', 'FederalSt\Policies\UserPolicy@view');

        //Para os Veículos
        Gate::define('vehicles.store', 'FederalSt\Policies\VehiclePolicy@create');
        Gate::define('vehicles.update', 'FederalSt\Policies\VehiclePolicy@update');
        Gate::define('vehicles.destroy', 'FederalSt\Policies\VehiclePolicy@delete');

    }
}
