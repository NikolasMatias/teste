<?php

namespace FederalSt\Listeners;

use FederalSt\Events\VehicleUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVehiclesUpdateEmail
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
     * @param  VehicleUpdate  $event
     * @return void
     */
    public function handle(VehicleUpdate $event)
    {
        $event->user->sendUpdateVehicleNotification($event->vehicle);
    }
}
