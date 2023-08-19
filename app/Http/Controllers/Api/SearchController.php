<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Mandanism;
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
        $searchArray = [];
        $search = $request->search;
        $product = Product::where('status','active')
            ->where('name', 'LIKE', '%'.$search.'%')
            ->get();

        foreach ($product as $key => $value) {
            $searchArray['id'] = $value->id;
            $searchArray['name'] = $value->name;
            $searchArray['section'] = 'product';
        }

        $mandanism = Mandanism::where('title', 'LIKE', '%'.$search.'%')
                // ->orWhere('group', 'LIKE', '%'.$search.'%')
                // ->orWhere('description', 'LIKE', '%'.$search.'%')
                ->get();

        foreach ($mandanism as $key1 => $value1) {
            $searchArray['id'] = $value1->id;
            $searchArray['name'] = $value1->title;
            $searchArray['section'] = 'mandanism category';
        }

        if(count($searchArray)>0){
            return response([
                'status'=>true,
                'message'=>'Data fetched.',
                'data'=>$searchArray
            ],201);
        }else{
            return response([
                'status' => false,
                'message' => 'No search found.',
                'data' => []
            ],422);
        }
    }
}
