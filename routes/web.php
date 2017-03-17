<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');

Route::get('/app', function () {
    return view('app');
});

Route::get('/home', function () {
    return view('home');
});



Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'active']], function () {

	// 类型
	Route::resource('normal-type', 'NormalTypeController');

	// 机构
	Route::get('org/query', 'OrgController@query');
	Route::delete('org', 'OrgController@destroy');
	Route::resource('org', 'OrgController');

	// 专家
	Route::get('expert/query', 'ExpertController@query');
	Route::delete('expert', 'ExpertController@destroy');
	Route::resource('expert', 'ExpertController');

	// 应急人员
	Route::get('emergencycrew/query', 'EmergencyCrewController@query');
	Route::get('emergencycrew/query-crew/{id}', 'EmergencyCrewController@queryCrew');
	Route::delete('emergencycrew', 'EmergencyCrewController@destroy');
	Route::resource('emergencycrew', 'EmergencyCrewController');

	// 预警条件
	Route::get('waningcondition/query', 'WaningConditionController@query');
	Route::delete('waningcondition', 'WaningConditionController@destroy');
	Route::resource('waningcondition', 'WaningConditionController');

	// 预案
	Route::get('plan/query', 'PlanController@query');
	Route::delete('plan', 'PlanController@destroy');
	Route::resource('plan', 'PlanController');

	// 预案
	Route::get('information/query', 'InformationController@query');
	Route::delete('information', 'InformationController@destroy');
	Route::resource('information', 'InformationController');

	// 事件
	Route::get('event/query', 'EventController@query');
	Route::delete('event', 'EventController@destroy');
	Route::resource('event', 'EventController');

	// 事件处理
	Route::get('eventhandle/query', 'EventHandleController@query');
	Route::resource('eventhandle', 'EventHandleController');

	Route::group(['middleware' => 'admin'], function () {

		// 新增用户
		Route::post('register', 'AdminController@create');

		// 获取所有用户，包括按搜索条件获取，按状态获取
        Route::get('user/query', 'AdminController@query');
        // 冻结或解冻用户
        Route::get('user/triggleUser/{id}', 'AdminController@triggleUser');
        // 批量冻结
        Route::get('user/batchLock', 'AdminController@batchLock');
        // 批量解冻
        Route::get('user/batchUnlock', 'AdminController@batchUnlock');

        // 获取所有角色，不分页
        Route::get('rbac/getAllRoles', 'RBACController@getAllRoles');
        // 获取所有权限
        Route::get('rbac/getAllPermission', 'RBACController@getAllPermission');
        // 按name获取权限
        Route::get('rbac/getPermissionByName/{name}', 'RBACController@getPermissionByName');
        // 按权限分类获取所有权限
        Route::get('rbac/getPermissionByClassification', 'RBACController@getPermissionByClassification');
        // 角色权限接口
        //获取用户所拥有的所有的角色的id
        Route::get('rbac/getUserRole/{id}', 'RBACController@getUserRole');
        Route::post('rbac/userBindRole', 'RBACController@userBindRole');
        Route::resource('rbac', 'RBACController');
    });

});

Auth::routes();
