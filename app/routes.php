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

Route::get("project/create", "ProjectController@createView");

Route::post("project/create", "ProjectController@createSubmit");

Route::get("project/summary", "ProjectController@summary");

Route::get("project/search", "ProjectController@searchView");

Route::post("project/search", "ProjectController@searchSubmit");

Route::get("project/edit", "ProjectController@editView");

Route::post("project/edit", "ProjectController@editSubmit");

Route::get("experiment/create", "ExperimentController@createView");

Route::post("experiment/create", "ExperimentController@createSubmit");

Route::get("experiment/summary", "ExperimentController@summary");

Route::post("experiment/summary", "ExperimentController@expChange");

Route::get("experiment/search", "ExperimentController@searchView");

Route::post("experiment/search", "ExperimentController@searchSubmit");

Route::get("experiment/edit", "ExperimentController@editView");

Route::post("experiment/edit", "ExperimentController@editSubmit");

Route::controller("home", "HomeController");

Route::controller("/", "HomeController");
