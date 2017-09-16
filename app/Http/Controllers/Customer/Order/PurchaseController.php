<?php

namespace App\Http\Controllers\Customer\Order;

use App\Models\Order;
use App\Models\Payment\Channel\BankTransfer\BankTransferBCA;
use App\Models\Payment\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    //

    public function getParams(Order $order, $orderId){

        $order = $order->find($orderId);

        return response()->json(
            [
                'amount'    => $order->total,
                'fees'      => $order->orderCosts()->get(),
                'invoice_number' => $order->invoice_number
            ]
        );
    }

    public function process(Request $request, Order $order, Payment $payment, $orderId, $channelKey){


        $data = $request->all();

        /** @var authorization dlu  */

        $channel = $this->channelRoute($channelKey);

        $order = $order->find($orderId);

        $payment = $channel->process($order, $payment, $data);

        $response = [
            'redirectWeb'   => '/html/thanks.html?mobile=false&id='.$orderId,
            'redirectMobile'      => 'thanks/'.$orderId
        ];


        return response()->json($response);

    }

    public function detail(Payment $payment, $orderId){

        $data = $payment->where('order_id','=' ,(integer) $orderId)->first();

        return response()->json($data);
    }

    public function channelRoute($channelKey){

        return new BankTransferBCA();

    }






}
