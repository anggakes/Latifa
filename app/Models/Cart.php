<?php

namespace App\Models;



use App\Models\Voucher\VoucherData;
use Jenssegers\Mongodb\Eloquent\Model;

class Cart extends Model
{
    //
    protected $connection = 'mongodb';

    protected $fillable = [
      'user_id'
    ];


    public function addFee($key, $label, $value){

        $fees = $this->fees;

        $fees[] = [
            'key'   => $key,
            'label' => $label,
            'value'   => $value
        ];

        $this->fees = $fees;


        $this->countTotal();

        return $this;

    }

    public function removeFee($keyFee){

        $fees = $this->fees;

        foreach ($fees as $key=>$fee){
            if($fee['key'] == $keyFee){
                unset($fees[$key]);
            }
        }

        $this->fees = $fees;


        $this->countTotal();

        return $this;
    }

    public function countTotal(){

        $total = 0;

        foreach ($this->fees as $fee){
            $total += $fee['value'];
        }

        $this->total = $total;

        return $this;

    }

    public function setProduct(Product $product){

        $this->item = $product->toArray();

        $this->addFee('subtotal', 'Subtotal', $product->getFixPrice());

        return $this;
    }


    public function setLocation($lat, $lng, $label, $address){

        $this->location = [
            'lat'   => $lat,
            'lng'   => $lng,
            'address' => $address,
            'label' => $label
        ];

        return $this;
    }

    public function setBookingDate($date){

        $this->booking_date = $date;

        return $this;
    }

    public function setVoucher(VoucherData $voucher){

        $this->voucher  = $voucher;

        $this->addFee('voucher',$voucher->label, $voucher->nominal*-1); // minus

        return $this;
    }

    public function removeVoucher(){

        $this->voucher = null;

        $this->removeFee('voucher');

        return $this;
    }


}
