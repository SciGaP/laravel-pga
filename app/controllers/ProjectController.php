<?php

class ProjectController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function createView()
	{
		return View::make("project/create");
	}

	public function createSubmit()
	{
		if (isset($_POST['save']))
		{
			$projectId = Utilities::create_project();
            return Redirect::to('project/summary?projId=' . $projectId);
		}
		else
		{
			return Redirect::to('project/create');
		}
	}

	public function summary()
	{
		if( Input::has("projId"))
		{
			Session::put("projId", Input::get("projId"));
			return View::make("project/summary", 
					array( "projectId" => Input::get("projId")) );
		}
		else
			return Redirect::to("home");
	}

	public function editView()
	{
		if( Input::has("projId"))
		{
			return View::make("project/edit", 
					array( "projectId" => Input::get("projId"),
							"project" => Utilities::get_project($_GET['projId']) 
						 ) );
		}
		else
			return Redirect::to("home");
	}

	public function editSubmit()
	{
		if (isset($_POST['save']))
	    {
	    	$projectDetails["owner"] = Session::get("username");
	    	$projectDetails["name"] = Input::get("project-name");
	    	$projectDetails["description"] = Input::get("project-description");

	        Utilities::update_project( Input::get("projectId"), $projectDetails);

	        return Redirect::to("project/edit?projId=" . Input::get("projectId") )->with("project_edited", true);
	    }
	}

}

?>
