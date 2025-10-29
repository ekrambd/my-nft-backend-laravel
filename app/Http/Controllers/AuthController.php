<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        try
        {  

            $validator = Validator::make($request->all(), [
                'wallet_address' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Please fill all requirement fields', 
                    'data' => $validator->errors()
                ], 422);  
            }

            $user = User::where('wallet_address',$request->wallet_address)->first();

            if($user)
            {
            	Auth::login($user);
            	$user = user();
            	$token = $user->createToken('MyApp')->plainTextToken;
            	return response()->json(['status'=>true, 'message'=>'Successfully Logged IN', 'token'=>$token, 'user'=>$user],200);
            }

            return response()->json(['status'=>false, 'message'=>'Invalid Wallet Address', 'token'=>"", 'user'=> new \stdClass()],401);

        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function adminLogout(Request $request)
    {
        try
        {
            auth()->user()->tokens()->delete();
            return response()->json(['status'=>true, 'message'=>'Successfully Logged Out']);
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
