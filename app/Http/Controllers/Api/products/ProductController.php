<?php

namespace App\Http\Controllers\Api\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
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
        $product->price=$request->price;
        $product->quantity=$request->quantity;
        $product->description=$request->description;
        $product->discount=$request->discount;
        $product->status=$request->status;
        $product->category_id=$request->category_id;
        $product->save();


        if ($request->hasFile('image')) {
        
        //    $images= $request->hasFile('image')
                    $url = "http://127.0.0.1:8000/productImages/";
                   
                    
                    foreach ($request->file('image') as $image) {
                 
                        if (!$image->isValid()) {
                            // The image is not valid, handle the error appropriately
                            continue;
                        }
                        
                        $imageName = $image->getClientOriginalName();
                        $image->move(public_path('productImages'), $imageName);
                        $fullPath = $url . $imageName;
                        $newImage = new Image();
                        $newImage->product_id = $product->id;
                        $newImage->imgPath = $fullPath;
                        $newImage->name = $imageName;
                        $newImage->save();
                    }
                 
           
                
                return response()->json([$product,'success' => true]);
          
            //  $images=   $product->images()->create([
            //         'imgPath' => $fullPath,
            //         'name' => $imageName,
            //     ]);
            }
    
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

        $category = Category::where('name', $catName)->first();

        $products = Product::whereHas('category', function($query) use ($category) {
            $query->where('id', $category->id);
        })->get();


         $products= ProductResource::collection($products);
        return $products;


         // $category = Product::select('products.*')
        //     ->join('categories', 'categories.id', '=', 'products.category_id')
        //     ->where('categories.name', $catName)
        //     ->get();
        //  $category=Category::where("name",$catName)->get();
        // $category = Product::select('products.*')->whereHas('categories', function($query) use ($catName){
        //     $query->where('categories.name', $catName);
        // })->get();
        //
        // $category= ProductResource::collection($category);
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
        $images=Product::find($id)->images;
        foreach($images as $image){
            unlink(public_path("productImages/$image->name"));
        }
        $product->delete();
        return 'deleted successfuly';
    }
}





// public function store(Request $request)
// {
//     // Validate the incoming request data
//     $validatedData = $request->validate([
//         'name' => 'required|string|max:255',
//         'description' => 'required|string',
//         'price' => 'required|numeric|min:0',
//         'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Allows multiple image uploads with the specified file types and size
//     ]);

//     // Create a new product with the validated data
//     $product = Product::create([
//         'name' => $validatedData['name'],
//         'description' => $validatedData['description'],
//         'price' => $validatedData['price'],
//     ]);

//     // Save the uploaded images and associate them with the new product
//     if ($request->hasFile('images')) {
//         $images = $request->file('images');

//         foreach ($images as $image) {
//             $imagePath = $image->store('public/images'); // Store the image file in the specified directory within the storage folder
//             $imageName = $image->getClientOriginalName(); // Get the original name of the image file
//             $imageCaption = $imageName; // You can customize the image caption as needed
//             $imageAltText = $imageName; // You can customize the image alt text as needed

//             $product->images()->create([
//                 'url' => $imagePath,
//                 'caption' => $imageCaption,
//                 'alt_text' => $imageAltText,
//             ]);
//         }
//     }

//     // Return the newly created product and associated images as a JSON response
//     return response()->json([
//         'message' => 'Product created successfully.',
//         'product' => $product->load('images'), // Load the associated images with the product
//     ], 201);
// }
