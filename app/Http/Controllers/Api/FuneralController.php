<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FuneralController extends Controller
{
    public function Funeral(Request $request){
        $data['coffin'] = [
            ["id"=>1,"name"=>"Richmond Teak Matt"],
            ["id"=>2,"name"=>"Richmond Teak Matt Oversized $150"],
            ["id"=>3,"name"=>"Richmond Teak Gloss $250"],
            ["id"=>4,"name"=>"Richmond Teak Gloss Oversized $400"],
            ["id"=>5,"name"=>"Richmond Red Cedar Gloss $250"],
            ["id"=>6,"name"=>"Richmond Red Cedar Gloss Oversized $400"],
            ["id"=>7,"name"=>"Richmond Rosewood Gloss $250"],
            ["id"=>8,"name"=>"Richmond Rosewood Gloss Oversized $400"],
            ["id"=>9,"name"=>"Richmond White Gloss $250"],
            ["id"=>10,"name"=>"Richmond White Gloss Oversized $400]"]
        ]; 
        $data['coffin_flower'] = [
            ['id'=>1,"name"=>"Not Required "],
            ['id'=>2,"name"=>"Standard White Seasonal Mix $350"]
        ];
        $data['transfers'] = [
            ['id'=>1,"name"=>"Deceased staying at home (No Charge)"],
            ['id'=>2,"name"=>"Deceased transferring from Home $520"],
            ['id'=>3,"name"=>"Deceased transferring from Hospital $275"],
            ['id'=>4,"name"=>"Deceased transferring from Coroner $275"],
            ['id'=>5,"name"=>"Deceased transferring from Nursing Home $520"]
        ];
        $data['cremation'] = [
            ['id'=>1,"name"=>"Weekday"],
            ['id'=>2,"name"=>"Saturday: $880"],
            ['id'=>3,"name"=>"Sunday: $1320"]
        ];

        return response([
            'status' => true,
            'message' => 'Fetched',
            'data' => $data
        ],201);
    }
}
