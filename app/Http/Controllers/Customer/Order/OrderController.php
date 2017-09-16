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

        throw new NotFoundHttpException("asas");

        $userId  = auth('customer')->id();
        $limit = 10;
        $offset = $request->has('offset') ? $request->offset : 0;

        $orders = $order->where('user_id', $userId)->limit($limit)->offset($offset)->get();


        return response()->json($orders);

    }


}
