<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function ProductList(Request $request){
        $data = Product::with(['images','colors','sizes', 'brands'])->where('status','active')->paginate(15);
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
}
