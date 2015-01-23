<?php

class GatewayprofileController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('verifyadmin');
		Session::put("nav-active", "app-catalog");
	}

	public function createView()
	{
		return View::make("gateway/create");
	}

	public function createSubmit()
	{
		$gatewayProfileId = CRUtilities::create_or_update_gateway_profile( Input::all() );
		return Redirect::to("gp/browse")->with("gpId", $gatewayProfileId);
	}

	public function browseView()
	{
		$crObjects = CRUtilities::getAllCRObjects();
		$crData = CRUtilities::getEditCRData();
		//var_dump( $crObjects[0]); exit;
		return View::make("gateway/browse", array(	"gatewayProfiles" => CRUtilities::getAllGatewayProfilesData(),
													"computeResources" => CRUtilities::getAllCRObjects(),
													"crData" => CRUtilities::getEditCRData()
												));
	}

	public function modifyCRP()
	{
		if( CRUtilities::add_or_update_CRP( Input::all()) )
		{
			return Redirect::to("gp/browse")->with("message","Compute Resource Preference for the desired Gateway has been set.");
		}
	}

}

?>