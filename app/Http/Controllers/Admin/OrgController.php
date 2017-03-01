<?php

namespace App\Http\Controllers\Admin;

use App\Org;
use App\NormalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrgController extends Controller
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

        // 查询条件：机构名称
        $queryText = $request->input('query_text');

        $orgs = DB::table('orgs')
            ->join('normal_types', 'normal_types.id' , '=', 'orgs.org_level_id')
            ->select(
                'orgs.id',
                'orgs.name',
                'orgs.address',
                'orgs.zipcode',
                'orgs.phone',
                'orgs.cellphone',
                'orgs.fax',
                'orgs.meno',
                'orgs.pid',
                'orgs.created_at as org_created_at',
                'normal_types.id as org_level_id',
                'normal_types.name as org_level'
            )
            ->whereRaw('1=1');


        $queryText && $orgs->where('orgs.name', 'like', '%'.$queryText.'%');

        $results = $orgs->orderBy('org_created_at', 'desc')
            ->paginate(config('app.page_size'));

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
        $results = Org::destroy($ids);
        foreach ($ids as $id) {
            Org::where('pid', $id)->delete();
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
            'address' => 'max:50',
            'zipcode' => 'max:20',
            'phone' => 'max:15',
            'cellphone' => 'max:15',
            'fax' => 'max:15',
            'meno' => 'max:255',
            'pid' => 'integer|max:10',
            'org_level_id' => 'required|max:10',
        ]);

        $name = $request->input('name');
        $address = $request->input('address');
        $zipcode = $request->input('zipcode');
        $phone = $request->input('phone');
        $cellphone = $request->input('cellphone');
        $fax = $request->input('fax');
        $meno = $request->input('meno');
        $pid = $request->input('pid');
        $org_level_id = $request->input('org_level_id');

        // 检查父id对应的对象是否存在
        if($pid && !Org::find($pid)) {
            return response()->json('parent org dose not exist!');
        }

        // 检查机构类型是否存在
        if(!NormalType::where('id', $org_level_id)->where('type', 1)) {
            return response()->json('org level dose not exist!');
        }

        $org = $id? Org::find($id): new Org();

        $org->name = $name;
        $org->address = $address;
        $org->zipcode = $zipcode;
        $org->phone = $phone;
        $org->cellphone = $cellphone;
        $org->fax = $fax;
        $org->meno = $meno;
        $pid && $org->pid = $pid;
        $org->org_level_id = $org_level_id;

        $org->save();

        if($id) {
            return response()->json(true);
        }else {
            return response()->json($org->id);
        }
        
    }
}
