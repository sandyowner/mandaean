<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function ProductList(Request $request){
        $data = Product::with(['images','colors','sizes', 'brands'])->where('status','active')->get();
        foreach ($data as $key => $value) {
            foreach ($value->images as $k => $val) {
                $val->image = url('/').'/'.$val->image;
            }
        }
        return response([
            'status' => true,
            'message' => 'Product List.',
            'data' => $data
        ],201);   
    }

    public function ProductDetail(Request $request, $id){
        $data = Product::with(['images','colors','sizes', 'brands'])->where('status','active')->find($id);
        foreach ($data->images as $k => $val) {
            $val->image = url('/').'/'.$val->image;
        }
        return response([
            'status' => true,
            'message' => 'Product Detail.',
            'data' => $data
        ],201);   
    }
}
