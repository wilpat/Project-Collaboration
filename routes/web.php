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

/*Route::get('/{any?}', function () {
    return view('app');
});*/

Route::get('/', function () {
    return view('welcome');
});
/*Route::group(['middleware' => 'auth'], function(){
	Route::post('/projects', 'ProjectController@store');
	Route::get('/projects', 'ProjectController@index');
	Route::get('/project/{project}', 'ProjectController@show');
	Route::get('/projects/create', 'ProjectController@create');

	Route::get('/home', 'HomeController@index')->name('home');

	Route::post('/projects/{project}/task', 'TaskController@store');

});

Auth::routes();
*/


Route::group(['middleware' => 'auth'], function(){
	Route::post('/projects', 'ProjectController@store');
	Route::get('/projects', 'ProjectController@index');
	Route::get('/projects/create', 'ProjectController@create');
	Route::get('/projects/{project}', 'ProjectController@show');
	Route::patch('/projects/{project}', 'ProjectController@update');
	Route::patch('/projects/{project}/tasks/{task}', 'TaskController@update');

	Route::get('/home', 'HomeController@index')->name('home');

	Route::post('/projects/{project}/tasks', 'TaskController@store');

});

Auth::routes();




