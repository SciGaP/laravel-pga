<?php

class ApplicationController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('verifyadmin');
	}

	public function showAppModuleView()
	{
		$data = array();
		$data["modules"] = AppUtilities::getAllModules();
		return View::make('application/module', $data);
	}

	public function modifyAppModuleSubmit()
	{
		$update = false;
		if( Input::has("appModuleId") )
			$update = true;
			
		if( AppUtilities::create_or_update_appModule( Input::all(), $update ) )
		{
			if( $update)
				$message = "Module has been updated successfully!";
			else
				$message = "Module has been created successfully!";
		}
		else
			$message = "An error has occurred. Please report the issue.";


		return Redirect::to("app/module")->with("message", $message);
	}

	public function deleteAppModule()
	{
		if( AppUtilities::deleteAppModule( Input::get("appModuleId") ) )
			$message = "Module has been deleted successfully!";
		else
			$message = "An error has occurred. Please report the issue.";

		return Redirect::to("app/module")->with("message", $message);

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