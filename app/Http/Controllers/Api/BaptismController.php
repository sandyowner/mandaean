<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Baptism;
use Validator;
use Auth;

class BaptismController extends Controller
{
    public function BookBaptism(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'date' => 'required',
            'email' => 'required',
            'code' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status' => false,
                'message' => $error,
                'data' => []
            ],422);
        }

        $id = Auth::id();

        $data = Baptism::create([
            'user_id' => $id,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'date' => $request->date,
            'email' => $request->email,
            'code' => $request->code,
            'phone' => $request->phone
        ]);

        return response([
            'status' => true,
            'message' => 'Success.',
            'data' => $data
        ],201);
    }
}
