<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;

    /**
     * Status
     * 1. waiting payment
     * 2. waiting therapist
     * 3. onTheWay
     * 4. done
     * 5. cancelled
     */

    public $status = [
        'waiting_payment' => "Menunggu Pembayaran",
        "waiting_therapist" => "Mencari Terapis",
        "on_the_way" => "Dalam Perjalanan",
        "done" => "Selesai",
        "cancelled" => "Dibatalkan"
    ];


    protected $fillable = [
        'location_lat',
        'location_lng',
        'booking_date',
        'status',
        'total',
        'user_id'
    ];

    protected $hidden = [
        'deleted_at'
    ];



    /** location_lat, location_lng, booking_date */

    public function createInvoiceNumber($id){

        return "INV".date('dmY').str_pad($id, 8, '0', STR_PAD_LEFT);

    }

    public function saveInvoiceNumber(){

        $this->invoice_number = $this->createInvoiceNumber($this->id);

        $this->save();

        return $this;

    }


    public function orderDetails(){

        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function orderCosts(){

        return $this->hasMany(OrderCost::class, 'order_id', 'id');
    }

    public function calculateTotal(){

        $cost = new OrderCost();

        $detail = new OrderDetail();


    }



}
