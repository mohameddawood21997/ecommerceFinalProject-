<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request){
        // return $request;
        $order = new Order();

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
      
        $totalPrice=0;
         
        foreach ($request->orderProducts as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product['product_id'];
            $orderProduct->price = $product['price'];
            $orderProduct->quantity = $product['quantity'];
            $orderProduct->save();
              
             $products=Product::find($product['product_id']);
             $quan= $products->quantity;
             $products->quantity=$quan-$product['quantity'];
             $products->save();

            
              


        }
        // dd($products);

        // orderproduct['product_id'][]
        // Return the order with its associated products
        // return $product;
        return $order->load('orderProducts');
    }



     public function addAddress(Request $request)
     {  
        $user_id=1;
        $order=Order::where('user_id',$user_id)->latest()->first();

       $order->city=$request->city;
       $order->governate=$request->governate;
       $order->street=$request->street;
       $order->pinCode=$request->pinCode;
       $order->mobile=$request->mobile;
       $order->save();

        return $order;


     }
     public function getOrderDetails(){

        // $orderDetail=Order::where('user_id',1)->with(['OrderProducts'=>function($q){
        //    return $q->select('order_id')->with(['products',function($q2){
        //     return $q2->select('product_id','id');
        //    }]);
        // }])->get()->toArray();

        $orders = Order::with('orderProducts.product')->get()->toArray();
        return $orders;
        // $user_id=auth()->id();
        // // return $user_id;
        // $orderDetail=OrderProduct::where('order_id',1)->get();

        // $orderDetail=Order::with(['orderProducts'=>function($q){
        //     return $q->select('order_id','product_id','quantity','price');
        // }])->where('user_id',1)->get();
        // return response()->json($orderDetail);
     }
    

}






