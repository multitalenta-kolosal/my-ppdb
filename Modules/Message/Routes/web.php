<?php

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

/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Message\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {

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
/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Message\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Message Template Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'messages';
    $controller_name = 'MessagesController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::resource("$module_name", "$controller_name");


     /*
     *
     *  Registrant Message Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'registrantmessages';
    $controller_name = 'RegistrantMessagesController';
    Route::resource("$module_name", "$controller_name")->only([
        'index','store', 'update', 'destroy'
    ])->middleware(['auth', 'throttle:60,1']);

});

