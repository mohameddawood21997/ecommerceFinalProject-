<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;
use App\Http\Requests\user\StoreRequest;
use App\Http\Requests\user\UpdateRequest;
use App\Models\Image;

class AuthController extends Controller
{

    public function register(StoreRequest $request){
      

        $file = $request->file('image');
        $url="http://127.0.0.1:8000/users/";
        //   $extension =  $file->getClientOriginalExtension();
          $imageName =  $file->getClientOriginalName();
      
        $file->move(public_path('users'), $imageName);
        $img_path=$url.$imageName;
       

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        // $user->image=$fullPathName;
         $user->image=$img_path;
        $user->gender=$request->gender;
        $user->save();
        return $user;
    }
    





    public function login(Request $request){


        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if(Auth::attempt($credentials)){
            $user=Auth::user();
           $token= $user->createToken('token-name', ['server:update'])->plainTextToken;
            // $token = $user->createToken($request->token_name);
            return response()->json([$user,$token]);
        }
        else{
            return 'un authorized';
        }


    }


    public function delete($id){

        $user=User::findOrFail($id);
        $user->delete();
        return $user;
    }

      public function show(){

        $user=User::findOrFail(25);
        return $user;
    }


    public function upload(Request $request){
        // $name="mohamed";
        $image_path = $request->file('file')->store("images/users", 'public');

        // $image_path = $request->image->move(public_path('images'), $image_name);

        // $extension = $request->file->getClientOriginalExtension();

        // $image_name = str_replace(' ', '', trim($request->model) . time() . "." . $extension);
        // $image_name = str_replace(' ', '', trim($request->file) . "." . $extension);

        // $image_name = $request->file->getClientOriginalName();



    //     $data = Image::create([
    //         'name' => $image_name,
    //         'product_id'=>1
    //    ]);
        return $image_path;


        // $file = $request->file('image');
        // $filename = time() . '.' . $file->getClientOriginalExtension();
        // $file->move(public_path('uploads'), $filename);
        // return response()->json(['success' => true]);


        // $fileName = $request->file('file')->getClientOriginalName();
        // $extension = $request->file('file')->extension();
        // $mime = $request->file('file')->getMimeType();
        // $clientSize = $request->file('file')->getSize();




           // $url="http://127.0.0.1:8000/storage/";
            // $path=$request->file('image')->storeAs('userImages',$ProductName);
        //   Storage::disk('public')->put($image_path.'/' .$imageName, base64_decode($image));
         // $uploadedFileUrl = cloudinary()->upload($request->file('image')->getRealPath(),['folder'=>'users'])->getSecurePath();
        // $fullPathName='uploads/users/'.$filename;

        // $filename = time() . '.' . $file->getClientOriginalExtension();
       
    }
}
