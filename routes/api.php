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

Route::group([

    'middleware' => 'api',
   

], function ($router) {
    //user
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user', 'AuthController@user');
    Route::post('create', 'AuthController@CreateUser');
    Route::get('send', 'AuthController@send');
    Route::post('sendPasswordReset', 'ResetPasswordController@sendEmail');
    Route::post('responsepasswordreset', 'ChangePasswordController@process');
    //event
    Route::post('event', 'EventsController@CreateEvent');
    Route::delete('eventdelete/{id}', 'EventsController@DeleteEvent');
    Route::get('eventfind/{id}', 'EventsController@FindEvent');
    Route::get('eventall', 'EventsController@AllEvent');

    //new 
    Route::post('new', 'NewsController@CreateNew');
    Route::delete('newdelete/{id}', 'NewsController@DeleteNew');
    Route::get('newfind/{id}', 'NewsController@FindNew');
    Route::get('newall', 'NewsController@AllNew');
    Route::put('newupdate/{id}', 'NewsController@UpdateNew');








   
});