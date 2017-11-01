<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 10/15/17
 * Time: 5:09 PM
 */

namespace App\Models\Bidding;


use App\Models\Therapist\Settings;
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

    public function getTherapist(Settings $settings){

        $todayBid = cache('today_bid');

        if(!$todayBid){
            $this->reset();
        }

        $found = false;

        while(!$found){
            $offer =$this->offer->orderBy('offer', 'asc')->first();
            $settings = $settings->where(['userId' => $offer->therapist_id])->first();

            if(isset($settings->activeOrder) and $settings->activeOrder== "true"){
                $found = true;
            }

            $this->assign($offer);
        }


        $therapist = $this->therapist->find($offer->therapist_id);


        return $therapist;

    }

    public function assign($offer){

        if($offer instanceof Therapist){
            $offer = $this->offer->find($offer->therapist_id);
        }

        $offer->increment('offer');


    }

    public function assignFromTherapist($therapist){

        print_r($therapist);exit;
        $offer = $this->offer->find($therapist->id);

        $offer->increment('offer');


    }

    public function addOfferTherapist($therapist){
        $offer = $this->offer->firstOrCreate([
            'therapist_id'  => $therapist->id,
            'offer' => 0
        ]);

        return $offer;
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