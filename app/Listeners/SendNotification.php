<?php

namespace App\Listeners;

use App\Events\Order\OrderCheckout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification
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
     * @param  OrderCheckout  $event
     * @return void
     */
    public function handle(OrderCheckout $event)
    {
        //

//        print_r($event->order);;exit;
    }
}
