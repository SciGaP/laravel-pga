<?php

class ApplicationController extends BaseController {

	public function createAppModuleView()
	{
		return View::make('application/module');
	}

	public function createAppModuleSubmit()
	{
		AppUtilities::create_or_update_appModule( Input::all() );
		print_r( "Application Module has been Created.");
	}

	public function createAppInterfaceView()
	{
		$data = array();
		$data = AppUtilities::getAppInterfaceData();
		return View::make("application/interface", $data);
	}

	public function createAppInterfaceSubmit()
	{
		$appInterfaceValues = Input::all();
		//var_dump( $appInterfaceValues); exit;
		AppUtilities::create_or_update_appInterface( $appInterfaceValues);
	}

	public function createAppDeploymentView()
	{
		$data = array();
		$data = AppUtilities::getAppDeploymentData();
		return View::make("application/deployment", $data);
	}

	public function createAppDeploymentSubmit()
	{
		$appDeploymentValues = Input::all();
		AppUtilities::create_or_update_appDeployment( $appDeploymentValues );
		print_r( "Object has been created");

	}


}

?>