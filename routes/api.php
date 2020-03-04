<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::post('refresh', 'AuthController@refresh')->name('refresh');
    Route::post('register', 'AuthController@register')->name('register');
    Route::post('me', 'AuthController@me');

});

Route::group(['middleware' => 'jwt.auth'], function(){
	Route::resource('projects', 'ProjectController');

	Route::get('/home', 'HomeController@index')->name('home');

	Route::patch('/projects/{project}/tasks/{task}', 'TaskController@update');
	Route::post('/projects/{project}/tasks', 'TaskController@store');
	Route::post('/projects/{project}/invitations','InvitationController@store');

});

// Auth::routes();