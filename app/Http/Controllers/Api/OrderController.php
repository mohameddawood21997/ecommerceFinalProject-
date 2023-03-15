<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request){
        $order = new Order();

    // if (Auth::check()) {
    //     $order->user_id = auth()->user()->id;
    // } else {
    //     return 'no logged in';
    // }

    //   return optional(Auth::user())->id;
        $order->name = Auth::user()->name ;
        $order->total_price = $request->total_price;
        $order->user_id =Auth::user()->id ;
        $order->save();

        // latest
        // return Order::all()->latest();

        // return $request->input('orderProducts');
        // $orderProducts = [
        //     ['product_id' => 1, 'price' => 100, 'quantity' => 2],
        //     ['product_id' => 2, 'price' => 110, 'quantity' => 1],
        // ];

        foreach ($request->orderProducts as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product['product_id'];
            $orderProduct->price = $product['price'];
            $orderProduct->quantity = $product['quantity'];
            $orderProduct->save();
        }

        // Return the order with its associated products
        return $order->load('orderProducts');
    }


}

