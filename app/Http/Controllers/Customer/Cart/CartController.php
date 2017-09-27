<?php

namespace App\Http\Controllers\Customer\Cart;

use App\Events\Order\OrderCheckout;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher\VoucherException;
use App\Models\Voucher\VoucherFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use DB;

class CartController extends Controller
{
    //

    public function page(){
        return view('customer/cart');
    }

    public function setProduct(Request $request, Product $product, Cart $cart){

        $userId = auth('customer')->user()->id;

        $sku = $request->sku;

        $item = $product->fromSku($sku);

        $cart->where('user_id', $userId)->delete();

        $cart = $cart->firstOrCreate(['user_id' => $userId]);

        $cart->setProduct($item)->save();

        return $cart;

    }

    public function setLocation(Request $request, Cart $cart){

        $lat = $request->lat;
        $lng = $request->lng;
        $address  = $request->address;
        $label  = $request->label;

        $userId = auth('customer')->user()->id;

        $cart = $cart->firstOrCreate(['user_id' => $userId]);

        $cart->setLocation($lat, $lng, $label, $address)->save();

        return $cart;

    }

    public function setBookingDate(Request $request, Cart $cart){

        $bookingDate = $request->booking_date;

        $userId = auth('customer')->user()->id;

        $cart = $cart->firstOrCreate(['user_id' => $userId]);

        $cart->setBookingDate($bookingDate)->save();

        return $cart;

    }

    public function setVoucher(Request $request, Cart $cart, VoucherFactory $voucher){

        $userId = auth('customer')->user()->id;

        $cart = $cart->firstOrCreate(['user_id' => $userId]);


        try{

            $voucherCode = $request->voucher_code;

            if($cart->voucher != null) $cart->removeVoucher()->save();

            if(!$voucherCode) throw  new VoucherException('voucher tidak valid');

            $voucher = $voucher->apply($cart, $voucherCode);

            $cart->setVoucher($voucher)->save();

            return $cart;

        }catch (VoucherException $e){

            // remove voucher
            $cart->removeVoucher()->save();

            throw  new UnprocessableEntityHttpException($e->getMessage());
        }

    }

    public function cart(Cart $cart){

        $userId = auth('customer')->user()->id;

        $cart = $cart->firstOrCreate(['user_id' => $userId]);

        $reponse = [
            "_id" => $cart->_id?:0,
            "user_id"=> $cart->user_id?:0,
            "updated_at"=> $cart->updated_at?:'',
            "created_at"=> $cart->created_at?:'',
            "item"=> $cart->item?:[],
            "fees"=> $cart->fees?:[],
            "total"=> $cart->total?:0,
            "location"=> $cart->location?:null,
            "booking_date"=>$cart->booking_date?:'',
            "voucher"=> $cart->voucher?:null
        ];

        return $cart;

    }


    public function checkout(Cart $cart, Request $request, Order $orderModel){


        $userId = auth('customer')->user()->id;

        $cart = $cart->where('user_id',$userId)->first();

        if(!$cart){
            return new BadRequestHttpException('empty cart');
        }

        $this->validate($request, [
            'note'  => ''
        ]);

        $note = $request->note;
        $isMobile = $request->is_mobile;

        try{

            DB::beginTransaction();
//
            $order = $orderModel->create([
                'location_lat' => $cart->location['lat'],
                'location_lng' => $cart->location['lng'],
                'address' => $cart->location['address'],
                'address_label' => $cart->location['label'],
                'booking_date' => $cart->booking_date,
                'note'  => $note,
                'status' => 'waiting_payment',
                'total' => 0,
                'user_id' => auth('customer')->id()
            ]);


            $order->orderDetails()->create([
                'price' => $cart->item['sale_price'] > 0 ? $cart->item['salePrice'] : $cart->item['price'],
                'name' => $cart->item['name'],
                'sku' => $cart->item['sku'],
            ]);

            // isi costs

            foreach ($cart->fees as $fee){
                $order->orderCosts()->create([
                    'label' => $fee['label'],
                    'value' => $fee['value'],
                    'note' => '',
                ]);
            }

            $order->setInvoiceNumber(false)
                ->calculateTotal(false)
                ->save();

            $order->order_detail = $order->orderDetails()->get();
            $order->order_costs = $order->orderCosts()->get();

            DB::commit();

            // fire event
            event(new OrderCheckout($order));

            // delete the cart
            $cart->delete();


            $redirectMobile  = "payment_list/".$order->id;
            $redirectWeb  = '/html/payment_list.html?mobile=false&id='.$order->id;

            $response = [
                'order' => $order,
                'redirectWeb' => $redirectWeb,
                'redirectMobile' => $redirectMobile
            ];

            return response()->json($response);

        }catch (\Exception $e){

            DB::rollBack();
            throw new BadRequestHttpException($e->getMessage());

        }

    }



}
