<?php

class ComputeResource extends BaseController{
	
	/**
	*    Instantiate a new Compute Resource Controller Instance
	**/

	public function __construct()
	{
		$this->beforeFilter('verifyadmin');
	}

	public function createView( $stepNum){

		if( $stepNum == "step1")
		{
			return View::make("resource/create-step1");
		}

		if( $stepNum == "step2" && Session::has("step2") )
		{
			return View::make("resource/create-step2");
		}

		if( $stepNum == "step3")
		{
			return View::make("resource/create-step3");
		}
	}

	public function createSubmit(){

		if( Input::has("step1")){

			Session::put( "hostname", Input::get("hostname"));
			Session::put( "hostaliases", Input::get("hostaliases"));
			Session::put( "ips", Input::get("ips"));
			Session::put( "description", Input::get("description"));
			Session::put("step2", true);

			return Redirect::to("cr/create/step2");
		}
		elseif ( Input::has("step2")) {

			return Redirect::to("cr/create/step3");
			
		}
		elseif( Input::has("step3")){

		}
		else
			return Redirect::to("cr/create");
	}
}

?>