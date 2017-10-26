<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 10/15/17
 * Time: 5:09 PM
 */

namespace App\Models\Bidding;


use App\Models\Therapist\Therapist;
use Carbon\Carbon;

use Cache;

class BiddingTherapist
{

    private $order;

    private $offer;

    private $therapist;

    public function __construct($order, Offer $offer, Therapist $therapist)
    {

        $this->order = $order;

        $this->offer = $offer;

        $this->therapist = $therapist;

    }

    public function getTherapist(){

        $todayBid = cache('today_bid');

        if(!$todayBid){
            $this->reset();
        }

        $offer =$this->offer->orderBy('offer', 'asc')->first();

        $therapist = $this->therapist->find($offer->therapist_id);


        return $therapist;

    }

    public function assign($therapist){

        $offer = $this->offer->where('therapist_id', $therapist->id)->first();

        $offer->increment('offer');

    }

    public function reset(){

        cache(['today_bid' => true], Carbon::now()->addDay(1));

        $therapist = $this->therapist->all();

        $this->offer->truncate();
        // set nol;
        foreach ($therapist as $t){
            $this->offer->create([
                'therapist_id'  => $t->id,
                'offer' => 0
            ]);
        }

    }
}