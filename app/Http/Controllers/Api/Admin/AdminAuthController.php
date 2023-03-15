<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Auth\TokenGuard;
use App\Models\Admin;
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
}
