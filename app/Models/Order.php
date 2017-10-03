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
     * 1. waiting_payment
     * 2. paid,
     * 3. finding_therapist
     * 4. onTheWay
     * 5. done
     * 6. cancelled
     */

    public $status = [
        "finding_therapist" => "Mencari Terapis",
        "serving" => "Mulai Layanan",
        "done" => "Selesai",
        "cancelled" => "Pesanan Dibatalkan"
    ];


    protected $fillable = [
        'location_lat',
        'location_lng',
        'address',
        'address_label',
        'booking_date',
        'status',
        'total',
        'user_id'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    // unique transaction +/-
    public $uniqueTransactionNegative = false;



    /** location_lat, location_lng, booking_date */

    public function createInvoiceNumber($id){

        return "INV".date('dmY').str_pad($id, 8, '0', STR_PAD_LEFT);

    }

    public function setInvoiceNumber($save = true){

        $this->invoice_number = $this->createInvoiceNumber($this->id);

        if($save){
            $this->save();
        }

        return $this;

    }


    public function orderDetails(){

        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function orderCosts(){

        return $this->hasMany(OrderCost::class, 'order_id', 'id');
    }

    public function calculateTotal($save = true){

        $total = 0;

        $costs = $this->orderCosts()->get();

        foreach ($costs as $cost){
            $total += $cost->value;
        }

        $this->total = $total;

        if($save){
            $this->save();
        }

        return $this;

    }

    public function updateStatus($status){

        $this->status = $status;

        $this->save();

        return $this;
    }


    public function product(){

        return $this->hasOne(Product::class);

    }

}
