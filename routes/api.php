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

Route::group(['prefix' => 'v1', 'middleware' => 'jwt'], function () {
    Route::get('movies', 'MoviesController@get');
    Route::get('movies/{id}/show', 'MoviesController@show');
    Route::post('movies/save', 'MoviesController@save');
    Route::post('movies/{id}/edit', 'MoviesController@edit');
    Route::delete('movies/{id}/delete', 'MoviesController@delete');
});

Route::group([
    'prefix' => 'v1/auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
});