<?php

namespace App\Http\Controllers\Customer\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //

    public function index(Request $request, Product $product)
    {

        return response()->json($product->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $id)
    {

        $p = $product->where('sku', $id)->first();


        return response()->json($p->toArray());
    }
}