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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'ApiAuthController@register');
Route::post('/login', 'ApiAuthController@login');
Route::post('/logout', 'ApiAuthController@logout');


Route::post('check_key','SendController@checkUserKey');

Route::post('set_key','SettingsController@setApiKey');

Route::get('get_rates','CurrencyController@getPairs');
