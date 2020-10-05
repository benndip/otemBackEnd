<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = new Order;
        $orders = $orders->with('user');
        $orders = $orders->with('orderedProducts');
        $orders = $orders->with('orderedProducts.product');
        $orders = $orders->with('orderedProducts.product.category');
        $orders = $orders->with('orderedProducts.product.productImages');
        $orders = $orders->get();
        return $orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        //
        $this->validate($request,[
            'products' => 'required|array',
            'quantities' => 'required|array'
        ]);

        $user_id = 5;
        $products =$request->input('products');
        $quantities = $request->input('quantities');
        $total_amount = 0;
        $ordered_products = array();
        foreach ($products as $product_index => $product) {
           $price = Product::findOrFail($product)->price;
           $ordered_products[] = new OrderedProduct([
            'product_id' => $product,
            'quantity' => $quantities[$product_index],
            'unit_price' => $price
           ]);
           $total_amount += $quantities[$product_index]*$price;
        }
        $order->user_id = $user_id;
        $order->total_amount =  $total_amount;
        $order->save();
        $order->orderedProducts()->saveMany( $ordered_products);
        
        return response()->json([
            'success' => true,
            'message' => "You successfully made an order", 
            'order' => $order,
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
