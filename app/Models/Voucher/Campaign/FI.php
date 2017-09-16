<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 8/23/17
 * Time: 12:41 AM
 */

namespace App\Models\Voucher\Campaign;


use App\Models\Voucher\Campaign;
use App\Models\Voucher\Rules\FixedVoucher;
use App\Models\Voucher\VoucherData;

class FI extends Campaign
{

    private $nominal = 100000;

    private $label = 'Gratis Internship';

    private $code = [
        'FI_1234',
        'FI_2345',
    ];

    public $active = true;


    protected function isCodeValid($voucherCode){

        if(in_array($voucherCode, $this->code)) return true;

        return false;
    }


    /**
     * @param $cart
     * @param $voucherCode
     * @return VoucherData
     */
    public function apply($cart, $voucherCode)
    {
        $voucher = new FixedVoucher($cart, $this->label, $voucherCode, $this->nominal);

        return $voucher->run();

    }


}