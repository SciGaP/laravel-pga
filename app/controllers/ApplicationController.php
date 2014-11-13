<?php

class ApplicationController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('verifyadmin');
		Session::put("nav-active", "app-catalog");
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
		//var_dump( $data["appInterfaces"][13]); exit;
		return View::make("application/interface", $data);
	}

	public function createAppInterfaceSubmit()
	{
		$appInterfaceValues = Input::all();
		//var_dump( $appInterfaceValues); exit;
		AppUtilities::create_or_update_appInterface( $appInterfaceValues);

		return Redirect::to( "app/interface")->with("message","Application Interface has been created");
	}

	public function editAppInterfaceSubmit()
	{
		if( Input::has("app-interface-id"))
		{
			$update = true;
			$appInterfaceValues = Input::all();
			//var_dump( $appInterfaceValues); exit;
			AppUtilities::create_or_update_appInterface( $appInterfaceValues, $update);
			$message = "Application Interface has been updated";
		}
		else
		{
			$message = "An error has occurred. Please report the issue.";
		}
		return Redirect::to( "app/interface")->with("message", $message);

	}

	public function deleteAppInterface()
	{
		if( AppUtilities::deleteAppInterface( Input::get("appInterfaceId") ) )
			$message = "Interface has been deleted successfully!";
		else
			$message = "An error has occurred. Please report the issue.";

		return Redirect::to("app/interface")->with("message", $message);

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