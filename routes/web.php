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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

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
});


