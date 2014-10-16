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
		$computeResource = Utilities::register_or_update_compute_resource( $computeDescription);
		Session::put( "computeResource", $computeResource);
		return Redirect::to( "cr/edit");
	}

	public function editView(){
		
		$data = Utilities::getEditCRData();
		$computeResource = Session::get("computeResource");
		$data["computeResource"] = Utilities::get_compute_resource(  $computeResource->computeResourceId);
		//print_r( $data["computeResource"]); exit;
		return View::make("resource/edit", $data);

	}
		
	public function editSubmit(){

		if( Input::get("cr-edit") == "queue")
		{
			$queue = array( "queueName"=>Input::get("qname"),
							"queueDescription"=>Input::get("qdesc"),
							"maxRunTime"=>Input::get( "qmaxruntime"),
							"maxNodes"=>Input::get("qmaxnodes"),
							"maxProcessors"=>Input::get("qmaxprocessors"),
							"maxJobsInQueue"=>Input::get("qmaxjobsinqueue")
						);

			$computeDescription = Session::get("computeResource");
			$computeDescription->batchQueues[] = Utilities::createQueueObject( $queue);
			$computeResource = Utilities::register_or_update_compute_resource( $computeDescription, true);
			Session::put("computeResource", $computeResource);

			return Redirect::to("cr/edit");
		}
		else if( Input::get("cr-edit") == "jsp")
		{
			$computeDescription = Session::get("computeResource");
			//print_r( $computeDescription); exit;
			//var_dump( Input::all()); exit;
			$jobSubmissionInterface = Utilities::createJSIObject( Input::all() );
			//print_r( $jobSubmissionInterface); exit;
		}
		else
			return Redirect::to("cr/create");
	}
}

?>