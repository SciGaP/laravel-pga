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

	public function createAppDeploymentView()
	{
		$data = array();
		$data = AppUtilities::getAppDeploymentData();
		return View::make("application/deployment", $data);
	}

}

?>