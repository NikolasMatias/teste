<?php

namespace FederalSt\Listeners;

use FederalSt\Events\VehicleStore;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVehiclesStoreEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VehicleStore  $event
     * @return void
     */
    public function handle(VehicleStore $event)
    {
        $event->user->sendStoreVehicleNotification($event->vehicle);
    }
}
