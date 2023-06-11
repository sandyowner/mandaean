<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function profile(Request $request){
        $userId = Auth::id();
        dd($userId);
    }
}
