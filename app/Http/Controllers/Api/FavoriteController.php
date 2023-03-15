<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\UserCard;
use App\Models\Favorite;
use Exception;

class FavoriteController extends Controller
{
    public function addToFavorite(Request $request)
    {
        $request->validate([
            'product_id' => 'required|max:255',
        ]);
        try {
        $favorite=new Favorite();
        $favorite->user_id=Auth::user()->id;
        $favorite->product_id=$request->product_id;
        $favorite->save();

        return response()->json($favorite);
        } catch (\Exception $e) {
        //   throw new Exception("Error Processing Request");
        return $e->getMessage();
        // return 'prpduct noT available';

        }

    }

    public function showFavorite(){

        $userId=Auth::user()->id;
        $favoites = Product::select('products.name','products.price','products.discount','products.description','products.image')
         ->join('favorites', 'favorites.product_id', '=', 'products.id')
         ->join('users', 'users.id', '=', 'favorites.user_id')
         ->where('users.id', $userId)
         ->get();
     // $category=Category::where("name",$catName)->get();
    return  $favoites;

 }
}
