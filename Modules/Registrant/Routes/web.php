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
    Route::get("$module_name/list_school/{name}", ['as' => "$module_name.list_school", 'uses' => "$controller_name@list_school"]);
    Route::get("verifikasi", ['as' => "$module_name.veriform", 'uses' => "$controller_name@veriform"]);
    Route::get("daftar", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("cekstatus", ['as' => "$module_name.track", 'uses' => "$controller_name@track"]);
    Route::get("summary/{combination}", ['as' => "$module_name.summary", 'uses' => "$controller_name@summary"]);
    Route::post("progress/{registrant_id}", ['as' => "$module_name.progress", 'uses' => "$controller_name@progress"]);
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
    Route::get("$module_name/list_school/{name}", ['as' => "$module_name.list_school", 'uses' => "$controller_name@list_school"]);
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/stage-index", ['as' => "$module_name.stage-index", 'uses' => "$controller_name@stageIndex"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::post("$module_name/generateId",['as' => "$module_name.generateId", 'uses' => "$controller_name@generateId"]);
    //Transactional
    Route::resource("$module_name", "$controller_name");
    Route::get("$module_name/edit-tag/{id}", ['as' => "$module_name.edit-tag", 'uses' => "$controller_name@editTag"]);
    Route::get("$module_name/edit-note/{id}", ['as' => "$module_name.edit-note", 'uses' => "$controller_name@editNote"]);
    Route::patch("$module_name/update-note/{registrant}", ['as' => "$module_name.update-note", 'uses' => "$controller_name@updateNote"]);
     /*
     *
     *  Registrant Stages Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'registrantstages';
    $controller_name = 'RegistrantStagesController';
    Route::post("$module_name/chooseInstallments",['as' => "$module_name.chooseInstallments", 'uses' => "$controller_name@chooseInstallments"]);
    Route::resource("$module_name", "$controller_name")->only([
        'store', 'update', 'destroy'
    ])->middleware(['auth', 'throttle:60,1']);

});
