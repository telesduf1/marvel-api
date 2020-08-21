<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Api\v1')->group(function () {

    Route::prefix('v1/public')->group(function () {

        Route::prefix('comics')->group(function () {

            Route::get('/', 'ComicController@index');

        });

        Route::prefix('characters')->group(function () {

            Route::get('/', 'CharacterController@index');
            Route::get('/{id}', 'CharacterController@show');
            Route::get('/{character}/comics', 'CharacterController@showComics');
            Route::get('/{character}/events', 'CharacterController@showEvents');
            Route::get('/{character}/series', 'CharacterController@showSeries');
            Route::get('/{character}/stories', 'CharacterController@showStories');

        });

    });

});