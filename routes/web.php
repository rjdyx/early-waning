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
    return view('welcome');
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
});


