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
Route::group(['namespace' => '\Modules\Core\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {

    /*
     *
     *  Cores Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'units';
    $controller_name = 'UnitsController';    
    Route::get("getunitopt/{id}", 
        ['as' => "$module_name.getunitopt", 'uses' => "$controller_name@getUnitOpt"])->middleware(['throttle:30,1']);
    Route::get("getunitfee/{path_id}/{unit_id}/{tier_id}", 
        ['as' => "$module_name.getunitfee", 'uses' => "$controller_name@getunitfee"])->middleware(['throttle:30,1']);
   
});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Core\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Units Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'units';
    $controller_name = 'UnitsController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::resource("$module_name", "$controller_name");

    /*
     *
     *  Tiers Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'tiers';
    $controller_name = 'TiersController';
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::delete("$module_name/purgeAll", ['as' => "$module_name.purgeAll", 'uses' => "$controller_name@purgeAll"]);
    Route::resource("$module_name", "$controller_name");

    /*
     *
     *  Periods Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'periods';
    $controller_name = 'PeriodsController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::get("$module_name/changeperiod", ['as' => "$module_name.changeSessionPeriod", 'uses' => "$controller_name@changeSessionPeriod"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::delete("$module_name/purge/{id}", ['as' => "$module_name.purge", 'uses' => "$controller_name@purge"]);
    Route::resource("$module_name", "$controller_name");

    /*
     *
     *  Paths Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'paths';
    $controller_name = 'PathsController';
    Route::resource("$module_name", "$controller_name");

});
