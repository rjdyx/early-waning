<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Expert;
use App\EmergencyCrew;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocketController extends Controller
{
    public function getUser(Request $request)
    {
    	$user = Auth::user();
    	if($user && $user->role == 1) {
    		$expert = Expert::where('user_id', $user->id)->first();
    		if($expert) {
				$user->role_id = $expert->id;
	    		$user->role_name = $expert->name;
    		} 
    	}

    	if($user && $user->role == 2) {
    		$emergencyCrew = EmergencyCrew::where('user_id', $user->id)->first();
    		if($emergencyCrew) {
				$user->role_id = $emergencyCrew->id;
	    		$user->role_name = $emergencyCrew->name;
    		} 
    	}
    	return $user;
    }
}
