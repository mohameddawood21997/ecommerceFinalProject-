<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCard;
use App\Models\Product;
use Exception;
use App\Models\Image;
use Illuminate\Support\Facades;


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

        $user_id = auth()->id();
        // Retrieve all cards associated with the logged-in user
        $cards = UserCard::where('user_id', $user_id)->get();
    
        // Retrieve the products and images for each card
        foreach ($cards as $card) {
            $product = $card->product;
            $imagePaths = $product->images()->select('imgPath')->get()->pluck('imgPath')->toArray();    
            // Add the product and image data to the array

            $product->imagePaths = $imagePaths;
            $data[] = 
                // 'product' => $product,
                  $product
                // 'images' => $imagePaths,
            ;
        }
    
        // Return the data as a JSON response
        return response()->json($data);

     


    }


    

}
