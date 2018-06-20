<?php

namespace FederalSt\Listeners;

use FederalSt\Events\VehicleDestroy;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVehiclesDestroyEmail
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
     * @param  VehicleDestroy  $event
     * @return void
     */
    public function handle(VehicleDestroy $event)
    {
        $event->user->sendDestroyVehicleNotification($event->vehicle);
    }
}
