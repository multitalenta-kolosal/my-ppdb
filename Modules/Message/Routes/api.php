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
Route::group(['namespace' => '\Modules\Message\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'api', 'prefix' => ''], function () {

    /*
     *
     *  Message Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'messages';
    $controller_name = 'MessagesController';    
    Route::post("webhook", ['as' => "$module_name.webhook", 'uses' => "$controller_name@messageWebhook"]);
});