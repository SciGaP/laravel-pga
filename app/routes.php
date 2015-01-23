<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


/*
 * User Routes
*/

Route::get("create", "AccountController@createAccountView");

Route::post("create", "AccountController@createAccountSubmit");

Route::get("login", "AccountController@loginView");

Route::post("login", "AccountController@loginSubmit");

Route::get("logout", "AccountController@logout");

/*
 * The following routes will not work without logging in.
 *
*/

/*
 * Project Routes
*/

Route::get("project/create", "ProjectController@createView");

Route::post("project/create", "ProjectController@createSubmit");

Route::get("project/summary", "ProjectController@summary");

Route::get("project/search", "ProjectController@searchView");

Route::post("project/search", "ProjectController@searchSubmit");

Route::get("project/edit", "ProjectController@editView");

Route::post("project/edit", "ProjectController@editSubmit");

/*
 * Experiment Routes
*/

Route::get("experiment/create", "ExperimentController@createView");

Route::post("experiment/create", "ExperimentController@createSubmit");

Route::get("experiment/summary", "ExperimentController@summary");

Route::post("experiment/summary", "ExperimentController@expChange");

Route::get("experiment/search", "ExperimentController@searchView");

Route::post("experiment/search", "ExperimentController@searchSubmit");

Route::get("experiment/edit", "ExperimentController@editView");

Route::post("experiment/edit", "ExperimentController@editSubmit");

/*
 * Compute Resources Routes
*/

Route::get("cr/create", function(){
	return Redirect::to("cr/create/step1");
});

Route::get("cr/create", "ComputeResource@createView"); 

Route::post("cr/create", "ComputeResource@createSubmit");

Route::get("cr/edit", "ComputeResource@editView"); 

Route::post("cr/edit", "ComputeResource@editSubmit"); 

Route::get("cr/browse", "ComputeResource@browseView");

Route::post("cr/delete-jsi", "ComputeResource@deleteActions");

Route::post("cr/delete-dmi", "ComputeResource@deleteActions");

Route::post("cr/delete-cr", "ComputeResource@deleteActions");

/*
 * Application Catalog Routes
*/

Route::get("app/module", "ApplicationController@showAppModuleView");

Route::post("app/module-create", "ApplicationController@modifyAppModuleSubmit");

Route::post("app/module-edit", "ApplicationController@modifyAppModuleSubmit");

Route::post("app/module-delete", "ApplicationController@deleteAppModule");

Route::get("app/interface", "ApplicationController@createAppInterfaceView");

Route::post("app/interface-create", "ApplicationController@createAppInterfaceSubmit");

Route::post("app/interface-edit", "ApplicationController@editAppInterfaceSubmit");

Route::post("app/interface-delete", "ApplicationController@deleteAppInterface");

Route::get("app/deployment", "ApplicationController@createAppDeploymentView");

Route::post("app/deployment-create", "ApplicationController@createAppDeploymentSubmit");

Route::post("app/deployment-edit", "ApplicationController@editAppDeploymentSubmit");

Route::post("app/deployment-delete", "ApplicationController@deleteAppDeployment");

Route::get("gp/create", "GatewayprofileController@createView");

Route::post("gp/create", "GatewayprofileController@createSubmit");

Route::get("gp/browse", "GatewayprofileController@browseView");

Route::get("airavata/down", function(){
	return View::make("server-down");
});
/*
 * Test Routes.
*/

Route::get("testjob", function(){
	//print_r( Session::all());
});


/*
 * Following base Routes need to be at the bottom.
*/
Route::controller("home", "HomeController");

Route::controller("/", "HomeController");
