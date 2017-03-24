<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Event;
use App\Expert;
use App\EmergencyCrew;
use App\NormalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request)
    {

        $this->validate($request, [
            'status' => 'required|integer|between:1,7'
        ]);

        //request保存
        $request->flash();

        // 查询条件：事件名称
        $queryText = $request->input('query_text');
        // 事件状态:
        // 1：待处理预警事件
        // 2：正处理预警事件
        // 3：历史预警事件
        // 4：待处理突发事件
        // 5：正处理突发事件
        // 6：历史突发事件
        // 7：科学评价后的突发事件
        $status = $request->input('status');

        $events = DB::table('events')
            ->join('normal_types as event_level', 'event_level.id' , '=', 'events.event_level_id')
            ->join('normal_types as event_sort', 'event_sort.id' , '=', 'events.event_sort_id')
            ->select(
                'events.id',
                'events.name',
                'events.location',
                'events.detail',
                'events.status',
                'events.created_at as events_created_at',
                'event_level.id as event_level_id',
                'event_level.name as event_level_name',
                'event_sort.id as event_sort_id',
                'event_sort.name as event_sort_name'
            )
            ->whereRaw('1=1')
            ->where('events.status', $status);


        $queryText && $events->where('events.name', 'like', '%'.$queryText.'%');

        $results = $events->orderBy('events_created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(config('app.page_size'));

        return $results;
    }

    /**
     * Display a listing of the resource from app.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function appQuery(Request $request)
    {

        $this->validate($request, [
            'status' => 'required|array'
        ]);

        //request保存
        $request->flash();

        $user = Auth::user();
        // 用户未登录
        if(!$user) {
            return response()->json('please login first');
        }
        // 用户角色为管理者
        if($user->role == 0) {
            return response()->json(false);
        }
        
        // 事件状态:
        // 1：待处理预警事件
        // 2：正处理预警事件
        // 3：历史预警事件
        // 4：待处理突发事件
        // 5：正处理突发事件
        // 6：历史突发事件
        // 7：科学评价后的突发事件
        $status = $request->input('status');
        //禁止获取待处理相关的事件
        foreach ($status as $item) {
            if($item == 1 || $item == 4) {
                return response()->json(false);
            }
        }

        if($user->role == 1) {
            $expert = Expert::where('user_id', $user->id)->first();
            $expert && $events = DB::table('events')
                ->join('normal_types as event_level', 'event_level.id' , '=', 'events.event_level_id')
                ->join('normal_types as event_sort', 'event_sort.id' , '=', 'events.event_sort_id')
                ->join('event_handles', 'event_handles.event_id' , '=', 'events.id')
                ->select(
                    'events.id',
                    'events.name',
                    'events.location',
                    'events.detail',
                    'events.status',
                    'events.created_at as events_created_at',
                    'event_level.id as event_level_id',
                    'event_level.name as event_level_name',
                    'event_sort.id as event_sort_id',
                    'event_sort.name as event_sort_name'
                )
                ->where('event_handles.expert_id', $expert->id)
                ->whereIn('events.status', $status);
        }else {
            $emergencyCrew = EmergencyCrew::where('user_id', $user->id)->first();
            $emergencyCrew && $plans = DB::table('plans')
                ->join('emergency_crew_plans', 'emergency_crew_plans.plan_id' , '=', 'plans.id')
                ->join('event_handles', 'event_handles.plan_id' , '=', 'plans.id')
                ->select(
                    'plans.id as plan_id',
                    'event_handles.event_id'
                )
                ->where('emergency_crew_plans.emergency_crew_id', $emergencyCrew->id)
                ->get();

            $eventIds = array();
            foreach ($plans as $plan) {
                array_push($eventIds, $plan->event_id);
            }

            $events = DB::table('events')
                ->join('normal_types as event_level', 'event_level.id' , '=', 'events.event_level_id')
                ->join('normal_types as event_sort', 'event_sort.id' , '=', 'events.event_sort_id')
                ->select(
                    'events.id',
                    'events.name',
                    'events.location',
                    'events.detail',
                    'events.status',
                    'events.created_at as events_created_at',
                    'event_level.id as event_level_id',
                    'event_level.name as event_level_name',
                    'event_sort.id as event_sort_id',
                    'event_sort.name as event_sort_name'
                )
                ->whereIn('events.id', $eventIds)
                ->whereIn('events.status', $status);

        }

        $results = $events->orderBy('status')
            ->orderBy('events_created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return $results;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->storeOrUpdate($request);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->storeOrUpdate($request, $id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('ids');
        $results = Event::destroy($ids);
        return response()->json($results);
    }

    /**
     * store or update
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function storeOrUpdate(Request $request, $id=0) 
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'location' => 'required|string|max:50',
            'detail' => 'required',
            'status' => 'required|integer|between:1,7',
            'event_level_id' => 'required|max:10',
            'event_sort_id' => 'required|max:10'
        ]);

        $name = $request->input('name');
        $location = $request->input('location');
        $detail = $request->input('detail');
        $status = $request->input('status');
        $event_level_id = $request->input('event_level_id');
        $event_sort_id = $request->input('event_sort_id');

        // 检查事件等级是否存在
        if(!NormalType::where('id', $event_level_id)->where('type', 5)->first()) {
            return response()->json('event level dose not exist!');
        }
        // 检查事件等级是否存在
        if(!NormalType::where('id', $event_sort_id)->where('type', 6)->first()) {
            return response()->json('event sort dose not exist!');
        }

        $event = $id? Event::find($id): new Event();

        $event->name = $name;
        $event->location = $location;
        $event->detail = $detail;
        $event->status = $status;
        $event->event_level_id = $event_level_id;
        $event->event_sort_id = $event_sort_id;

        $event->save();

        if($id) {
            return response()->json(true);
        }else {
            return response()->json($event->id);
        }
        
    }
}
