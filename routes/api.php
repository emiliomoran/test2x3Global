<?php

use App\Client;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Client api routers */
Route::get('clients', 'Api\ClientController@index');

/* Payment api routers */
Route::get('payments', 'Api\PaymentController@index');
Route::post('payments', 'Api\PaymentController@store');
Route::post('pay', 'Api\PaymentController@pay');
