<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;
use Auth;
use DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status'=>false,
                'message'=>$error,
                'data'=>[]
            ],422);
        }
    
        if(Auth()->attempt(array('email' => $request->email, 'password' => $request->password))){
            $user = User::where('email',$request->email)->first();
            if($user->email_verified_at){
                $token = $user->createToken('usertoken')->plainTextToken;

                return response([
                    'status'=>true,
                    'message'=>'Signed in',
                    'data'=>$user,
                    'token'=>$token
                ],422);
            }else{
                $userId = Auth::id();
                $status = DB::table('oauth_access_tokens')->where('user_id', $userId)->update([
                    'revoked' => 1,
                    'expires_at' => date('Y-m-d H:i:s'),
                ]);
                return response([
                    'status'=>false,
                    'message'=>'Your email does not verified.',
                    'data'=>[]
                ],422);
            }
        }

        return response([
            'status'=>false,
            'message'=>'Login details are not valid',
            'data'=>[]
        ],422);
    }

    public function singup(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status'=>false,
                'message'=>$error,
                'data'=>[]
            ],422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('usertoken')->plainTextToken;

        return response([
            'status'=>true,
            'message'=>'Signed up',
            'data'=>$user,
            'token'=>$token
        ],422);

    }
}
