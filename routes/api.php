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
//

// public for all


Route::post("user/register" , "Auth\AuthenticateController@register");
Route::post("user/auth" , "Auth\AuthenticateController@authenticate");


// for auth users
Route::group(['middleware' => ['jwt.auth']], function() {

    Route::Resource('codegenerator','Codegenerator\CodeGenerator');

});


