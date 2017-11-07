<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 10/31/17
 * Time: 5:37 PM
 */

namespace App\Http\Controllers\Therapist;


use App\Http\Controllers\Controller;
use App\Models\Order;
use GuzzleHttp\Psr7\Request;

class OrderController extends Controller
{


    public function acceptReject(Request $request){

        $response = $request->response;


    }

    public function detail(Request $request, Order $order){
        
        $invoiceNumber = $request->invoice_number;

        $order = $order->where('invoice_number', $invoiceNumber)->first();

        return response()->json($order);
    }

}