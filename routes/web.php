<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    return response()->json(['message' => 'API Laravel', 'status' => 'Connected!!']);
});

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::post('login', 'AuthController@login')->name('login');
Route::get('logout', 'AuthController@logout');


Route::get('teste', function (Request $request, Response $response) {
    return response()->json(['message' => 'API Laravel', 'status' => 'Connected!!']);
});
