<?php

class ComputeResource extends BaseController{
	
	/**
	*    Instantiate a new Compute Resource Controller Instance
	**/

	public function __construct()
	{
		$this->beforeFilter('verifyadmin');
	}

	public function createView(){
			return View::make("resource/create");
	}

	public function createSubmit(){

		$hostAliases = Input::get("hostaliases");
		$ips = Input::get("ips");
		$computeDescription = array( 
									"hostName"=>Input::get("hostname"),
									"hostAliases"=> array_unique( $hostAliases ),
									"ipAddresses"=> array_unique( $ips),
									"resourceDescription"=>Input::get("description") 
									);
		$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription);
		
		return Redirect::to( "cr/edit?crId=" . $computeResource->computeResourceId);
	}

	public function editView(){
		
		$data = CRUtilities::getEditCRData();
		$computeResourceId = "";
		if( Input::has("crId"))
			$computeResourceId = Input::get("crId");
		else if( Session::has("computeResource"))
		{
			$computeResource = Session::get("computeResource");
			$computeResourceId = $computeResource->computeResourceId;
		}

		if( $computeResourceId != "")
		{
			$computeResource = Utilities::get_compute_resource(  $computeResourceId);
			$jobSubmissionInterfaces = array();
			$dataMovementInterfaces = array();
			//var_dump( $data["computeResource"]->jobSubmissionInterfaces[0]); exit;
			if( count( $computeResource->jobSubmissionInterfaces) )
			{
				foreach( $computeResource->jobSubmissionInterfaces as $JSI )
				{
					$jobSubmissionInterfaces[] = CRUtilities::getJobSubmissionDetails( $JSI->jobSubmissionInterfaceId, $JSI->jobSubmissionProtocol);
				}
			}
			//var_dump( CRUtilities::getJobSubmissionDetails( $data["computeResource"]->jobSubmissionInterfaces[0]->jobSubmissionInterfaceId, 1) ); exit;
			if( count( $computeResource->dataMovementInterfaces) )
			{
				foreach( $computeResource->dataMovementInterfaces as $DMI )
				{
					$dataMovementInterfaces[] = CRUtilities::getDataMovementDetails( $DMI->dataMovementInterfaceId, $DMI->dataMovementProtocol);
				}
				var_dump( $dataMovementInterfaces); exit;
			}
			$data["computeResource"] = $computeResource;
			$data["jobSubmissionInterfaces"] = $jobSubmissionInterfaces;
			$data["dataMovementInterfaces"] = $dataMovementInterfaces;
		}
		else
			return View::make("resource/browse")->with("login-alert", "Unable to retrieve this Compute Resource. Please report this error to devs.");

	}
		
	public function editSubmit(){

		if( Input::get("cr-edit") == "resDesc") /* Modify compute Resource description */
		{
			$computeDescription = Utilities::get_compute_resource(  Input::get("crId"));
			$computeDescription->hostName = Input::get("hostname");
			$computeDescription->hostAliases = array_unique( Input::get("hostaliases") );
			$computeDescription->ipAddresses = array_unique( Input::get("ips") );
			$computeDescription->resourceDescription = Input::get("description") ;

			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);
			Session::put("computeResource", $computeResource);			
		}
		if( Input::get("cr-edit") == "queue") /* Add / Modify a Queue */
		{
			$queue = array( "queueName"=>Input::get("qname"),
							"queueDescription"=>Input::get("qdesc"),
							"maxRunTime"=>Input::get( "qmaxruntime"),
							"maxNodes"=>Input::get("qmaxnodes"),
							"maxProcessors"=>Input::get("qmaxprocessors"),
							"maxJobsInQueue"=>Input::get("qmaxjobsinqueue")
						);

			$computeDescription = Utilities::get_compute_resource(  Input::get("crId"));
			$computeDescription->batchQueues[] = CRUtilities::createQueueObject( $queue);
			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);
			Session::put("computeResource", $computeResource);
		}
		else if( Input::get("cr-edit") == "jsp") /* Add / Modify a Job Submission Interface */
		{			
			$jobSubmissionInterface = CRUtilities::createJSIObject( Input::all() );
		}
		else if( Input::get("cr-edit") == "dmp") /* Add / Modify a Data Movement Interface */
		{
			$dataMovementInterface = CRUtilities::createDMIObject( Input::all() );
		}
		else if( Input::get("cr-edit") == "fileSystems")
		{
			$computeDescription = Utilities::get_compute_resource(  Input::get("crId"));
			$computeDescription->fileSystems = Input::get("fileSystems");
			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);
			Session::put("computeResource", $computeResource);
		}
		return Redirect::to("cr/edit?crId=" . Input::get("crId") );
	}

	public function browseView(){
		$allCRs = CRUtilities::getAllCRObjects();
		/*
		if( count( $allCRs)>0 )
		{
			foreach( $allCRs as $crId => $crName)
			{
				//
			}
		}
		*/

		return View::make("resource/browse", array("allCRs" => $allCRs));

	}
}

?>