<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Meeting;
use App\Expert;
use App\EmergencyCrew;
use App\MeetingCrew;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
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
            'status' => 'required|integer|between:1,3'
        ]);

        //request保存
        $request->flash();

        // 查询条件：会议名称
        $queryText = $request->input('query_text');
        // 事件状态:
        // 1：待处理会议
        // 2：正处理会议
        // 3：历史预会议
        $status = $request->input('status');

        $meetings = DB::table('meetings')
            ->select(
                'meetings.id',
                'meetings.name',
                'meetings.location',
                'meetings.detail',
                'meetings.status',
                'meetings.created_at as meetings_created_at'
            )
            ->whereRaw('1=1')
            ->where('meetings.status', $status);


        $queryText && $meetings->where('meetings.name', 'like', '%'.$queryText.'%');

        $results = $meetings->orderBy('meetings_created_at', 'desc')
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
        // 1：待处理会议
        // 2：正处理会议
        // 3：历史会议
        $status = $request->input('status');
        //禁止获取待处理相关的会议
        foreach ($status as $item) {
            if($item == 1) {
                return response()->json(false);
            }
        }

        if($user->role == 1) {
            $expert = Expert::where('user_id', $user->id)->first();
            $expert && $meetings = DB::table('meetings')
                ->join('meeting_handles', 'meeting_handles.event_id' , '=', 'meetings.id')
                ->select(
                    'meetings.id',
                    'meetings.name',
                    'meetings.location',
                    'meetings.detail',
                    'meetings.status',
                    'meetings.created_at as meetings_created_at'
                )
                ->where('meeting_handles.expert_id', $expert->id)
                ->whereIn('meetings.status', $status);
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

            $meetingIds = array();
            foreach ($plans as $plan) {
                array_push($meetingIds, $plan->event_id);
            }

            $meetings = DB::table('meetings')
                ->join('normal_types as event_level', 'event_level.id' , '=', 'meetings.event_level_id')
                ->join('normal_types as event_sort', 'event_sort.id' , '=', 'meetings.event_sort_id')
                ->select(
                    'meetings.id',
                    'meetings.name',
                    'meetings.location',
                    'meetings.detail',
                    'meetings.status',
                    'meetings.created_at as meetings_created_at',
                    'event_level.id as event_level_id',
                    'event_level.name as event_level_name',
                    'event_sort.id as event_sort_id',
                    'event_sort.name as event_sort_name'
                )
                ->whereIn('meetings.id', $meetingIds)
                ->whereIn('meetings.status', $status);

        }

        $results = $meetings->orderBy('status')
            ->orderBy('meetings_created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return $results;
    }

    /**
     * 获取应急人员和专家
     */
    public function queryCrew($id)
    {
        $meetingCrews = DB::table('meeting_crews')
            ->leftJoin('emergency_crews', 'emergency_crews.id', '=', 'meeting_crews.emergency_crew_id')
            ->leftJoin('experts', 'experts.id', '=', 'meeting_crews.expert_id')
            ->select(
                'emergency_crews.id',
                'emergency_crews.name',
                'emergency_crew_plans.title',
                'experts.id',
                'experts.name',
                'experts.title'
            )
            ->where('meeting_crews.meeting_id', $id)
            ->orderBy('title')
            ->get();
        $emergencyCrews = array();
        $experts = array();
        foreach ($meetingCrews as $meetingCrew) {
            if($meetingCrews->emergency_crew_id == null) array_push($emergencyCrews, $meetingCrew);
            if($emergencyCrew->expert_id == null) array_push($experts, $meetingCrew);
        }
        $users = User::where('role', 0)->get();

        return response()->json([
            'emergencyCrew' => $emergencyCrews,
            'expert' => $experts,
            'users' => $users
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
            'date' => 'required',
            'location' => 'required|string|max:50',
            'master' => 'required|string|max:50',
            'title' => 'required|string|max:50',
            'recorder' => 'string|max:50',
            'status' => 'required|integer|between:1,3'
        ]);

        $date = $request->input('date');
        echo $date;
        $location = $request->input('location');
        $master = $request->input('detail');
        $title = $request->input('title');
        $recorder = $request->input('recorder');
        $content = $request->input('content');
        $status = $request->input('status');
        $emergencycrews = $request->input('emergencycrews');
        $experts = $request->input('experts');


        $meeting = $id? Meeting::find($id): new Meeting();

        $meeting->date = $date;
        $meeting->location = $location;
        $meeting->master = $master;
        $meeting->title = $title;
        $meeting->recorder = $recorder;
        $meeting->content = $content;
        $meeting->status = $status;

        $meeting->save();

        foreach ($emergencycrews as $emergencycrew) {
            $meetingCrew = new MeetingCrew();
            $meetingCrew->meeting_id = $meeting->id;
            $meetingCrew->emergency_crew_id = $emergencycrew;
            $meetingCrew->save();
        }

        foreach ($experts as $expert) {
            $meetingCrew = new MeetingCrew();
            $meetingCrew->meeting_id = $meeting->id;
            $meetingCrew->expert_id = $expert;
            $meetingCrew->save();
        }

        if($id) {
            return response()->json(true);
        }else {
            return response()->json($meeting->id);
        }
        
    }
}
