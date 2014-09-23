<?php

class ExperimentController extends BaseController {

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
		Session::forget( 'exp_create_Fcontinue');
		return View::make('experiment/create');
	}

	public function createSubmit()
	{
		if( isset( $_POST['continue'] ))
		{
			Session::put( 'exp_create_continue', true);
			return View::make( "experiment/create", array( 
								"disabled" => ' disabled',
						        "experimentName" => $_POST['experiment-name'],
						        "experimentDescription" => $_POST['experiment-description'] . ' ',
						        "project" => $_POST['project'],
						        "application" => $_POST['application'],
						        // ugly hack until app catalog is in place
						        "echo" => ($_POST['application'] == 'Echo')? ' selected' : '',
						        "wrf" => ($_POST['application'] == 'WRF')? ' selected' : ''

					        )
						);
		}

		else if (isset($_POST['save']) || isset($_POST['launch']))
		{
		    $expId = Utilities::create_experiment();

		    if (isset($_POST['launch']) && $expId)
		    {
		        launch_experiment($expId);
		    }
		    else
		    {
		        Utilities::print_success_message("<p>Experiment {$_POST['experiment-name']} created!</p>" .
		            '<p>You will be redirected to the summary page shortly, or you can
		            <a href=' . URL::to('/') . '"/experiment/summary?expId=' . $expId . '">go directly</a> to experiment summary page.</p>');
            	return Redirect::to('experiment/summary?expId=' . $expId);
		        
		    }
		}
		else
			return Redirect::to("home");
	}

	public function summary()
	{

		$experiment = Utilities::get_experiment($_GET['expId']);
		$project = Utilities::get_project($experiment->projectID);

		$expVal = Utilities::get_experiment_values( $experiment, $project);

		if (isset($_POST['save']))
		{
		    $updatedExperiment = apply_changes_to_experiment($experiment);

		    update_experiment($experiment->experimentID, $updatedExperiment);
		}
		elseif (isset($_POST['launch']))
		{
		    launch_experiment($experiment->experimentID);
		}
		elseif (isset($_POST['clone']))
		{
		    clone_experiment($experiment->experimentID);
		}
		elseif (isset($_POST['cancel']))
		{
		    cancel_experiment($experiment->experimentID);
		}

		return View::make( "experiment/summary", 
								array(
									"expId" => Input::get("expId"),
									"experiment" => $experiment,
									"project" => $project,
									"expVal" => $expVal

								)
							);
	}

}

?>
