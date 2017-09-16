<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 8/23/17
 * Time: 12:42 AM
 */

namespace App\Models\Voucher;

/**
 * RULES:
 * campaign name must all capital
 * if using prefix, class name is the prefix, vocuher_code using underscore (_) after prefix
 */
use App\Models\Cart;
use League\Flysystem\Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

abstract class Campaign
{


    public $active = true;

    /**
     * @param Cart $cart
     * @param $voucherCode
     * @return bool
     * @throws VoucherException
     */
    public function check(Cart $cart, $voucherCode){

        if(
            $this->isCodeValid($voucherCode) &&
            $this->isUserValid($cart->user_id) &&
            !$this->isExpired() &&
            $this->isCartValid($cart)
        ){
            return true;
        }

        throw new VoucherException('Voucher not valid');

    }

    /**
     * @param $cart
     * @param $voucherCode
     * @return VoucherData
     */
    public abstract function apply($cart, $voucherCode);


    /**
     * @param $cart
     * @return bool
     * @throws VoucherException
     */
    protected function isCartValid($cart){
        return true;
    }

    /**
     * @param $userId
     * @return bool
     * @throws VoucherException
     */
    protected function isUserValid($userId){
        return true;
    }

    /**
     * @return bool
     * @throws VoucherException
     */
    protected function isExpired(){
        return false;
    }

    protected function isCodeValid($voucherCode){
        return true;
    }



}