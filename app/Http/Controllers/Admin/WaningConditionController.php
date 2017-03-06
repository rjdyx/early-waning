<?php

namespace App\Http\Controllers\Admin;

use App\WaningCondition;
use App\NormalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WaningConditionController extends Controller
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

        $waningConditions = DB::table('waning_conditions')
            ->select(
                'waning_conditions.id',
                'waning_conditions.code',
                'waning_conditions.description',
                'waning_conditions.type',
                'waning_conditions.created_at as waningConditions_created_at'
            )
            ->whereRaw('1=1');


        $queryText && $waningConditions->where('waning_conditions.name', 'like', '%'.$queryText.'%');

        $results = $waningConditions->orderBy('waningConditions_created_at', 'desc')
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
        $results = plan::destroy($ids);
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
            'code' => 'required|string|max:50',
            'description' => 'required|string|max:50',
            'type' => 'required|integer|between:1,2',
        ]);

        $code = $request->input('code');
        $description = $request->input('description');
        $type = $request->input('type');


        $waningCondition = $id? WaningCondition::find($id): new WaningCondition();
        $waningCondition->code = $code;
        $waningCondition->description = $description;
        $waningCondition->type = $type;

        $waningCondition->save();

        if($id) {
            return response()->json(true);
        }else {
            return response()->json($waningCondition->id);
        }
        
    }
}
