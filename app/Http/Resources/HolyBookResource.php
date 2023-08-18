<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Bookmark;
use Auth;

class HolyBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $id = Auth::id();
        $book = Bookmark::where(['user_id'=>$id,'book_id'=>$this->id])->first();
        if($request->lang == 'ar'){
            return [
                'id'            => $this->id,
                'title'         => $this->ar_title,
                'description'   => $this->ar_description,
                'image'         => url('/').'/'.$this->image,
                'url'           => url('/').'/'.$this->url,
                'bookmark'      => ($book)?'yes':'no',
            ];
        }elseif ($request->lang == 'pe') {
            return [
                'id'            => $this->id,
                'title'         => $this->pe_title,
                'description'   => $this->pe_description,
                'image'         => url('/').'/'.$this->image,
                'url'           => url('/').'/'.$this->url,
                'bookmark'      => ($book)?'yes':'no',
            ];
        }else{
            return [
                'id'            => $this->id,
                'title'         => $this->title,
                'description'   => $this->description,
                'image'         => url('/').'/'.$this->image,
                'url'           => url('/').'/'.$this->url,
                'bookmark'      => ($book)?'yes':'no',
            ];
        }
    }
}
