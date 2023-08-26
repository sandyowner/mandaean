<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReligiousOccasion;
use App\Models\ChooseCalender;
use App\Models\EventReminder;
use Validator;
use Auth;

class CalenderController extends Controller
{
    public function ReligiousOccasions(Request $request){
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'date_type' => 'required',
            'occasion' => 'required'
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

        $occasion = ReligiousOccasion::create([
            'user_id' => $id,
            'date' => $request->date,
            'date_type' => $request->date_type,
            'occasion' => $request->occasion
        ]);

        return response([
            'status'=>true,
            'message'=>'Occasion added.',
            'data'=>$occasion
        ],201);
    }

    public function ChooseCalender(Request $request){
        $validator = Validator::make($request->all(), [
            'first_display' => 'required',
            'second_display' => 'required',
            'third_display' => 'required'
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

        $occasion = ChooseCalender::where('user_id',$id)->first();
        if($occasion){
            ChooseCalender::where(['user_id' => $id])->update([
                'first_display' => $request->first_display,
                'second_display' => $request->second_display,
                'third_display' => $request->third_display
            ]);
            $message = 'Record Updated.';
        }else{
            ChooseCalender::create([
                'user_id' => $id,
                'first_display' => $request->first_display,
                'second_display' => $request->second_display,
                'third_display' => $request->third_display
            ]);
            $message = 'Record Added.';
        }

        return response([
            'status' => true,
            'message' => $message,
            'data' => []
        ],201);
    }

    public function SetEventReminder(Request $request){
        $validator = Validator::make($request->all(), [
            'date_type' => 'required',
            'set_before_reminder' => 'required'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response([
                'status' => false,
                'message' => $error,
                'data' => []
            ],422);
        }

        $eventType = json_decode($request->event_type,true);
        if (count($eventType)<1) {
            return response([
                'status'=>false,
                'field'=>'event_type',
                'message'=>'Select at least one event type for reminder.',
                'data'=>[]
            ],422);
        }
        $id = Auth::id();

        $reminder = EventReminder::where('user_id',$id)->first();
        if($reminder){
            EventReminder::where(['user_id' => $id])->update([
                'date_type' => $request->date_type,
                'event_type' => json_encode(array_unique($eventType)),
                'set_before_reminder' => $request->set_before_reminder
            ]);
        }else{
            EventReminder::create([
                'user_id' => $id,
                'date_type' => $request->date_type,
                'event_type' => json_encode(array_unique($eventType)),
                'set_before_reminder' => $request->set_before_reminder
            ]); 
        }

        return response([
            'status' => true,
            'message' => 'Reminder set successfully.',
            'data' => []
        ],201);
    }

    public function DeleteAllReminder(Request $request){
        $id = Auth::id();

        $reminder = EventReminder::where('user_id',$id)->delete();
        return response([
            'status' => true,
            'message' => 'All reminders deleted.',
            'data' => []
        ],201);
    }

    public function CalenderList(Request $request){
        $month = $request->month;
        $year = $request->year;
        $lastDay = date('t',strtotime('01-'.$month.'-'.$year));
        
        $array = [];
        for ($i=1; $i <= $lastDay; $i++) { 
            $date = date('Y-m-d',strtotime($i.'-'.$month.'-'.$year));
            $array[$i-1]['date'] = $date;
            $array[$i-1]['occasions'] = ReligiousOccasion::where('date',$date)->first();
        }
        return response([
            'status' => true,
            'message' => 'All calender list.',
            'data' => $array
        ],201);
    }
}
