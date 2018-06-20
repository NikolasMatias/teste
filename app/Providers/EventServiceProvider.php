<?php

namespace FederalSt\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'FederalSt\Events\VehicleStore' => [
            'FederalSt\Listeners\SendVehiclesStoreEmail',
        ],
        'FederalSt\Events\VehicleUpdate' => [
            'FederalSt\Listeners\SendVehiclesUpdateEmail',
        ],
        'FederalSt\Events\VehicleDestroy' => [
            'FederalSt\Listeners\SendVehiclesDestroyEmail',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
