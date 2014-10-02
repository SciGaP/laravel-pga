<?php

class ExperimentController extends BaseController {

	/**
	*    Instantiate a new ExperimentController Instance
	**/

	public function __construct()
	{
		$this->beforeFilter('verifylogin');
	}

	public function createView()
	{
		Session::forget( 'exp_create_continue');
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
		        Utilities::launch_experiment($expId);
            	return Redirect::to('experiment/summary?expId=' . $expId);
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

		return View::make( "experiment/summary", 
								array(
									"expId" => Input::get("expId"),
									"experiment" => $experiment,
									"project" => $project,
									"expVal" => $expVal

								)
							);
	}

	public function expChange()
	{
		$experiment = Utilities::get_experiment( Input::get('expId') );
		$project = Utilities::get_project($experiment->projectID);

		$expVal = Utilities::get_experiment_values( $experiment, $project);
		/*if (isset($_POST['save']))
		{
		    $updatedExperiment = Utilities::apply_changes_to_experiment($experiment);

		    Utilities::update_experiment($experiment->experimentID, $updatedExperiment);
		}*/
		if (isset($_POST['launch']))
		{
		    Utilities::launch_experiment($experiment->experimentID);
		}
		elseif (isset($_POST['clone']))
		{
		    $cloneId = Utilities::clone_experiment($experiment->experimentID);
		    $experiment = Utilities::get_experiment( $cloneId );
			$project = Utilities::get_project($experiment->projectID);

			$expVal = Utilities::get_experiment_values( $experiment, $project);
		    return View::make("experiment/edit", array(

							'experiment' => $experiment,
							'project' => $project,
							'expVal' => $expVal
							
							)
						);
		}
		
		elseif (isset($_POST['cancel']))
		{
		    Utilities::cancel_experiment($experiment->experimentID);
		}
	}

	public function editView()
	{
		$experiment = Utilities::get_experiment($_GET['expId']);
		$project = Utilities::get_project($experiment->projectID);

		$expVal = Utilities::get_experiment_values( $experiment, $project);


		return View::make("experiment/edit", array(

							'experiment' => $experiment,
							'project' => $project,
							'expVal' => $expVal
							
							)
						);
	}

	public function editSubmit()
	{

		if (isset($_POST['save']) || isset($_POST['launch']))
		{
	        $experiment = Utilities::get_experiment(Input::get('expId') ); // update local experiment variable
		    $updatedExperiment = Utilities::apply_changes_to_experiment($experiment, Input::all() );

		    Utilities::update_experiment($experiment->experimentID, $updatedExperiment);



		    if (isset($_POST['save']))
		    {
		        $experiment = Utilities::get_experiment(Input::get('expId') ); // update local experiment variable
		    }
		    elseif (isset($_POST['launch']))
		    {
		        Utilities::launch_experiment($experiment->experimentID);
		    }

		    $project = Utilities::get_project($experiment->projectID);

			$expVal = Utilities::get_experiment_values( $experiment, $project);


			return View::make("experiment/edit", array(

								'experiment' => $experiment,
								'project' => $project,
								'expVal' => $expVal
								
								)
							);
		}
		else
			return View::make("home");
	}

	public function searchView()
	{
		return View::make("experiment/search");
	}

	public function searchSubmit()
	{
		$expContainer = Utilities::get_expsearch_results( Input::get('search-key'), Input::get('search-value'));
		
		return View::make('experiment/search', array('expContainer' => $expContainer ));
	}

}

?>
