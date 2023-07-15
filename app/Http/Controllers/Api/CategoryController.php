<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mandanism;

class CategoryController extends Controller
{
    public function MandanismList(Request $request)
    {
        $data = Mandanism::select('id','title','group','description','created_at')->where('status','active')->paginate(10);

        foreach ($data as $key => $value) {
            // $data[$key]['description'] = \Illuminate\Support\Str::words(strip_tags($value->description), $limit = 15, $end = '...');
            $data[$key]['description'] = strip_tags($value->description);
        }
        return response([
            'status' => true,
            'message' => 'Mandanism List.',
            'data' => $data
        ],201);
    }

    public function MandanismDetail($id)
    {
        $data = Mandanism::find($id);
        $data['image'] = url('/').'/'.$data->image;
        return response([
            'status' => true,
            'message' => 'Mandanism Detail.',
            'data' => $data
        ],201);
    }    
}
