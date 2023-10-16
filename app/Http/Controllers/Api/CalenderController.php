<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReligiousOccasion;
use App\Models\ChooseCalender;
use App\Models\Event;
use App\Models\EventReminder;
use App\Http\Resources\EventResource;
use Validator;
use Auth;

class CalenderController extends Controller
{
    public function ReligiousOccasions(Request $request){
        $validator = Validator::make($request->all(), [
            'year' => 'required',
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
            'year' => $request->date,
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
        $date = $request->date;
        
        $allDates = Event::where(['status'=>'active'])->groupBy('date')->pluck('date');
        $allEvents = Event::select('id','title','description','date')->where(['status'=>'active'])->get();
        $data = Event::select('id','title','description','date')->where(['date'=>$date, 'status'=>'active'])->get();

        return response([
            'status' => true,
            'message' => 'All calender list.',
            'data' => EventResource::collection($data),
            'allDates' => $allDates,
            'allEvents' => EventResource::collection($allEvents)
        ],201);
    }

    public function Melvashe(){

        $data['melvashe'] = [
            ['id'=>1,'name'=>'Dowla'],
            ['id'=>2,'name'=>'Nuna'],
            ['id'=>3,'name'=>'Ambero'],
            ['id'=>4,'name'=>'Towra'],
            ['id'=>5,'name'=>'Selmi'],
            ['id'=>6,'name'=>'Saratana'],
            ['id'=>7,'name'=>'Aria'],
            ['id'=>8,'name'=>'Shumbolta'],
            ['id'=>9,'name'=>'Qina'],
            ['id'=>10,'name'=>'Arqwa'],
            ['id'=>11,'name'=>'Heṭia'],
            ['id'=>12,'name'=>'Gadia']
        ];

        $data['months'] = [
            ['id'=>1,'name'=>'Dowla'],
            ['id'=>2,'name'=>'Nuna'],
            ['id'=>3,'name'=>'Ambero'],
            ['id'=>4,'name'=>'Towra'],
            ['id'=>5,'name'=>'Selmi'],
            ['id'=>6,'name'=>'Saratana'],
            ['id'=>7,'name'=>'Aria'],
            ['id'=>8,'name'=>'Shumbolta'],
            ['id'=>9,'name'=>'Qina'],
            ['id'=>10,'name'=>'Arqwa'],
            ['id'=>11,'name'=>'Heṭia'],
            ['id'=>12,'name'=>'Gadia']
        ];

        return response([
            'status' => true,
            'message' => 'Melvashe list.',
            'data' => $data
        ],201);
    }

    public function MelvashePost(Request $request){

        $gender = $request->gender;
        $melvashe = $request->melvashe;
        $month = $request->month;
        $time = $request->time;
        $dob = $request->dob;
        $date_type = $request->date_type;

        $data['mandaean_date'] = '19, Shombolta (445365 Adam) (1998 Yahyaiee)';
        $data['gregorian_date'] = '1996,03,08 Friday';
        $data['solar_date'] = '1374, 12, 18';

        return response([
            'status' => true,
            'message' => 'Data fetched.',
            'data' => $data
        ],201);
    }
}
