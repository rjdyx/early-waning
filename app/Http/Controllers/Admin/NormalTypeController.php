<?php

namespace App\Http\Controllers\Admin;

use App\NormalType;
use App\Org;
use App\Expert;
use App\Plan;
use App\Information;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NormalTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|integer|between:1,6'
        ]);

        $type = $request->input('type');

        $normalTypes = NormalType::where('type', $type)
            ->select('id', 'name', 'created_at')
            ->orderBy('created_at')
            ->get();

        return $normalTypes;
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
            'name' => 'required|string|max:20',
            'type' => 'required|integer|between:1,6'
        ]);

        $name = $request->input('name');
        $type = $request->input('type');

        $normalType = new NormalType();
        $normalType->name = $name;
        $normalType->type = $type;
        $normalType->save();

        return $normalType->id;
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
        $this->validate($request, [
            'name' => 'required|string|max:20'
        ]);

        $name = $request->input('name');

        $normalType = NormalType::find($id);

        if($normalType && $normalType->name == $name) {
            return response()->json('nothing change!');
        }

        $normalType->name = $name;
        $normalType->save();

        return response()->json(true);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $normalType = NormalType::find($id);

        $type = $normalType ? $normalType->type : 0;

        $results = [];

        switch ($type) {
            case 1:
                $results = Org::where('org_level_id', $id)->get();
                break;
            case 2:
                $results = Expert::where('expert_area_id', $id)->get();
                break;
            case 3:
                $results = Plan::where('plan_type_id', $id)->get();
                break;
            case 4:
                $results = Information::where('information_type_id', $id)->get();
                break;
            case 5:
                $results = Event::where('event_level_id', $id)->get();
                break;
            case 6:
                $results = Event::where('event_sort_id', $id)->get();
                break;
            default :
                return response()->json('normalType dose not exist!');
        }

        if(sizeof($results)) {
            return response()->json('been used!');
        }

        return response()->json($normalType->delete());
    }
}
