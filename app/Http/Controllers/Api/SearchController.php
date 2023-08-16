<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class SearchController extends Controller
{
    public function Search(Request $request){
        $validator = Validator::make($request->all(), [
            'search' => 'required'
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

        return response([
            'status'=>true,
            'message'=>'Data fetched.',
            'data'=>[]
        ],201);
    }
}
