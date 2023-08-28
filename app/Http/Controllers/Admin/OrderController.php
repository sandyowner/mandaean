<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Validator;
use Hash;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['filter'] = $request->filter;
        $adminuser = session()->get('adminuser');
        $data['sort_name'] = $adminuser->name;
        $dataList = Order::with(['detail'=>function($q){
                $q->with('product','color','size');
            }])
            ->with('address')
            ->with('user')
            ->orderBy('id','desc');
        
        $search = $request->search;
        if($search){
            $dataList->where('order_number', 'LIKE', '%'.$search.'%')
                ->orWhere('status', 'LIKE', '%'.$search.'%');
        }
        $dataList = $dataList->get();
        
        if ($request->ajax()) {
            return DataTables::of($dataList)
                ->addColumn('user', function($row){
                    return $row->user->name;
                })
                ->addColumn('action', function($row){
                    $editimg = asset('/').'public/assets/images/edit-round-line.png';
                    $btn = '<a href="'.route('orders.show',$row->id).'" title="View"><label class="badge badge-gradient-dark">View</label></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.order.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $adminuser = session()->get('adminuser');
        $data['sort_name'] = $adminuser->name;
        $data['order'] =  Order::with(['detail'=>function($q){
                $q->with('product','colorname','sizecode');
            }])
            ->with('transaction')
            ->with('address')
            ->with('user')
            ->orderBy('id','desc')
            ->where('id',$id)
            ->first();

        return view('admin.order.view',['data'=>$data]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
