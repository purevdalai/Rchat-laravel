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

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/employee', 'UserController@index');
    Route::get('/article', 'NewsController@index');
    Route::post('/article', 'NewsController@store');
    Route::get('/article/{id}/show', 'NewsController@show');

    Route::get('/poll', 'PollController@index');
    Route::get('/poll/{id}/show', 'PollController@show');
    Route::post('/poll', 'PollController@store');
    Route::post('/vote', 'PollController@vote_store');

    Route::get('/room', 'RoomController@index');
});
