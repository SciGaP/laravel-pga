<?php

class AdminController extends BaseController {

    private $idStore = null;

	public function __construct()
	{
		$this->beforeFilter('verifyadmin');
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
	    $this->idStore = $idStore;
	    //Session::put("idStore", $idStore);
		Session::put("nav-active", "user-console");
	}

	public function dashboard(){
		return View::make("admin/dashboard");
	}

	public function adminView(){
		$idStore = $this->idStore;
		$roles = $idStore->getRoleNames();
		foreach ($roles as $key => $role) {
			//$gatewayAdmins = $idStore->getUserListOfRole
		}
		$gatewayProfiles = CRUtilities::getAllGatewayProfilesData();
   		return View::make("admin/manage-admin", array( "roles" => $roles, "gatewayProfiles" => $gatewayProfiles));
	}

	public function addAdminSubmit(){
		$idStore = $this->idStore;
	    $idStore->updateRoleListOfUser( Input::get("username"), array( "new"=>array("admin"), "deleted"=>array() ) );

   		return View::make("account/admin-dashboard")->with("message", "User has been added to Admin.");
	}

	public function usersView(){
		$idStore = $this->idStore;
	    $users = $idStore->listUsers();

	    return View::make("admin/manage-users", array("users" => $users));

	}

	public function addRole(){
		$idStore = $this->idStore;

		$idStore->addRole( Input::get("role") );
		return Redirect::to("manage/admins")->with("Admin has been added.");
	}

	public function addGatewayAdminSubmit(){
		$idStore = $this->idStore;
		//check if username exists
		if( $idStore->username_exists( Input::get("username")) )
		{
			//first add if this role does not exist
			$gatewayName = str_replace(" ", "_", Input::get("gateway_name"));
			$role = Constant::GATEWAY_ROLE_PREPEND . $gatewayName . Constant::GATEWAY_ROLE_ADMIN_APPEND;
			var_dump( $role); //exit;
			//$role = "gateway_default_b8a153f1-6291_admin";
			if( ! $idStore->isExistingRole( $role) )
			{
				$idStore->addRole( $role );
			}

			//add user to gateway_admin role
			$idStore->updateRoleListOfUser( Input::get("username"), array( "new"=>array( $role), "deleted"=>array() ) );

			return Redirect::to("manage/admins")->with("Gateway Admin has been added.");

		}
		else
		{
			echo ("username doesn't exist only."); exit;
		}
	}
}