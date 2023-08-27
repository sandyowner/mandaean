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
            'venue' => 'required',
            'name' => 'required',
            'email' => 'required',
            'date' => 'required',
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
            'venue' => $request->venue,
            'name' => $request->name,
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
