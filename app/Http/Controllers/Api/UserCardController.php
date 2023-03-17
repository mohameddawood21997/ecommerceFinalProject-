<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCard;
use App\Models\Product;
use Exception;


class UserCardController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|max:255',
        ]);
        try {
        $userCard=new UserCard();
        $userCard->user_id=Auth::user()->id;
        $userCard->product_id=$request->product_id;
        $userCard->save();

        return response()->json($userCard);
        } catch (\Exception $e) {
        //   throw new Exception("Error Processing Request");
        // return $e->getMessage();
        return 'prpduct noT available';

        }

    }

    public function deleteFromCart($product_id){
        $product=UserCard::where('product_id',$product_id)->first();
        $product->delete();
        return 'deleted successfuly';

    }

    public function showUserCard(){

           $userId=Auth::user()->id;
           $cards = Product::select('products.name','products.price','products.discount','products.description','products.image','products.id')
            ->join('user_cards', 'user_cards.product_id', '=', 'products.id')
            ->join('users', 'users.id', '=', 'user_cards.user_id')
            ->where('users.id', $userId)
            ->get();
        // $category=Category::where("name",$catName)->get();
       return  $cards;

    }

}
