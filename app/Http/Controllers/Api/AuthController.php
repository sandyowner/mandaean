<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status'=>false,
                'message'=>$error,
                'data'=>[]
            ],422);
        }
    
        // if(Auth()->attempt(array('email' => $request->email, 'password' => $request->password))){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            // $user = Auth::user(); 
            $user = User::where('email',$request->email)->first();
            if($user->email_verified_at){
                // $token = $user->createToken('usertoken')->plainTextToken;
                $token = $user->createToken('usertoken')->plainTextToken;

                return response([
                    'status'=>true,
                    'message'=>'Signed in',
                    'data'=>$user,
                    'token'=>$token
                ],201);
            }else{
                // $userId = Auth::id();
                // $status = DB::table('personal_access_tokens')->where('user_id', $userId)->update([
                //     'revoked' => 1,
                //     'expires_at' => date('Y-m-d H:i:s'),
                // ]);
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
            'password' => Hash::make($request->password),
            'country_code' => $request->country_code,
            'mobile_no' => $request->mobile_no,
            'profile' => 'assets/images/user.png'
        ]);

        $token = Str::random(30);
        User::where(['email'=> $request->email])->update([
            'remember_token' => $token
        ]);

        $email = $request->email;
        $name = $request->name;
        $template = 'emails.signup';
        $subject = 'Account is created on Mandaean';
        $data = [
            'name'=>$name,
            'email'=> $email,
            'link'=> url('verify').'/'. $token.'?email=' .urlencode($email)
        ];
        ___mail_sender($email,$name,$template,$data,$subject);

        return response([
            'status'=>true,
            'message'=>'Signed up',
            'data'=>$user
        ],201);

    }

    public function getOTP(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status'=>false,
                'message'=>$error,
                'data'=>[]
            ],422);
        }

        $user = User::where(['email'=>$request->email])->first();
        // $otp = rand(1111,9999);
        $otp = '1111';

        User::where('email',$request->email)->update(['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s')]);
        return response([
            'status'=>true,
            'message'=>'OTP send',
            'data'=>[]
        ],201);
    }

    public function verifyOTP(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status'=>false,
                'message'=>$error,
                'data'=>[]
            ],422);
        }

        $user = User::where(['email'=>$request->email])->first();
        $otp = $request->otp;
        if($user->otp==$otp){
            $currentTime = date('Y-m-d H:i:s');
            $timeDiff = getTimeDifference($user->otp_time,$currentTime);
            if($timeDiff<=10){
                User::where('email',$request->email)->update(['otp'=>null,'otp_time'=>null]);
                return response([
                    'status'=>true,
                    'message'=>'OTP verified.',
                    'data'=>[]
                ],422);
            }else{
                return response([
                    'status'=>false,
                    'message'=>'OTP expired. Please try again.',
                    'data'=>[]
                ],422);
            }
        }else{
            return response([
                'status'=>false,
                'message'=>'Wrong OTP enter.',
                'data'=>[]
            ],422);
        }
    }

    public function forgot(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status'=>false,
                'message'=>$error,
                'data'=>[]
            ],422);
        }

        $user = User::where(['email'=>$request->email])->first();
        if($user){
            // $otp = rand(1111,9999);
            $otp = '1111';

            User::where('email',$request->email)->update(['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s')]);

            $email = $request->email;
            $name = $request->name;
            $template = 'emails.otp';
            $subject = 'OTP for Account Verification.';
            $data = [
                'name' => $name,
                'email' => $email,
                'otp' => $otp
            ];
            ___mail_sender($email,$name,$template,$data,$subject);

            return response([
                'status'=>true,
                'message'=>'OTP send',
                'data'=>$user
            ],201);
        }else{
            return response([
                'status'=>false,
                'message'=>'User not found.',
                'data'=>[]
            ],422);
        }
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status'=>false,
                'message'=>$error,
                'data'=>[]
            ],422);
        }

        $user = User::where(['email'=>$request->email])->first();
        if($user){
            User::where('email',$request->email)->update(['password' => Hash::make($request->password)]);
            return response([
                'status'=>true,
                'message'=>'Password updated.',
                'data'=>[]
            ],201);
        }else{
            return response([
                'status'=>false,
                'message'=>'User does not found.',
                'data'=>[]
            ],422);
        }
    }

    public function verify(Request $request, $token){
        $user = User::where('remember_token', $token)->where('email',$request->email)->first();
        if($user)
        {
            if($user->email_verified_at){
                return '<h1>Your account has been already verified.</h1>';
            }else{
                User::where('id',$user->id)->update(['email_verified_at' => date('Y-m-d H:i:s'), 'remember_token' => NULL]);
                return '<h1>Your account has been verified.</h1>';
            }
        }
        else
        {
            return '<h1>Token is expired or Link not Found</h1>';
        }
    }
}
