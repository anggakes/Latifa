<?php

namespace App\Listeners;

use App\Events\Order\OrderCheckout;
use App\Models\Therapist\Settings;
use App\Notifications\BiddingOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Bidding\BiddingTherapist as Bidding;

class BiddingTherapist
{


    protected $biddingTherapist;
    protected $settings;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Bidding $biddingTherapist, Settings $settings)
    {

        //
        $this->biddingTherapist = $biddingTherapist;
        $this->settings = $settings;
    }

    /**
     * Handle the event.
     *
     * @param  OrderCheckout  $event
     * @return void
     */
    public function handle(OrderCheckout $event)
    {


        $t = $this->biddingTherapist->getTherapist($this->settings);

        $this->biddingTherapist->assign($t);

        //

        $t->notify(new BiddingOrder($event->order));

    }
}
