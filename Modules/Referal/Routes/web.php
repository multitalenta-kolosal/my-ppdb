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
Route::group(['namespace' => '\Modules\Referal\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {

    /*
     *
     *  Referals Routes
     *
     * ---------------------------------------------------------------------
     */
    /*
     *
     *   referees Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'referees';
    $controller_name = 'RefereesController';    
    Route::get("ypwreferal", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    // Route::get("reftrack", ['as' => "$module_name.reftrack", 'uses' => "$controller_name@reftrack"]);
    Route::post("refarea", ['as' => "$module_name.refarea", 'uses' => "$controller_name@refarea"]);
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
Route::group(['namespace' => '\Modules\Referal\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Referees Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'referees';
    $controller_name = 'RefereesController';    
    Route::get("$module_name/printreportall", ['as' => "$module_name.printreportall", 'uses' => "$controller_name@printReportAll"]);
    Route::get("$module_name/printreport/{id}", ['as' => "$module_name.printreport", 'uses' => "$controller_name@printReport"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::resource("$module_name", "$controller_name");


});
