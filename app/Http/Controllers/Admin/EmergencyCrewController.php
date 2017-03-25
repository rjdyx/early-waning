<?php

namespace App\Http\Controllers\Admin;

use App\Org;
use App\User;
use App\EmergencyCrew;
use App\EmergencyCrewPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmergencyCrewController extends Controller
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

        // 查询条件：专家姓名
        $queryText = $request->input('query_text');
        // 自定义分页数
        $pageSize = $request->input('page_size');
        $pageSize = $pageSize? $pageSize: config('app.page_size');
        // 排除这些id
        $exceptIds = $request->input('except_ids');

        $emergencyCrews = DB::table('emergency_crews')
            ->leftJoin('users', 'users.id' , '=', 'emergency_crews.user_id')
            ->join('orgs', 'orgs.id' , '=', 'emergency_crews.org_id')
            ->select(
                'emergency_crews.id',
                'emergency_crews.name',
                'emergency_crews.age',
                'emergency_crews.sex',
                'emergency_crews.duty',
                'emergency_crews.title',
                'emergency_crews.phone',
                'emergency_crews.cellphone',
                'emergency_crews.email',
                'emergency_crews.meno',
                'emergency_crews.org_id',
                'emergency_crews.created_at as emergency_crew_created_at',
                'orgs.id as org_id',
                'orgs.name as org_name',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->whereRaw('1=1');


        $queryText && $emergencyCrews->where('emergency_crews.name', 'like', '%'.$queryText.'%');

        $exceptIds && $emergencyCrews->whereNotIn('emergency_crews.id', $exceptIds);

        $results = $emergencyCrews->orderBy('emergency_crew_created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate((int)$pageSize);

        return $results;
    }

    /**
     * 获取三种类型的应急人员
     */
    public function queryCrew($id)
    {
        $emergencyCrews = DB::table('emergency_crew_plans')
            ->join('emergency_crews', 'emergency_crews.id', '=', 'emergency_crew_plans.emergency_crew_id')
            ->select(
                'emergency_crews.id',
                'emergency_crews.name',
                'emergency_crew_plans.title'
            )
            ->where('plan_id', $id)
            ->orderBy('title')
            ->get();
        $leaders = array();
        $subLeaders = array();
        $members = array();
        foreach ($emergencyCrews as $emergencyCrew) {
            if($emergencyCrew->title == 1) array_push($leaders, $emergencyCrew);
            if($emergencyCrew->title == 2) array_push($subLeaders, $emergencyCrew);
            if($emergencyCrew->title == 3) array_push($members, $emergencyCrew);
        }
        $users = User::where('role', 0)->get();

        return response()->json([
            'leader' => $leaders,
            'subLeader' => $subLeaders,
            'member' => $members,
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

        $emergencyCrewPlans = EmergencyCrewPlan::whereIn('emergency_crew_id', $ids)->get();
        if(sizeof($emergencyCrewPlans)) {
            return response()->json(false);
        }

        $results = EmergencyCrew::destroy($ids);
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
            'age' => 'integer',
            'sex' => 'required|integer|between:0,1',
            'duty' => 'required|max:20',
            'title' => 'required|max:20',
            'phone' => 'sometimes|phone|max:15',
            'cellphone' => 'sometimes|cellphone|max:15',
            'email' => 'sometimes|email|max:50',
            'meno' => 'max:255',
            'org_id' => 'required|max:10',
        ]);

        $name = $request->input('name');
        $age = $request->input('age');
        $sex = $request->input('sex');
        $duty = $request->input('duty');
        $title = $request->input('title');
        $phone = $request->input('phone');
        $cellphone = $request->input('cellphone');
        $email = $request->input('email');
        $meno = $request->input('meno');
        $org_id = $request->input('org_id');

        // 检查机构是否存在
        if(!Org::find($org_id)) {
            return response()->json('org dose not exist!');
        }

        $emergencyCrew = $id? EmergencyCrew::find($id): new EmergencyCrew();

        $emergencyCrew->name = $name;
        $emergencyCrew->age = $age;
        $emergencyCrew->sex = $sex;
        $emergencyCrew->duty = $duty;
        $emergencyCrew->title = $title;
        $emergencyCrew->phone = $phone;
        $emergencyCrew->cellphone = $cellphone;
        $emergencyCrew->email = $email;
        $emergencyCrew->meno = $meno;
        $emergencyCrew->org_id = $org_id;

        $emergencyCrew->save();

        if($id) {
            return response()->json(true);
        }else {
            return response()->json($emergencyCrew->id);
        }
        
    }

    public function bindUser(Request $request)
    {
        $id = $request->input('id');
        $userId = $request->input('user_id');

        EmergencyCrew::where('id', $id)->update(['user_id' => $userId]);
    }
}
