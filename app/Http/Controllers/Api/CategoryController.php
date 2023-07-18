<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mandanism;
use App\Models\LatestNews;
use App\Models\HolyBook;

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

    public function LatestNewsList(Request $request)
    {
        $data = LatestNews::select('id','title','group','description','created_at')->where('status','active')->paginate(10);

        foreach ($data as $key => $value) {
            // $data[$key]['description'] = \Illuminate\Support\Str::words(strip_tags($value->description), $limit = 15, $end = '...');
            $data[$key]['description'] = strip_tags($value->description);
        }
        return response([
            'status' => true,
            'message' => 'Latest News List.',
            'data' => $data
        ],201);
    }

    public function LatestNewsDetail($id)
    {
        $data = LatestNews::find($id);
        $data['image'] = url('/').'/'.$data->image;
        return response([
            'status' => true,
            'message' => 'Latest News Detail.',
            'data' => $data
        ],201);
    } 

    public function HolyBookList(Request $request)
    {
        $data = HolyBook::select('id','title','description','image','url')->where('status','active')->paginate(10);

        foreach ($data as $key => $value) {
            $data[$key]['image'] = url('/').'/'.$value->image;
            $data[$key]['url'] = url('/').'/'.$value->url;
            $data[$key]['bookmark'] = 'no';
        }
        return response([
            'status' => true,
            'message' => 'Holy Book List.',
            'data' => $data
        ],201);
    }

}
