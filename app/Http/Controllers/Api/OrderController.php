<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use Auth;
use Validator;

class OrderController extends Controller
{
    public function orderHistory(Request $request){
        $id = Auth::id();
        $orders = Order::with('address')
            ->with(['detail' => function ($query) {
                $query->with(['product' => function ($q) {
                    $q->with('images');
                }])->with(['color','size']);
            }])
            ->withCount('detail as items')
            ->where('user_id',$id)
            ->get();

        if(count($orders)>0){
            return response([
                'status'=>true,
                'message'=>'Order Data.',
                'data'=>$orders
            ],201);
        }else{
            return response([
                'status'=>false,
                'message'=>'No Orders.',
                'data'=>[]
            ],422);
        }
    }

    public function orderDetail(Request $request, $id){
        $id = Auth::id();
        $orders = Order::with('address')
            ->with(['detail' => function ($query) {
                $query->with(['product' => function ($q) {
                    $q->with('images');
                }])->with(['color','size']);
            }])
            ->withCount('detail as items')
            ->where('id',$id)
            ->get();

        if(count($orders)>0){
            return response([
                'status'=>true,
                'message'=>'Order Data.',
                'data'=>$orders
            ],201);
        }else{
            return response([
                'status'=>false,
                'message'=>'No Orders.',
                'data'=>[]
            ],422);
        }
    }
}
