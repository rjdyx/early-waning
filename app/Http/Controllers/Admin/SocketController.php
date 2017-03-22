<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocketController extends Controller
{
    public function getUser(Request $request)
    {
    	return Auth::user();
    }
}
