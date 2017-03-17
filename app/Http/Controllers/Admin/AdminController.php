<?php

/**
 * 超级管理员接口
 */

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(Request $request)
    {
        $message = [
            'unique' => ':attribute重复'
        ];
        $this->validate($request, [
            'name' => 'required|max:20|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ], $message);
        $data = $request->all();
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->active = 0;
        $user->save();

        return $user;
    }
    
    /**
     * 获取所有用户，包括按搜索条件获取，按状态获取
     * @param Request $request
     * @return mixed
     */
    public function query(Request $request)
    {
        //request保存
        $request->flash();

        // 没有条件时获取全部
        $users = User::whereRaw('1=1')
            ->where('name', '<>', 'admin')
            ->select(
                'id',  
                'name', 
                'email', 
                'active', 
                'created_at'
            );

        // 搜索内容
        $param = $request->input('param');
        // 状态
        $active = $request->input('active');

        $param && $users = $users->where('name', 'like', '%'.$param.'%');

        $active && $users = $users->where('active', $active);

        $users = $users
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.page_size'));
        
        return $users;

    }

    /**
     * 冻结或解冻用户
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function triggleUser($id)
    {
        if(!Auth::user()->can('user-lock')){
            return response()->json('false');
        }

        $user = User::where('id', $id)
            ->where('name', '<>', 'admin')
            ->first();
        if($user == null){
            return response()->json('false');
        }
        if($user->active == 0){
            $user->active = 1;
            $user->save();
        }else {
            $user->active = 0;
            $user->save();
        }
        return response()->json(true);
    }

    /**
     * 批量冻结
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchLock(Request $request)
    {
        $userIds = $request->all();
        $result = User::where('name', '<>', 'admin')
            ->whereIn('id', $userIds)
            ->update([
               'active' => 1
            ]);
        return response()->json($result);
    }

    /**
     * 批量解冻
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchUnlock(Request $request)
    {
        $userIds = $request->all();
        $result = User::where('name', '<>', 'admin')
            ->whereIn('id', $userIds)
            ->update([
                'active' => 0
            ]);
        return response()->json($result);
    }
}
