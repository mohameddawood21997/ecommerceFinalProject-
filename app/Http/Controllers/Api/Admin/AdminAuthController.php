<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Auth\TokenGuard;
use App\Models\Admin;
use App\Http\Resources\UserResourse;
use App\Models\User;



class AdminAuthController extends Controller
{
    public function adminLogin(Request $request){


        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        // if(Auth::guard('admin-api')->attempt($credentials)){
            $admin = Admin::where('email', $request->email)->first();
            // $admin=Auth::guard('admin-api')->user();

           $adminToken= $admin->createToken('token-name', ['server:update'])->plainTextToken;
            // $token = $user->createToken($request->token_name);
            return response()->json([$admin,$adminToken]);
        // }
        
        return 'un authorized';
    }
//     public function adminLogin(Request $request)
// {
//     $credentials = $request->validate([
//         'email' => ['required', 'email'],
//         'password' => ['required'],
//     ]);
    
//     if (Auth::guard('admin-api')->once($credentials)) {
//         $admin = Auth::guard('admin-api')->user();
//         return response()->json([$admin]);
//     }
    
//     return 'unauthorized';
// }



public function showUser($id){
    // $id=Auth::user()->id;
    try {
        $user= new UserResourse(User::findOrFail(1));
        return response()->json($user);
       }
     catch (\Exception $ex) {
        return 'user dose not exist';
    }
 }



 public function adminLogout(Request $request){
    try {
      Auth::user('admin-api')->currentAccessToken()->delete();
  
      return response()->json('logout successfuly');
    } catch (\Throwable $th) {
      return response()->json('some this is wrong');
    }
     
  }
    
}
