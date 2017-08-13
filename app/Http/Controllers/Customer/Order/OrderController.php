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

    public function make(Request $request,
                         Order $order,
                         Product $product,
                         OrderDetail $orderDetail,
                         OrderCost $orderCost){

        /** validation */
        $this->validate($request, [
            'sku'   => 'required',
            'location_lat' => 'required',
            'location_lng' => 'required',
            'booking_date' => 'required'
        ]);

        try{

            DB::beginTransaction();

            $order = $order->create([
                'location_lat' => $request->location_lat,
                'location_lng' => $request->location_lng,
                'booking_date' => $request->booking_date,
                'status' => 'waiting_payment',
                'total' => 0,
                'user_id' => auth('customer')->id()
            ]);

            $total = 0;

            // isi detail
            // get product
            foreach ($request->sku as $sku){
                $product = $product->where('sku', $sku)->first();
                $price = $product->getFixPrice();
                $total += $price;
                $orderDetail->forceFill([
                    'order_id' => $order->id,
                    'price' => $price,
                    'name' => $product->name,
                    'sku' => $sku,
                ]);
                $orderDetail->save();


                // isi costs
                $orderCost->forceFill([
                    'label' => 'subtotal',
                    'value' => $price,
                    'note' => '',
                    'order_id' => $order->id,
                ]);

                $orderCost->save();
            }


            // count total
            $order->total = $total;
            $order->saveInvoiceNumber();
            $order->save();


            $order->order_detail = $order->orderDetails()->get();
            $order->order_costs = $order->orderCosts()->get();


            DB::commit();


            return response()->json($order);

        }catch (\Exception $e){

            DB::rollBack();
            throw new BadRequestHttpException($e->getMessage());

        }

    }

    public function all(Request $request, Order $order){

        throw new NotFoundHttpException("asas");

        $userId  = auth('customer')->id();
        $limit = 10;
        $offset = $request->has('offset') ? $request->offset : 0;

        $orders = $order->where('user_id', $userId)->limit($limit)->offset($offset)->get();


        return response()->json($orders);

    }


}
