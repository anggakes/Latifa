<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 8/23/17
 * Time: 11:09 AM
 */

namespace App\Models\Voucher\Rules;


use App\Models\Voucher\VoucherData;

class PercentageVoucher
{


    private $label;

    private $voucherCode;

    private $cart;

    private $percentage;

    private $cap;

    public function __construct($cart, $label, $voucherCode, $percentage, $cap)
    {

        $this->percentage = $percentage;
        $this->cap = $cap;
        $this->label = $label;
        $this->voucherCode = $voucherCode;
        $this->cart = $cart;

    }

    /**
     * @return VoucherData
     */
    public function run()
    {
        $voucher = new VoucherData();

        $voucher->label = $this->label;

        $voucher->voucher_code = $this->voucherCode;

        $nominal = $this->cart->total * ($this->percentage/100);

        if($nominal > $this->cap){

            $nominal = $this->cap;

        }

        $voucher->nominal = $nominal;

        return $voucher;
    }
}