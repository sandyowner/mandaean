<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mandanism;
use App\Models\LatestNews;
use App\Models\HolyBook;
use App\Models\Bookmark;
use App\Models\Ritual;
use App\Models\Prayer;
use App\Models\Program;
use App\Http\Resources\MandanismResource;
use App\Http\Resources\MandanismDetailResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\NewsDetailResource;
use App\Http\Resources\RitualResource;
use App\Http\Resources\RitualDetailResource;
use App\Http\Resources\PrayerResource;
use App\Http\Resources\PrayerDetailResource;
use App\Http\Resources\HolyBookResource;
use App\Http\Resources\ProgramResource;
use App\Http\Resources\ProgramDetailResource;
use Auth;
use Validator;

class CategoryController extends Controller
{
    public function MandanismList(Request $request)
    {
        $data = Mandanism::where('status','active')->get();

        return response([
            'status' => true,
            'message' => 'Mandanism List.',
            'data' => MandanismResource::collection($data)
        ],201);
    }

    public function MandanismDetail($id)
    {
        $data = Mandanism::find($id);

        return response([
            'status' => true,
            'message' => 'Mandanism Detail.',
            'data' => new MandanismDetailResource($data)
        ],201);
    }

    public function LatestNewsList(Request $request)
    {
        $data = LatestNews::where('status','active')->get();

        return response([
            'status' => true,
            'message' => 'Latest News List.',
            'data' => NewsResource::collection($data)
        ],201);
    }

    public function LatestNewsDetail($id)
    {
        $data = LatestNews::find($id);

        return response([
            'status' => true,
            'message' => 'Latest News Detail.',
            'data' => new NewsDetailResource($data)
        ],201);
    } 

    public function HolyBookList(Request $request)
    {
        $id = Auth::id();
        $type = $request->type;
        if($type=='holy'){
            $data = HolyBook::where('type','holy')->where('status','active')->get();
        }else{
            $data = HolyBook::where('type','author')->where('status','active')->get();
        }    
        return response([
            'status' => true,
            'message' => 'Holy Book List.',
            'data' => HolyBookResource::collection($data)
        ],201);
    }

    public function Bookmark(Request $request){
        $validator = Validator::make($request->all(), [
            'book_id' => 'required',
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

        $data = Bookmark::where(['user_id'=>$id,'book_id'=>$request->book_id])->first();
        if($data){
            $bookmark = ($data->bookmark=='yes')?'no':'yes';
            Bookmark::where(['user_id' => $id, 'book_id' => $request->book_id])->update(['bookmark' => $bookmark]);

            return response([
                'status' => true,
                'message' => 'Bookmark saved.',
                'data' => []
            ],201);
        }else{
            Bookmark::create([
                'user_id' => $id,
                'book_id' => $request->book_id,
                'bookmark' => 'yes'
            ]);

            return response([
                'status' => true,
                'message' => 'Bookmark saved.',
                'data' => []
            ],201);
        }
    }

    public function RitualsList(Request $request)
    {
        $data = Ritual::where('status','active')->get();

        return response([
            'status' => true,
            'message' => 'Rituals List.',
            'data' => RitualResource::collection($data)
        ],201);
    }

    public function RitualsDetail($id)
    {
        $data = Ritual::find($id);
        return response([
            'status' => true,
            'message' => 'Rituals Detail.',
            'data' => new RitualDetailResource($data)
        ],201);
    } 

    public function PrayerList(Request $request)
    {
        $data = Prayer::where('status','active')->get();

        return response([
            'status' => true,
            'message' => 'Prayer List.',
            'data' => PrayerResource::collection($data)
        ],201);
    }

    public function PrayerDetail($id)
    {
        $data = Prayer::find($id);
        return response([
            'status' => true,
            'message' => 'Prayer Detail.',
            'data' => new PrayerDetailResource($data)
        ],201);
    }

    public function ProgramList(Request $request)
    {
        $data = Program::where('status','active')->get();

        return response([
            'status' => true,
            'message' => 'Program List.',
            'data' => ProgramResource::collection($data)
        ],201);
    }

    public function ProgramDetail($id)
    {
        $data = Program::find($id);

        return response([
            'status' => true,
            'message' => 'Program Detail.',
            'data' => new ProgramDetailResource($data)
        ],201);
    }

}
