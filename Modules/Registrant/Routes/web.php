<?php

/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Registrant\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {

    /*
     *
     *  Registrants Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'registrants';
    $controller_name = 'RegistrantsController';    
    Route::get("daftar", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::resource("$module_name", "$controller_name")->only([
        'store', 'update'
    ])->middleware(['throttle:10,1']);
});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Registrant\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth','can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Registrants Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'registrants';
    $controller_name = 'RegistrantsController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::post("$module_name/generateId",['as' => "$module_name.generateId", 'uses' => "$controller_name@generateId"]);
    Route::resource("$module_name", "$controller_name");

     /*
     *
     *  Registrant Stages Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'registrantStages';
    $controller_name = 'RegistrantStagesController';
    Route::resource("$module_name", "$controller_name")->only([
        'store', 'update', 'destroy'
    ])->middleware(['auth', 'throttle:60,1']);

});
