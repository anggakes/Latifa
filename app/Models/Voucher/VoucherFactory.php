<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 8/23/17
 * Time: 1:15 AM
 */

namespace App\Models\Voucher;


use App\Models\Cart;

class VoucherFactory
{

    /**
     * @param Cart $cart
     * @param $voucherCode
     * @return bool
     * @throws VoucherException
     */

    public function check(Cart $cart, $voucherCode){

            // first get class same as voucher code
            $directory = 'App\Models\Voucher\Campaign\\';

            if (class_exists($directory . $voucherCode)) {
                $class = $directory . $voucherCode;

            } elseif (class_exists($directory . explode('_', $voucherCode)[0])) {
                $class = $directory . explode('_', $voucherCode)[0];
            }else{
                throw new VoucherException('voucher not found');
            }

            /** @var Campaign $campaign */
            $campaign = new $class();

            if(!$campaign->active) throw new VoucherException('voucher not active');

            return $campaign->check($cart, $voucherCode);

    }

    /**
     * @param Cart $cart
     * @param $voucherCode
     * @return VoucherData
     * @throws VoucherException
     */
    public function apply(Cart $cart, $voucherCode){


        // first get class same as voucher code
        $directory = 'App\Models\Voucher\Campaign\\';

        if (class_exists($directory . $voucherCode)) {
            $class = $directory . $voucherCode;

        } elseif (class_exists($directory . explode('_', $voucherCode)[0])) {
            $class = $directory . explode('_', $voucherCode)[0];
        }else{
            throw new VoucherException('voucher not found');
        }

        /** @var Campaign $campaign */
        $campaign = new $class();

        if(!$campaign->active) throw new VoucherException('voucher not active');

        $campaign->check($cart, $voucherCode);

        return $campaign->apply($cart, $voucherCode);

    }


}