<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $model;

    public function __construct(Product $product)
    {

        $this->model = $product;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return response()->json($this->model->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required',
            'sale_price' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $getImageName = uniqid().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('product_images'), $getImageName);


        $req = $request->all();

        $req['image'] = 'product_images/'.$getImageName;
        $this->model->forceFill($req);
        $this->model->save();


        return response()->json($this->model->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = $this->model->where('sku', $id)->first();


        return response()->json($product->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'sku' => 'required',
            'sale_price' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $req = $request->all();

        unset($req['_method']);

        if($request->hasFile('image')){
            $getImageName = uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('product_images'), $getImageName);
            $req['image'] = 'product_images/'.$getImageName;
        }

        $product = $this->model->where('sku', $id)->first();
        $product->forceFill($req);
        $product->save();


        return response()->json($product->toArray());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $deleted = $this->model->where('sku', $id)->delete();

        return response()->json($deleted);
    }
}
