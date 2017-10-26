<?php

namespace App\Listeners;

use App\Events\Order\OrderCheckout;
use App\Notifications\BiddingOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Bidding\BiddingTherapist as Bidding;

class BiddingTherapist
{


    protected $biddingTherapist;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Bidding $biddingTherapis )
    {

        //
        $this->biddingTherapist = $biddingTherapis;
    }

    /**
     * Handle the event.
     *
     * @param  OrderCheckout  $event
     * @return void
     */
    public function handle(OrderCheckout $event)
    {


        $t = $this->biddingTherapist->getTherapist();

        $this->biddingTherapist->assign($t);

        //

        $t->notify(new BiddingOrder($event->order));

    }
}
