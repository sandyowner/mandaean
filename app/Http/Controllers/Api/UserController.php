<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;

class UserController extends Controller
{
    public function profile(Request $request){
        $id = Auth::id();
        $user = User::find($id);

        if($user){
            $user->profile = url('/').'/'.$user->profile;
            return response([
                'status'=>true,
                'message'=>'User profile data.',
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

    public function updateProfile(Request $request){
        $id = Auth::id();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            // 'mobile_no' => 'required|unique:users,mobile_no'.$id,
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status'=>false,
                'message'=>$error,
                'data'=>[]
            ],422);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->country_code = $request->country_code;
        $user->mobile_no = $request->mobile_no;

        if ($request->hasFile('profile'))
        {
            $destinationPath = 'uploads/';
            $file = $request->file('profile');
            $file_name = time().''.$file->getClientOriginalName();
            $file->move($destinationPath, $file_name);
            $user->profile = $destinationPath.''.$file_name;
        }
        $user->save();
        $user->profile = url('/').'/'.$user->profile;

        return response([
            'status'=>true,
            'message'=>'User profile data updated.',
            'data'=>$user
        ],201);
    }

    public function deleteAccount(Request $request){
        $id = Auth::id();
        $user = User::where(['id'=>$id])->first();
        if($user){
            // $otp = rand(1111,9999);
            $otp = '1111';

            User::where('email',$user->email)->update(['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s')]);

            $email = $user->email;
            $name = $user->name;
            $template = 'emails.otp';
            $subject = 'OTP for Account Deletion.';
            $data = [
                'name' => $name,
                'email' => $email,
                'otp' => $otp
            ];
            ___mail_sender($email,$name,$template,$data,$subject);

            return response([
                'status'=>true,
                'message'=>'OTP send',
                'data'=>[]
            ],201);
        }else{
            return response([
                'status'=>false,
                'message'=>'User not found.',
                'data'=>[]
            ],422);
        }
    }

    public function deleteAccountOTP(Request $request){
        $id = Auth::id();
        $validator = Validator::make($request->all(), [
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

        $user = User::where(['id'=>$id])->first();
        if($user){
            $otp = $request->otp;
            if($user->otp==$otp){
                $currentTime = date('Y-m-d H:i:s');
                $timeDiff = getTimeDifference($user->otp_time,$currentTime);
                if($timeDiff<=10){
                    User::where('email',$user->email)->delete();
                    return response([
                        'status'=>true,
                        'message'=>'Account Deleted.',
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
        }else{
            return response([
                'status'=>false,
                'message'=>'User not found.',
                'data'=>[]
            ],422);
        }
    }
}
