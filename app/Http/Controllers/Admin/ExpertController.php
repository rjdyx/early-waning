<?php

namespace App\Http\Controllers\Admin;

use App\Org;
use App\Expert;
use App\NormalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExpertController extends Controller
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

        $experts = DB::table('experts')
            ->leftJoin('users', 'users.id' , '=', 'experts.user_id')
            ->join('normal_types as expert_area', 'expert_area.id' , '=', 'experts.expert_area_id')
            ->join('orgs', 'orgs.id' , '=', 'experts.org_id')
            ->select(
                'experts.id',
                'experts.name',
                'experts.sex',
                'experts.degree',
                'experts.duty',
                'experts.title',
                'experts.address',
                'experts.zipcode',
                'experts.company',
                'experts.officephone',
                'experts.homephone',
                'experts.cellphone',
                'experts.email',
                'experts.meno',
                'experts.org_id',
                'experts.created_at as expert_created_at',
                'expert_area.id as expert_area_id',
                'expert_area.name as expert_area',
                'orgs.id as org_id',
                'orgs.name as org_name',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->whereRaw('1=1');


        $queryText && $experts->where('experts.name', 'like', '%'.$queryText.'%');

        $exceptIds && $experts->whereNotIn('experts.id', $exceptIds);

        $results = $experts->orderBy('expert_created_at', 'desc')
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
        $results = Expert::destroy($ids);
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
            'sex' => 'required|integer|between:0,1',
            'degree' => 'max:20',
            'duty' => 'required|max:20',
            'title' => 'required|max:20',
            'address' => 'max:50',
            'zipcode' => 'max:20',
            'company' => 'max:50',
            'officephone' => 'sometimes|phones|max:15',
            'homephone' => 'sometimes|phone|max:15',
            'cellphone' => 'sometimes|cellphone|max:15',
            'email' => 'sometimes|email|max:50',
            'meno' => 'max:255',
            'org_id' => 'required|max:10',
            'expert_area_id' => 'required|max:10',
        ]);

        $name = $request->input('name');
        $sex = $request->input('sex');
        $degree = $request->input('degree');
        $duty = $request->input('duty');
        $title = $request->input('title');
        $address = $request->input('address');
        $zipcode = $request->input('zipcode');
        $company = $request->input('company');
        $officephone = $request->input('officephone');
        $homephone = $request->input('homephone');
        $cellphone = $request->input('cellphone');
        $email = $request->input('email');
        $meno = $request->input('meno');
        $org_id = $request->input('org_id');
        $expert_area_id = $request->input('expert_area_id');

        // 检查机构是否存在
        if(!Org::find($org_id)) {
            return response()->json('org dose not exist!');
        }

        // 检查机构类型是否存在
        if(!NormalType::where('id', $expert_area_id)->where('type', 2)->first()) {
            return response()->json('expert area dose not exist!');
        }

        $expert = $id? Expert::find($id): new Expert();

        $expert->name = $name;
        $expert->sex = $sex;
        $expert->degree = $degree;
        $expert->duty = $duty;
        $expert->title = $title;
        $expert->address = $address;
        $expert->zipcode = $zipcode;
        $expert->company = $company;
        $expert->officephone = $officephone;
        $expert->homephone = $homephone;
        $expert->cellphone = $cellphone;
        $expert->email = $email;
        $expert->meno = $meno;
        $expert->org_id = $org_id;
        $expert->expert_area_id = $expert_area_id;

        $expert->save();

        if($id) {
            return response()->json(true);
        }else {
            return response()->json($expert->id);
        }
        
    }

    public function bindUser(Request $request)
    {
        $id = $request->input('id');
        $userId = $request->input('user_id');

        Expert::where('id', $id)->update(['user_id' => $userId]);
    }
}
