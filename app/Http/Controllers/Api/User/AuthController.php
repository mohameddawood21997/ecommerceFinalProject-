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
use App\Http\Resources\UserResourse;
use Laravel\Sanctum\TransientToken;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{

    public function register(StoreRequest $request){
      
        $file = $request->file('image');
        $url="http://127.0.0.1:8000/users/$request->name/";
        //   $extension =  $file->getClientOriginalExtension();
        $imageName =  $file->getClientOriginalName();
        $img_path=$url.$imageName;
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
         $user->image=$img_path;
         $user->imgName=$imageName;
        $user->gender=$request->gender;
        $user->save();
        $file->move(public_path("users/$request->name"), $imageName);
        return response()->json($user);
    }
   

    public function updateUser(UpdateRequest $request){
        $id=Auth::user()->id;
        // return $id;
       $user = User::find($id);
       
        $file = $request->file('image');
        $url="http://127.0.0.1:8000/users/$request->name/";
        //   $extension =  $file->getClientOriginalExtension();
          $imageName =  $file->getClientOriginalName();
         unlink(public_path("users/$user->name/$user->imgName"));
         rmdir(public_path("users/$user->name"));
        $file->move(public_path("users/$request->name"), $imageName);
        $img_path=$url.$imageName;
       
        $user->name=$request->name;
        $user->email=$request->email;
         $user->image=$img_path;
         $user->imgName=$imageName;
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
           $token= $user->createToken('token-name', ['expires_in' => 60])->plainTextToken;
            // $token = $user->createToken($request->token_name);
            return response()->json([$user,$token]);
        }
        else{
            return 'un authorized';
        }


    }


    public function delete($id){

        try {
       $user=User::findOrFail($id);
        $imageName =  $user->imgName;
        unlink(public_path("users/$user->name/$user->imgName"));
        rmdir(public_path("users/$user->name"));
        $user->delete();

        return $user;
        } catch (\Throwable $th) {
           return 'some thing error';
        }
       
    }

      public function show(){
       
        // $id=Auth::user()->id;
        $user= new UserResourse(User::findOrFail(26));
        return response()->json($user);
    }

  




public function userLogout(Request $request){
  try {
    Auth::user()->currentAccessToken()->delete();

    return response()->json('logout successfuly');
  } catch (\Throwable $th) {
    return response()->json('some this is error');
  }
   
}

}





