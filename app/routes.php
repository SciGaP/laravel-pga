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

Route::get("create", "AccountController@createAccountView");

Route::post("create", "AccountController@createAccountSubmit");

Route::get("login", "AccountController@loginView");

Route::post("login", "AccountController@loginSubmit");

Route::get("logout", "AccountController@logout");

/*
 * The following routes will not work without logging in.
 *
*/

Route::get("project/create", 
	array("before"=>"verifylogin","uses"=>"ProjectController@createView") );

Route::post("project/create", 
	array("before"=>"verifylogin","uses"=>"ProjectController@createSubmit") );

Route::get("project/summary", 
	array("before"=>"verifylogin","uses"=>"ProjectController@summary") );

Route::get("project/search", 
	array("before"=>"verifylogin","uses"=>"ProjectController@searchView") );

Route::post("project/search", 
	array("before"=>"verifylogin","uses"=>"ProjectController@searchSubmit") );

Route::get("project/edit", 
	array("before"=>"verifylogin","uses"=>"ProjectController@editView") );

Route::post("project/edit", 
	array("before"=>"verifylogin","uses"=>"ProjectController@editSubmit") );

Route::get("experiment/create", 
	array("before"=>"verifylogin","uses"=>"ExperimentController@createView") );

Route::post("experiment/create", 
	array("before"=>"verifylogin","uses"=>"ExperimentController@createSubmit") );

Route::get("experiment/summary", 
	array("before"=>"verifylogin","uses"=>"ExperimentController@summary") );

Route::post("experiment/summary", 
	array("before"=>"verifylogin","uses"=>"ExperimentController@expChange") );

Route::get("experiment/search", 
	array("before"=>"verifylogin","uses"=>"ExperimentController@searchView") );

Route::post("experiment/search", 
	array("before"=>"verifylogin","uses"=>"ExperimentController@searchSubmit") );

Route::get("experiment/edit", 
	array("before"=>"verifylogin","uses"=>"ExperimentController@editView") );

Route::post("experiment/edit", 
	array("before"=>"verifylogin","uses"=>"ExperimentController@editSubmit") );
Route::get("testjob", function(){
	print_r( Session::all());
});


/*
 * Following base Routes need to be at the last.
*/
Route::controller("home", "HomeController");

Route::controller("/", "HomeController");
