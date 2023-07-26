<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mandanism;
use App\Models\LatestNews;
use App\Models\HolyBook;
use App\Models\Ritual;
use App\Models\Prayer;

class CategoryController extends Controller
{
    public function MandanismList(Request $request)
    {
        $data = Mandanism::select('id','title','group','description','created_at')->where('status','active')->get();

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
        $data = LatestNews::select('id','title','group','description','created_at')->where('status','active')->get();

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
        $data = HolyBook::select('id','title','description','image','url')->where('status','active')->get();

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

    public function RitualsList(Request $request)
    {
        $data = Ritual::select('id','title')->where('status','active')->get();

        return response([
            'status' => true,
            'message' => 'Rituals List.',
            'data' => $data
        ],201);
    }

    public function RitualsDetail($id)
    {
        $data = Ritual::find($id);
        return response([
            'status' => true,
            'message' => 'Rituals Detail.',
            'data' => $data
        ],201);
    } 

    public function PrayerList(Request $request)
    {
        $data = Prayer::select('id','title','subtitle')->where('status','active')->get();

        return response([
            'status' => true,
            'message' => 'Prayer List.',
            'data' => $data
        ],201);
    }

    public function PrayerDetail($id)
    {
        $data = Prayer::find($id);
        return response([
            'status' => true,
            'message' => 'Prayer Detail.',
            'data' => $data
        ],201);
    } 

}
