<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 8/23/17
 * Time: 10:58 AM
 */

namespace App\Models\Voucher\Rules;


use App\Models\Voucher\VoucherData;

class FixedVoucher
{
    private $nominal;

    private $label;

    private $voucherCode;

    private $cart;

    public function __construct($cart, $label, $voucherCode, $nominal)
    {

        $this->nominal = $nominal;
        $this->label = $label;
        $this->voucherCode = $voucherCode;
        $this->cart = $cart;

    }

    public function run()
    {
        $voucher = new VoucherData();

        $voucher->label = $this->label;

        $voucher->voucher_code = $this->voucherCode;

        if($this->nominal < $this->cart->total){
            $voucher->nominal = $this->nominal;
        }else{
            $voucher->nominal = $this->cart->total;
        }

        return $voucher;
    }
}