<?php

namespace App\Http\Controllers\Admin;

use App\EventProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EventProgressController extends Controller
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

        $eventId = $request->input('event_id');

        $eventProgress = DB::table('event_progresses')
            ->join('users', 'users.id' , '=', 'event_progresses.user_id')
            ->select(
                'event_progresses.id',
                'event_progresses.content',
                'event_progresses.created_at as event_progresses_created_at',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->orderBy('event_progresses_created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(config('app.page_size'));

        return $eventProgress;
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
            'content' => 'required',
            'event_id' => 'required|max:10',
            'user_id' => 'required|max:10'
        ]);

        $content = $request->input('content');
        $event_id = $request->input('event_id');
        $user_id = $request->input('user_id');

        $eventProgress = new EventProgress();

        $eventProgress->content = $content;
        $eventProgress->event_id = $event_id;
        $eventProgress->user_id = $user_id;
        $eventProgress->save();

        return response()->json($eventProgress);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return EventProgress::destroy($id);
    }
}
