<?php

namespace App\Http\Controllers\Customer\Order;

use App\Models\Order;
use App\Models\OrderCost;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends Controller
{
    //
    public function __construct()
    {

    }

//    public function

    public function all(Request $request, Order $order){

        $userId  = auth('customer')->id();
        $status  = $request->status;


        $perPage = 15;

        $orders = $order->where('user_id', $userId);

        if($status == 'done'){
            $orders->where('status', 'done');
        }

        $orders = $orders->with('product')->paginate($perPage);


        return response()->json($orders);

    }


}
