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
									"hostName"=> trim( Input::get("hostname") ),
									"hostAliases"=> array_unique( array_filter( $hostAliases) ),
									"ipAddresses"=> array_unique( array_filter( $ips) ),
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
			$addedJSP = array();
			$addedDMI = array();
			//var_dump( $computeResource->jobSubmissionInterfaces); exit;
			if( count( $computeResource->jobSubmissionInterfaces) )
			{
				foreach( $computeResource->jobSubmissionInterfaces as $JSI )
				{
					$jobSubmissionInterfaces[] = CRUtilities::getJobSubmissionDetails( $JSI->jobSubmissionInterfaceId, $JSI->jobSubmissionProtocol);
					$addedJSP[] = $JSI->jobSubmissionProtocol;
				}
			}
			//var_dump( CRUtilities::getJobSubmissionDetails( $data["computeResource"]->jobSubmissionInterfaces[0]->jobSubmissionInterfaceId, 1) ); exit;
			if( count( $computeResource->dataMovementInterfaces) )
			{
				foreach( $computeResource->dataMovementInterfaces as $DMI )
				{
					$dataMovementInterfaces[] = CRUtilities::getDataMovementDetails( $DMI->dataMovementInterfaceId, $DMI->dataMovementProtocol);
					$addedDMI[] = $DMI->dataMovementProtocol;
				}
			}
			$data["computeResource"] = $computeResource;
			$data["jobSubmissionInterfaces"] = $jobSubmissionInterfaces;
			$data["dataMovementInterfaces"] = $dataMovementInterfaces;
			$data["addedJSP"] = $addedJSP;
			$data["addedDMI"] = $addedDMI;

			return View::make("resource/edit", $data);
		}
		else
			return View::make("resource/browse")->with("login-alert", "Unable to retrieve this Compute Resource. Please report this error to devs.");

	}
		
	public function editSubmit(){

		$tabName = "";
		if( Input::get("cr-edit") == "resDesc") /* Modify compute Resource description */
		{
			$computeDescription = Utilities::get_compute_resource(  Input::get("crId"));
			$computeDescription->hostName = trim( Input::get("hostname") );
			$computeDescription->hostAliases = array_unique( array_filter( Input::get("hostaliases") ) );
			$computeDescription->ipAddresses = array_unique( array_filter( Input::get("ips") ) );
			$computeDescription->resourceDescription = Input::get("description") ;
			//var_dump( $computeDescription); exit;

			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);

			$tabName =  "#tab-desc";
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

			$tabName = "#tab-queues";
		}
		else if( Input::get("cr-edit") == "delete-queue" )
		{
			CRUtilities::deleteQueue( Input::get("crId"), Input::get("queueName") );
			$tabName = "#tab-queues";
		} 
		else if( Input::get("cr-edit") == "fileSystems")
		{
			$computeDescription = Utilities::get_compute_resource(  Input::get("crId"));
			$computeDescription->fileSystems = array_filter( Input::get("fileSystems"), "trim");
			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);

			$tabName = "#tab-filesystem";
		}
		else if( Input::get("cr-edit") == "jsp" ||  Input::get("cr-edit") == "edit-jsp" ) /* Add / Modify a Job Submission Interface */
		{		
			$update = false;	
			if( Input::get("cr-edit") == "edit-jsp")
				$update = true;

			$jobSubmissionInterface = CRUtilities::create_or_update_JSIObject( Input::all(), $update );

			$tabName = "#tab-jobSubmission";
		}
		else if( Input::get("cr-edit") == "jsi-priority") 
		{
			$inputs = Input::all();
			$computeDescription = Utilities::get_compute_resource(  Input::get("crId"));
			foreach( $computeDescription->jobSubmissionInterfaces as $index => $jsi)
			{
				foreach( $inputs["jsi-id"] as $idIndex => $jsiId)
				{
					if( $jsiId == $jsi->jobSubmissionInterfaceId )
					{
						$computeDescription->jobSubmissionInterfaces[$index]->priorityOrder = $inputs["jsi-priority"][$idIndex];
						break;
					}
				}
			}
			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);

			return 1; //currently done by ajax.
		}
		else if( Input::get("cr-edit") == "dmp" ||  Input::get("cr-edit") == "edit-dmi" ) /* Add / Modify a Data Movement Interface */
		{
			$update = false;	
			if( Input::get("cr-edit") == "edit-dmi")
				$update = true;
			$dataMovementInterface = CRUtilities::create_or_update_DMIObject( Input::all(), $update );

			$tabName = "#tab-dataMovement";
		}
		else if( Input::get("cr-edit") == "dmi-priority") 
		{
			$inputs = Input::all();
			$computeDescription = Utilities::get_compute_resource(  Input::get("crId"));
			foreach( $computeDescription->dataMovementInterfaces as $index => $dmi)
			{
				foreach( $inputs["dmi-id"] as $idIndex => $dmiId)
				{
					if( $dmiId == $dmi->dataMovementInterfaceId )
					{
						$computeDescription->dataMovementInterfaces[$index]->priorityOrder = $inputs["dmi-priority"][$idIndex];
						break;
					}
				}
			}
			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);

			return 1; //currently done by ajax.
		}

		return Redirect::to("cr/edit?crId=" . Input::get("crId") . $tabName );
	}

	public function deleteActions(){
		return CRUtilities::deleteActions( Input::all() );

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