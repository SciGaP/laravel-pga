<?php

class AdminController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('verifyadmin');
		Session::put("nav-active", "user-console");
	}

	public function dashboard(){
		return View::make("admin/dashboard");
	}

	public function adminView(){
   		return View::make("admin/manage-admin");
	}

	public function addAdminSubmit(){

		$idStore = new WSISUtilities();

        try
	    {
	        $idStore->connect();
	    }
	    catch (Exception $e)
	    {
	        Utilities::print_error_message('<p>Error connecting to ID store.
	            Please try again later or report a bug using the link in the Help menu</p>' .
	            '<p>' . $e->getMessage() . '</p>');
	    }
	    $idStore->updateRoleListOfUser( Input::get("username"), array( "new"=>array("admin"), "deleted"=>array() ) );

   		return View::make("account/admin-dashboard")->with("message", "User has been added to Admin.");
	}

	public function usersView(){
		$idStore = new WSISUtilities();

        try
	    {
	        $idStore->connect();
	    }
	    catch (Exception $e)
	    {
	        Utilities::print_error_message('<p>Error connecting to ID store.
	            Please try again later or report a bug using the link in the Help menu</p>' .
	            '<p>' . $e->getMessage() . '</p>');
	    }
	    $users = $idStore->listUsers();

	    return View::make("admin/manage-users", array("users" => $users));

	}
}