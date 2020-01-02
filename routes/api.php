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
Route::group(['middleware' =>  'cors'], function(){
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
});
Route::group(['middleware' => 'auth:api', 'cors'], function(){
    Route::get('teacher', 'TeacherController@details');
    Route::post('teacher/groupe', 'TeacherController@groupe');
    Route::post('teacher/groupe/addNote', 'TeacherController@addNote');
});
