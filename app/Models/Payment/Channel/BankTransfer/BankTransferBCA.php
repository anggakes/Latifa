<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 9/8/17
 * Time: 12:37 AM
 */

namespace App\Models\Payment\Channel\BankTransfer;


use App\Models\Order;

class BankTransferBCA
{

    public $uniqueTransactionNegative = false;


    public function __construct()
    {

    }

    /**
     * checking the channel is active
     */
    public function isActive(){

        return true;

    }

    public function getName(){

        return "Bank Transfer BCA";
    }

    /**
     * @return $this
     * set uniq transaction code, useful for bank transfer
     */
    public function setFee($order, $payment){

        $unique_transaction_code = $order->id%1000;

        if($this->uniqueTransactionNegative){
            $unique_transaction_code *= -1;
        }

        $payment->fee = $unique_transaction_code;

        $payment->save();
    }

    public function getFee($order){

        $unique_transaction_code = $order->id%1000;

        if($this->uniqueTransactionNegative){
            $unique_transaction_code *= -1;
        }

        return $unique_transaction_code;
    }

    public function getFeeLabel(){

        return "Kode Unik";
    }

    public function process($order, $payment, $data){

        $fee = $this->getFee($order);
        $orderAmount = $order->total;

        $payment->order_id          = $order->id;
        $payment->channel           = $this->getName();
        $payment->class             = self::class;
        $payment->fee_label         = $this->getFeeLabel();
        $payment->fee_value         = $fee;
        $payment->order_amount      = $orderAmount;
        $payment->payment_amount    = $orderAmount + $fee; // jumlah yang harus dibayar

        /** for bank transfer */
        $payment->account_name = $data['account_name'];
        $payment->account_number = $data['account_number'];

        $payment->type      = "BANKTRANSFER";
        $payment->status    = "process"; // sedang di proses, meunggu konfirmasi
        $payment->channel_key = "BANKTRANSFERBCA";

        // write log();
        $payment->save();

        return $payment;

    }

    public function checkPayment(){

    }

    public function paid(Order $order, $data){

        $order->updateStatus('paid');

        // fire event



    }

}