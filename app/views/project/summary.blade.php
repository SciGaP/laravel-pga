@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')

<div class="container" style="max-width: 750px;">


    <h1>Project Summary</h1>



    <?php

    $project = Utilities::get_project($_GET['projId']);



    echo '<div class="panel panel-default">';

    echo '<div class="panel-heading">';
    echo '<h3>' . $project->name . ' <a href="edit?projId=' .
                        $project->projectID .
                        '" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a></h3>';
    echo "<p>$project->description</p>";
    echo '</div>';

    $experiments = Utilities::get_experiments_in_project($project->projectID);

    echo '<div class="table-responsive">';
    echo '<table class="table">';

    echo '<tr>';

    echo '<th>Name</th>';
    echo '<th>Application</th>';
    echo '<th>Time</th>';
    echo '<th>Status</th>';

    echo '</tr>';

    foreach ($experiments as $experiment)
    {
        $experimentStatus = $experiment->experimentStatus;
        $experimentState = $experimentStatus->experimentState;
        $experimentStatusString = ExperimentState::$__names[$experimentState];
        $experimentTimeOfStateChange = date('Y-m-d H:i:s', $experimentStatus->timeOfStateChange/1000);// divide by 1000 since timeOfStateChange is in ms
        $applicationInterface = get_application_interface($experiment->applicationId);

        echo '<tr>';

        echo '<td>';


        switch ($experimentStatusString)
        {
            case 'SCHEDULED':
            case 'LAUNCHED':
            case 'EXECUTING':
            case 'CANCELING':
            case 'COMPLETED':
                echo $experiment->name;
                break;
            default:
                echo $experiment->name .
                    ' <a href="edit?expId=' .
                    $experiment->experimentID .
                    '" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>';
                break;
        }



        echo '</td>';

        echo "<td>$applicationInterface->applicationName</td>";



        echo '<td>' . $experimentTimeOfStateChange . '</td>';


        switch ($experimentStatusString)
        {
            case 'CANCELING':
            case 'CANCELED':
            case 'UNKNOWN':
                $textClass = 'text-warning';
                break;
            case 'FAILED':
                $textClass = 'text-danger';
                break;
            case 'COMPLETED':
                $textClass = 'text-success';
                break;
            default:
                $textClass = 'text-info';
                break;
        }


        echo '<td><a class="' .
            $textClass .
            '" href="experiment_summary.php?expId=' .
            $experiment->experimentID .
            '">' .
            $experimentStatusString .
            '</a></td>';

        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
    echo '</div>';

    ?>


</div>
@stop