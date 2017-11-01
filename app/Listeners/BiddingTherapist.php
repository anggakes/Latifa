<?php

namespace App\Listeners;

use App\Events\Order\OrderCheckout;
use App\Models\Bidding\LogBidding;
use App\Models\Bidding\Offer;
use App\Models\Order;
use App\Models\Therapist\Settings;
use App\Models\Therapist\Therapist;
use App\Notifications\BiddingOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Bidding\BiddingTherapist as Bidding;

class BiddingTherapist
{


    protected $biddingTherapist;
    protected $settings;
    protected $log;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Settings $settings,
                                LogBidding $logBidding)
    {

        //
        $this->biddingTherapist = new Bidding(new Order, new Offer(), new Therapist());
        $this->settings = $settings;
        $this->log = $logBidding;
    }

    /**
     * Handle the event.
     *
     * @param  OrderCheckout  $event
     * @return void
     */
    public function handle(OrderCheckout $event)
    {


//        $t = $this->biddingTherapist->getTherapist(new Settings());

//        $this->biddingTherapist->assignFromTherapist($t);
        $t = new Therapist();
        $t = $t->find(3);

        //

        $this->log->create([
            'therapist_id' => $t->id,
            'invoice_number' => $event->order->invoice_number,
            'response' => 'reject'
        ]);

        $t->notify(new BiddingOrder($event->order));



    }
}
