<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UrlController;
use App\Url;
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

    Route::get('urls', 'UrlController@index');
    Route::post('url', 'UrlController@store');
    Route::get('url/{id}', 'UrlController@show');
    Route::put('url/{id}', 'UrlController@update');
    Route::delete('url/{id}', 'UrlController@destroy');
});

Route::post('login', 'AuthController@login')->name('login');
Route::get('logout', 'AuthController@logout');
Route::get('teste', 'UrlController@index');
// Route::get('teste/{id}', function (Request $request, $id) {
    //     $url = Url::find($id);
    //     UrlController::get_url_data($url);
    // });
// Route::get('teste', 'UrlController@get_data_from_url');