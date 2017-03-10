<?php

namespace App\Http\Controllers\Admin;

use App\Plan;
use App\NormalType;
use App\EmergencyCrewPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request)
    {

        //request保存
        $request->flash();

        // 查询条件：预案名称
        $queryText = $request->input('query_text');
        // 自定义分页数
        $pageSize = $request->input('page_size');
        $pageSize = $pageSize? $pageSize: config('app.page_size');

        $plans = DB::table('plans')
            ->join('normal_types as plan_type', 'plan_type.id' , '=', 'plans.plan_type_id')
            ->select(
                'plans.id',
                'plans.name',
                'plans.content',
                'plans.created_at as plans_created_at',
                'plan_type.id as plan_type_id',
                'plan_type.name as plan_type_name'
            )
            ->whereRaw('1=1');


        $queryText && $plans->where('plans.name', 'like', '%'.$queryText.'%');

        $results = $plans->orderBy('plans_created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate((int)$pageSize);

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
        $results = Plan::destroy($ids);
        foreach ($ids as $id) {
            EmergencyCrewPlan::where('plan_id', $id)->delete();
        }
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
            'plan_type_id' => 'required|max:10',
        ]);

        $name = $request->input('name');
        $content = $request->input('content');
        $plan_type_id = $request->input('plan_type_id');
        $leader = $request->input('leader');
        $subLeader = $request->input('subLeader');
        $member = $request->input('member');

        // 检查机构类型是否存在
        if(!NormalType::where('id', $plan_type_id)->where('type', 3)->first()) {
            return response()->json('plan type dose not exist!');
        }

        $plan = $id? Plan::find($id): new Plan();

        $plan->name = $name;
        $plan->content = $content;
        $plan->plan_type_id = $plan_type_id;

        $plan->save();

        $id && EmergencyCrewPlan::where('plan_id', $id)->delete();
        $leader && $this->storeEmergencyCrew($leader, $plan, 1);
        $subLeader && $this->storeEmergencyCrew($subLeader, $plan, 2);
        $member && $this->storeEmergencyCrew($member, $plan, 3);

        if($id) {
            return response()->json(true);
        }else {
            return response()->json($plan->id);
        }
        
    }

    private function storeEmergencyCrew($arr=[], $plan, $type=1)
    {
        foreach ($arr as $id) {
            $emergencyCrewPlan = new EmergencyCrewPlan();
            $emergencyCrewPlan->emergency_crew_id = $id;
            $emergencyCrewPlan->plan_id = $plan->id;
            $emergencyCrewPlan->title = $type;
            $emergencyCrewPlan->save();
        }
    }
}
