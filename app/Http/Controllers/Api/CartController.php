<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Address;
use App\Models\Product;
use Auth;
use Validator;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'qty' => 'required',
            'color' => 'required',
            'size' => 'required'
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
        $cart = Cart::where(['user_id'=>$id, 'status'=>'active'])->first();
        if(!$cart){
            $address = Address::where(['user_id'=>$id,'is_primary'=>'yes'])->first();
            $cart = Cart::create([
                'user_id' => $id,
                'address_id' => $address?$address->id:null
            ]);

            $cartDetail = CartDetail::where(['cart_id'=>$cart->id, 'product_id'=>$request->product_id, 'size'=>$request->size, 'color'=>$request->color])->first();
            if($cartDetail){
                CartDetail::where('id',$cartDetail->id)->update(['qty'=>$request->qty]);
            }else{
                $product = Product::find($request->product_id);
                CartDetail::create(['cart_id'=>$cart->id, 'product_id'=>$request->product_id, 'price'=>$product->price, 'size'=>$request->size, 'color'=>$request->color, 'qty'=>$request->qty]);
            }
        }else{
            $cartDetail = CartDetail::where(['cart_id'=>$cart->id, 'product_id'=>$request->product_id, 'size'=>$request->size, 'color'=>$request->color])->first();
            if($cartDetail){
                CartDetail::where('id',$cartDetail->id)->update(['qty'=>$request->qty]);
            }else{
                $product = Product::find($request->product_id);
                CartDetail::create(['cart_id'=>$cart->id, 'product_id'=>$request->product_id, 'price'=>$product->price, 'size'=>$request->size, 'color'=>$request->color, 'qty'=>$request->qty]);
            }
        }

        return response([
            'status'=>true,
            'message'=>'Item added.',
            'data'=>$cart
        ],201);
    }
}
