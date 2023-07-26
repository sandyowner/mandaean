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
                CartDetail::where('id',$cartDetail->id)->update(['qty'=>1]);
            }else{
                $product = Product::find($request->product_id);
                CartDetail::create(['cart_id'=>$cart->id, 'product_id'=>$request->product_id, 'price'=>$product->price, 'size'=>$request->size, 'color'=>$request->color, 'qty'=>1]);
            }
        }else{
            $cartDetail = CartDetail::where(['cart_id'=>$cart->id, 'product_id'=>$request->product_id, 'size'=>$request->size, 'color'=>$request->color])->first();
            if($cartDetail){
                CartDetail::where('id',$cartDetail->id)->update(['qty'=>1]);
            }else{
                $product = Product::find($request->product_id);
                CartDetail::create(['cart_id'=>$cart->id, 'product_id'=>$request->product_id, 'price'=>$product->price, 'size'=>$request->size, 'color'=>$request->color, 'qty'=>1]);
            }
        }

        return response([
            'status'=>true,
            'message'=>'Item added.',
            'data'=>$cart
        ],201);
    }

    public function getCart(Request $request){
        $id = Auth::id();
        $cart = Cart::with('address')
            ->with(['detail' => function ($query) {
                $query->with(['product' => function ($q) {
                    $q->with('images');
                }])->with(['color','size']);
            }])
            ->withCount('detail as items')
            ->where(['user_id'=>$id, 'status'=>'active'])
            ->first();

        if($cart){
            foreach ($cart->detail as $key => $value) {
                foreach ($value->product->images as $k => $val) {
                    $val->image = url('/').'/'.$val->image;
                }
            }
            return response([
                'status'=>true,
                'message'=>'Cart Data.',
                'data'=>$cart
            ],201);
        }else{
            return response([
                'status'=>false,
                'message'=>'Cart Empty.',
                'data'=>[]
            ],201);
        }
    }
    
    public function updateItem(Request $request){
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'type' => 'required'
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
        $cartDetail = CartDetail::find($request->item_id);
        if($request->type=='add'){
            $qty = $cartDetail->qty+1;
            CartDetail::where('id',$request->item_id)->update(['qty'=>$qty]);
        }else{
            if($cartDetail->qty==1){
                CartDetail::where('id',$request->item_id)->delete();
            }else{
                $qty = $cartDetail->qty-1;
                CartDetail::where('id',$request->item_id)->update(['qty'=>$qty]);
            }
        }

        $detail = CartDetail::find($request->item_id);

        return response([
            'status'=>true,
            'message'=>'Item updated.',
            'data'=>$detail
        ],201);

    }

    public function deleteItem(Request $request){
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
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
        CartDetail::where('id',$request->item_id)->delete();
        
        return response([
            'status'=>true,
            'message'=>'Item deleted.',
            'data'=>[]
        ],201);
    }

    public function userAddress(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile_no' => 'required',
            'first_address' => 'required',
            'second_address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
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
        Address::where('user_id',$id)->update(['is_primary'=>'no']);
        $address = Address::updateOrCreate([
            'user_id'=>$id,
            'mobile_no'=>$request->mobile_no,
            'first_address'=>$request->first_address,
            'second_address'=>$request->second_address,
            'state'=>$request->state,
            'city'=>$request->city,
            'postal_code'=>$request->postal_code
        ],[
            'name' => $request->name,
            'is_primary' => 'yes'
        ]);
        
        Cart::where(['user_id'=>$id,'status'=>'active'])->update(['address_id'=>$address->id]);
        
        return response([
            'status'=>true,
            'message'=>'Address added.',
            'data'=>$address
        ],201);
    }
}
