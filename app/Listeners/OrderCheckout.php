<?php

namespace App\Listeners;

use App\Events\Order\OrderCheckout as Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCheckout
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
    public function handle(Event $event)
    {
        //
    }
}
