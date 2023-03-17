<?php

namespace App\Http\Controllers\Api\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products=Product::get()->all();
        $products= ProductResource::collection(Product::all());
        // $cat=Category::all();
        //  $comment->post->title;
        return $products;
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
    public function store(Request $request)
    {
        $product=new Product();
        $product->name=$request->name;
        $product->rate=$request->rate;
        $product->image=$request->image;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->description=$request->description;
        $product->discount=$request->discount;
        $product->status=$request->status;
        $product->category_id=$request->category_id;
        $product->save();

        return $product;





    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $product=Product::find($id);
        $product= new ProductResource(Product::findOrFail($id));

        return $product;
    }
    public function searchByProductName($name)
    {
        // $product=Product::where("name",$name)->get();
        $product= ProductResource::collection(Product::where("name",$name)->get());
        //
        return $product;
    }

    public function searchByCatagoryName($catName)
    {

        // $category = Product::select('products.*')
        //     ->join('categories', 'categories.id', '=', 'products.category_id')
        //     ->where('categories.name', $catName)
        //     ->get();
        // // $category=Category::where("name",$catName)->get();



        // $category = Product::select('products.*')->whereHas('categories', function($query) use ($catName){
        //     $query->where('categories.name', $catName);
        // })->get();
        //
        // $category= ProductResource::collection($category);


        $category = Category::where('name', $catName)->first();

        $products = Product::whereHas('category', function($query) use ($category) {
            $query->where('id', $category->id);
        })->get();


         $products= ProductResource::collection($products);
        return $products;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $product= Product::find($id);
        $product->name=$request->name;
        $product->rate=$request->rate;
        $product->image=$request->image;
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->description=$request->description;
        $product->discount=$request->discount;
        $product->status=$request->status;
        $product->category_id=$request->category_id;
        $product->save();

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        $product->delete();
        return $product;
    }
}
