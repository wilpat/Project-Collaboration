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
Route::get('{any}', function () {
    return view('layouts.app');
})->where('any','.*');

// Route::get('/', 'HomeController@index');
// /*Route::group(['middleware' => 'auth'], function(){
// 	Route::post('/projects', 'ProjectController@store');
// 	Route::get('/projects', 'ProjectController@index');
// 	Route::get('/project/{project}', 'ProjectController@show');
// 	Route::get('/projects/create', 'ProjectController@create');

// 	Route::get('/home', 'HomeController@index')->name('home');

// 	Route::post('/projects/{project}/task', 'TaskController@store');

// });

// Auth::routes();
// */


// Route::group(['middleware' => 'auth'], function(){
// 	// Route::post('/projects', 'ProjectController@store');
// 	// Route::get('/projects', 'ProjectController@index');
// 	// Route::get('/projects/create', 'ProjectController@create');
// 	// Route::get('/projects/{project}', 'ProjectController@show');
// 	// Route::get('/projects/{project}/edit', 'ProjectController@edit');
// 	// Route::patch('/projects/{project}', 'ProjectController@update');
// 	// Route::delete('/projects/{project}', 'ProjectController@destroy');
// 	Route::resource('projects', 'ProjectController');

// 	Route::get('/home', 'HomeController@index')->name('home');

// 	Route::patch('/projects/{project}/tasks/{task}', 'TaskController@update');
// 	Route::post('/projects/{project}/tasks', 'TaskController@store');
// 	Route::post('/projects/{project}/invitations','InvitationController@store');

// });

// Auth::routes();




