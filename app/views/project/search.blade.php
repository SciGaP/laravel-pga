<?php

Utilities::create_http_header();

Utilities::connect_to_id_store();
Utilities::verify_login();


?>

<html>

<?php Utilities::create_html_head(); ?>

<body>

<?php Utilities::create_nav_bar(); ?>

    <div class="container" style="max-width: 750px;">

        <h1>Search for Projects</h1>

        <form action="{{ URL::to('/') }}/project/search" method="post" class="form-inline" role="form">
            <div class="form-group">
                <label for="search-key">Search by</label>
                <select class="form-control" name="search-key" id="search-key">
                    <option value="project-name">Project Name</option>
                    <option value="project-description">Project description</option>
                </select>
            </div>

            <div class="form-group">
                <label for="search-value">for</label>
                <input type="search" class="form-control" name="search-value" id="search-value" placeholder="value" required
                       value="<?php if (isset($_POST['search-value'])) echo $_POST['search-value'] ?>">
            </div>

            <button name="search" type="submit" class="btn btn-primary" value="Search"><span class="glyphicon glyphicon-search"></span> Search</button>
                <p class="help-block">You can use * as a wildcard character. Tip: search for * alone to retrieve all of your projects.</p>
        </form>





        <?php

        if (isset( $projects))
        {
            /**
             * get results
             */

            /**
             * display results
             */
            if (sizeof($projects) == 0)
            {
                Utilities::print_warning_message('No results found. Please try again.');
            }
            else
            {
            ?>
                <div class="table-responsive">
                    <table class="table">

                        <tr>

                            <th>Name</th>
                            <th>Creation Time</th>
                            <th>Experiments</th>

                        </tr>
            <?php

                foreach ($projects as $project)
                {

            ?>
                    <tr>
                        <td>
                            <?php echo $project->name; ?>
                            <a href="{{URL::to('/')}}/project/edit?projId=<?php echo $project->projectID; ?>" title="Edit">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </td>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $project->creationTime/1000); ?>
                        </td>
                        <td>
                            <a href="{{URL::to('/')}}/project/summary?projId=<?php echo $project->projectID; ?>">
                                <span class="glyphicon glyphicon-list"></span>
                            </a>
                            <a href="{{URL::to('/')}}/project/summary?projId=<?php echo $project->projectID; ?>"> View</a>
                        </td>
                    </tr>
            <?php

                }

                echo '</table>';
                echo '</div>';
            }

        }


        //$transport->close();

        ?>


    </div>

</body>
</html>



















<?php
/**
 * Utility Functions
 */


/**
 * Create options for the search key select input
 * @param $values
 * @param $labels
 * @param $disabled
 */
function create_options($values, $labels, $disabled)
{
    for ($i = 0; $i < sizeof($values); $i++)
    {
        $selected = '';

        // if option was previously selected, mark it as selected
        if (isset($_POST['search-key']))
        {
            if ($values[$i] == $_POST['search-key'])
            {
                $selected = 'selected';
            }
        }

        echo '<option value="' . $values[$i] . '" ' . $disabled[$i] . ' ' . $selected . '>' . $labels[$i] . '</option>';
    }
}

/**
 * Get results of the user's search
 * @return array|null
 */





/**
 * Get experiments in project
 * @param $projectId
 * @return array|null
 */
function get_experiments_in_project($projectId)
{
    global $airavataclient;

    $experiments = array();

    try
    {
        $experiments = $airavataclient->getAllExperimentsInProject($projectId);
    }
    catch (InvalidRequestException $ire)
    {
        print_error_message('InvalidRequestException!<br><br>' . $ire->getMessage());
    }
    catch (AiravataClientException $ace)
    {
        print_error_message('AiravataClientException!<br><br>' . $ace->getMessage());
    }
    catch (AiravataSystemException $ase)
    {
        print_error_message('AiravataSystemException!<br><br>' . $ase->getMessage());
    }
    catch (TTransportException $tte)
    {
        print_error_message('TTransportException!<br><br>' . $tte->getMessage());
    }

    return $experiments;
}

unset($_POST);
