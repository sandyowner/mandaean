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
            $user->profile = ($user->profile)?url('/').'/'.$user->profile:NULL;
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
        $user->profile = $user->profile?url('/').'/'.$user->profile:NULL;

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
            User::where('email',$user->email)->delete();
            return response([
                'status'=>true,
                'message'=>'Account Deleted.',
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
}
