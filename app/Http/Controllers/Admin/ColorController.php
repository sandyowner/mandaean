<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use DataTables;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['filter'] = $request->filter;
        $adminuser = session()->get('adminuser');
        $data['sort_name'] = $adminuser->name;
        $dataList = Color::orderBy('id','desc');
        $search = $request->search;
        if($search){
            $dataList->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('color', 'LIKE', '%'.$search.'%');
        }
        $dataList = $dataList->get();
        
        if ($request->ajax()) {
            return DataTables::of($dataList)
                ->editColumn('image', function($row){
                    if(count($row->images)>0){
                        return '<img src="'.url('/').'/'.$row->images[0]->image.'">';
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('action', function($row){
                    $editimg = asset('/').'public/assets/images/edit-round-line.png';
                    $btn = '<a href="'.route('product.edit',$row->id).'" title="Edit"><label class="badge badge-gradient-dark">Edit</label></a> ';
                    $delimg = asset('/').'public/assets/images/dlt-icon.png';
                    $btn .= '<a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop3" class="deldata" id="'.$row->id.'" title="Delete" onclick=\'setData('.$row->id.',"'.route('product.destroy',$row->id).'");\'><label class="badge badge-danger">Delete</label></a>';
                    return $btn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        }

        return view('admin.product.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $adminuser = session()->get('adminuser');
        $data['sort_name'] = $adminuser->name;
        $data['brands'] = Brand::where('status','active')->get();
        $data['colors'] = Color::where('status','active')->get();
        $data['sizes'] = Size::where('status','active')->get();
        return view('admin.product.create',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'category' => 'required',
            'price' => 'required',
            'brand' => 'required',
            'color' => 'required',
            'size' => 'required',
            'material' => 'required',
            'condition' => 'required',
            'ar_name' => 'required|max:200',
            'ar_category' => 'required',
            'ar_material' => 'required',
            'ar_condition' => 'required',
            'pe_name' => 'required|max:200',
            'pe_category' => 'required',
            'pe_material' => 'required',
            'pe_condition' => 'required',
            'photo' => 'required',
        ],[
            'ar_name.required' => 'The name field is required.',
            'ar_category.required' => 'The category field is required.',
            'ar_material.required' => 'The material field is required.',
            'ar_condition.required' => 'The condition field is required.',
            'pe_name.required' => 'The name field is required.',
            'pe_category.required' => 'The category field is required.',
            'pe_material.required' => 'The material field is required.',
            'pe_condition.required' => 'The condition field is required.',
        ]);
 
        if ($validator->fails())
        {
            $messages = $validator->messages();
            return back()->withInput()->withErrors($messages);
        }else{
            $product = new Product();
            $product['name'] = $request->name;
            $product['category'] = $request->category;
            $product['sku'] = _getSKU();
            $product['price'] = $request->price;
            $product['color_ids'] = array_map('intval', $request->color);
            $product['size_ids'] = array_map('intval', $request->size);
            $product['brand_id'] = $request->brand;
            $product['material'] = $request->material;
            $product['condition'] = $request->condition;
            $product['ar_name'] = $request->ar_name;
            $product['ar_category'] = $request->ar_category;
            $product['ar_material'] = $request->ar_material;
            $product['ar_condition'] = $request->ar_condition;
            $product['pe_name'] = $request->pe_name;
            $product['pe_category'] = $request->pe_category;
            $product['pe_material'] = $request->pe_material;
            $product['pe_condition'] = $request->pe_condition;
            $product->save();

            foreach ($request->file('photo') as $key => $file) {
                $destinationPath = 'uploads/';
                $file_name = time().''.$file->getClientOriginalName();
                $file->move($destinationPath , $file_name);
                $imageName = $destinationPath.''.$file_name;
                ProductImage::create(['product_id'=>$product->id,'image'=>$imageName]);
            }
            return redirect('product')->with('message', 'Record Added!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $adminuser = session()->get('adminuser');
        $data['sort_name'] = $adminuser->name;
        $data['brands'] = Brand::where('status','active')->get();
        $data['colors'] = Color::where('status','active')->get();
        $data['sizes'] = Size::where('status','active')->get();
        $data['product'] = Product::with('images')->find($id);
        return view('admin.product.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'category' => 'required',
            'price' => 'required',
            'brand' => 'required',
            'color' => 'required',
            'size' => 'required',
            'material' => 'required',
            'condition' => 'required',
            'ar_name' => 'required|max:200',
            'ar_category' => 'required',
            'ar_material' => 'required',
            'ar_condition' => 'required',
            'pe_name' => 'required|max:200',
            'pe_category' => 'required',
            'pe_material' => 'required',
            'pe_condition' => 'required',
            'photo' => 'required',
        ],[
            'ar_name.required' => 'The name field is required.',
            'ar_category.required' => 'The category field is required.',
            'ar_material.required' => 'The material field is required.',
            'ar_condition.required' => 'The condition field is required.',
            'pe_name.required' => 'The name field is required.',
            'pe_category.required' => 'The category field is required.',
            'pe_material.required' => 'The material field is required.',
            'pe_condition.required' => 'The condition field is required.',
        ]);
 
        if ($validator->fails())
        {
            $messages = $validator->messages();
            return back()->withInput()->withErrors($messages);
        }else{
            $product = Product::find($id);
            $product['name'] = $request->name;
            $product['category'] = $request->category;
            $product['price'] = $request->price;
            $product['color_ids'] = array_map('intval', $request->color);
            $product['size_ids'] = array_map('intval', $request->size);
            $product['brand_id'] = $request->brand;
            $product['material'] = $request->material;
            $product['condition'] = $request->condition;
            $product['ar_name'] = $request->ar_name;
            $product['ar_category'] = $request->ar_category;
            $product['ar_material'] = $request->ar_material;
            $product['ar_condition'] = $request->ar_condition;
            $product['pe_name'] = $request->pe_name;
            $product['pe_category'] = $request->pe_category;
            $product['pe_material'] = $request->pe_material;
            $product['pe_condition'] = $request->pe_condition;
            $product->save();

            foreach ($request->file('photo') as $key => $file) {
                $destinationPath = 'uploads/';
                $file_name = time().''.$file->getClientOriginalName();
                $file->move($destinationPath , $file_name);
                $imageName = $destinationPath.''.$file_name;
                ProductImage::create(['product_id'=>$product->id,'image'=>$imageName]);
            }
            return redirect('product')->with('message', 'Record Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('id',$id)->delete();
        ProductImage::where('product_id',$id)->delete();
        
        return true;
    }
}
