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

		$computeDescription = array( 
									"hostName"=>Input::get("hostname"),
									"hostAliases"=>Input::get("hostaliases"),
									"ipAddresses"=>Input::get("ips"),
									"resourceDescription"=>Input::get("description") 
									);
		$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription);
		
		Session::put( "computeResource", $computeResource);
		return Redirect::to( "cr/edit");
	}

	public function editView(){
		
		$data = CRUtilities::getEditCRData();
		$computeResource = Session::get("computeResource");
		$data["computeResource"] = Utilities::get_compute_resource(  $computeResource->computeResourceId);
		//print_r( $data["computeResource"]); exit;
		return View::make("resource/edit", $data);

	}
		
	public function editSubmit(){

		if( Input::get("cr-edit") == "resDesc") /* Modify compute Resource description */
		{
			$computeDescription = Session::get("computeResource");
			$computeDescription->hostName = Input::get("hostname");
			$computeDescription->hostAliases = Input::get("hostaliases");
			$computeDescription->ipAddresses = Input::get("ips");
			$computeDescription->resourceDescription = Input::get("description") ;

			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);
			Session::put("computeResource", $computeResource);

			return Redirect::to("cr/edit");
			
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

			$computeDescription = Session::get("computeResource");
			$computeDescription->batchQueues[] = CRUtilities::createQueueObject( $queue);
			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);
			Session::put("computeResource", $computeResource);

			return Redirect::to("cr/edit");
		}
		else if( Input::get("cr-edit") == "jsp") /* Add / Modify a Job Submission Interface */
		{			//print_r( $computeDescription); exit;
			//var_dump( Input::all()); exit;
			$jobSubmissionInterface = CRUtilities::createJSIObject( Input::all() );
			print_r( $jobSubmissionInterface); exit;
		}
		else if( Input::get("cr-edit") == "dmp") /* Add / Modify a Data Movement Interface */
		{
			$dataMovementInterface = CRUtilities::createDMIObject( Input::all() );
		}
		else if( Input::get("cr-edit") == "fileSystems")
		{
			$computeDescription = Session::get("computeResource");
			$computeDescription->fileSystems = Input::get("fileSystems");
			$computeResource = CRUtilities::register_or_update_compute_resource( $computeDescription, true);
			Session::put("computeResource", $computeResource);

			return Redirect::to("cr/edit");
		}
		else
			return Redirect::to("cr/create");
	}
}

?>