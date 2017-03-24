<?php

namespace App\Http\Controllers\Admin;


use App\Event;
use App\Plan;
use App\Information;
use App\Expert;
use App\EventHandle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EventHandleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request)
    {

        // $this->validate($request, [
        //     'status' => 'required|integer|between:1,7'
        // ]);

        //request保存
        $request->flash();

        $eventId = $request->input('event_id');

        $events = DB::table('event_handles')
            ->join('plans', 'plans.id' , '=', 'event_handles.plan_id')
            ->join('informations', 'informations.id' , '=', 'event_handles.information_id')
            ->join('experts', 'experts.id' , '=', 'event_handles.expert_id')
            ->select(
                'plans.id as plan_id',
                'plans.name as plan_name',
                'plans.content as plan_content',
                'plans.plan_type_id',
                'informations.id as information_id',
                'informations.name as information_name',
                'informations.content as information_content',
                'informations.information_type_id',
                'experts.id as expert_id',
                'experts.name as expert_name'
            )
            ->where('event_handles.event_id', $eventId)
            ->get();

        if(sizeof($events)) {
            $plan = new Plan();
            $plan->id = $events[0]->plan_id;
            $plan->name = $events[0]->plan_name;
            $plan->content = $events[0]->plan_content;
            $plan->plan_type_id = $events[0]->plan_type_id;

            $information = new Information();
            $information->id = $events[0]->information_id;
            $information->name = $events[0]->information_name;
            $information->content = $events[0]->information_content;
            $information->plan_type_id = $events[0]->information_type_id;
        }

        $experts = array();

        foreach ($events as $event) {
            $expert = new Expert();
            $expert->id = $event->expert_id;
            $expert->name = $event->expert_name;
            array_push($experts, $expert);
        }

        

        return response()->json([
                'plan' => $plan,
                'information' =>$information,
                'experts' => $experts
            ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'event_id' => 'required|max:10',
            'event_status' => 'required|max:10',
            'plan_id' => 'required|max:10',
            'information_id' => 'required|max:10',
            'expert_ids' => 'required|max:10'
        ]);

        $event_id = $request->input('event_id');
        $event_status = $request->input('event_status');
        $plan_id = $request->input('plan_id');
        $information_id = $request->input('information_id');
        $expert_ids = $request->input('expert_ids');


        foreach ($expert_ids as $expert_id) {
            $eventHandle = new EventHandle();
            $eventHandle->event_id = $event_id;
            $eventHandle->plan_id = $plan_id;
            $eventHandle->information_id = $information_id;
            $eventHandle->expert_id = $expert_id;
            $eventHandle->save();
        }

        if($event_status == 1) {
            Event::where('id', $event_id)
                ->update(['status' => 2]);
        }

        if($event_status == 4) {
            Event::where('id', $event_id)
                ->update(['status' => 5]);
        }
        

        return response()->json(true);

    }

}
