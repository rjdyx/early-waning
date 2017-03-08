<?php

namespace App\Http\Controllers\Admin;

use App\Information;
use App\NormalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InformationController extends Controller
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

        // 查询条件：专题名称
        $queryText = $request->input('query_text');

        $informations = DB::table('informations')
            ->join('normal_types as information_type', 'information_type.id' , '=', 'informations.information_type_id')
            ->select(
                'informations.id',
                'informations.name',
                'informations.content',
                'informations.created_at as informations_created_at',
                'information_type.id as information_type_id',
                'information_type.name as information_type_name'
            )
            ->whereRaw('1=1');


        $queryText && $informations->where('informations.name', 'like', '%'.$queryText.'%');

        $results = $informations->orderBy('informations_created_at', 'desc')
            ->orderBy('id', 'desc')
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
        $results = Information::destroy($ids);
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
            'information_type_id' => 'required|max:10',
        ]);

        $name = $request->input('name');
        $content = $request->input('content');
        $information_type_id = $request->input('information_type_id');

        // 检查机构类型是否存在
        if(!NormalType::where('id', $information_type_id)->where('type', 4)->first()) {
            return response()->json('information type dose not exist!');
        }

        $information = $id? Information::find($id): new Information();

        $information->name = $name;
        $information->content = $content;
        $information->information_type_id = $information_type_id;

        $information->save();

        if($id) {
            return response()->json(true);
        }else {
            return response()->json($information->id);
        }
        
    }
}
