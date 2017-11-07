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
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function acceptReject(Request $request){

        $response = $request->response;


    }

    public function detail(Request $request, Order $order, $invoiceNumber){

        $order = $order->where('invoice_number', $invoiceNumber)
            ->with('orderDetail')
            ->with('orderCosts')
            ->first();

        return response()->json($order);
    }

}