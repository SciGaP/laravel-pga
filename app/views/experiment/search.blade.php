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
<h1>Search for Experiments</h1>

<form action="{{URL::to('/')}}/experiment/search" method="post" class="form-inline" role="form">
    <div class="form-group">
        <label for="search-key">Search by</label>
        <select class="form-control" name="search-key" id="search-key">
            <?php

            // set up options for select input
            $values = array('experiment-name', 'experiment-description', 'application');
            $labels = array('Experiment Name', 'Experiment Description', 'Application');
            $disabled = array('', '', '');

            Utilities::create_options($values, $labels, $disabled);

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="search-value">for</label>
        <input type="search" class="form-control" name="search-value" id="search-value" placeholder="value" required
               value="<?php if (isset($_POST['search-value'])) echo $_POST['search-value'] ?>">
    </div>

    <button name="search" type="submit" class="btn btn-primary" value="Search"><span class="glyphicon glyphicon-search"></span> Search</button>
    <p class="help-block">You can use * as a wildcard character. Tip: search for * alone to retrieve all of your experiments.</p>
</form>




<?php

if (isset( $expContainer))
{
    if (sizeof($expContainer) == 0)
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
                <th>Application</th>
                <th>Description</th>
                <!--<th>Resource</th>-->
                <th>Creation Time</th>
                <th>Status</th>
            </tr>
    

<?php
        foreach ($expContainer as $experiment)
        {
            $description = $experiment['experiment']->description;
            if (strlen($description) > 17) // 17 is arbitrary
            {
                $description = substr($experiment['experiment']->description, 0, 17) . '<span class="text-muted">...</span>';
            }

            echo '<tr>';
            $addEditOption="";
            if( $experiment['expValue']['editable'] )
                $addEditOption = '<a href="'. URL::to('/') . '/experiment/edit?expId=' . $experiment['experiment']->experimentID . '" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>';

            echo '<td>' . $experiment['experiment']->name .  $addEditOption . '</td>';

            echo '<td>' . $experiment['expValue']['applicationInterface']->applicationName . '</td>';

            echo '<td>' . $description . '</td>';

            //echo "<td>$computeResource->hostName</td>";
            echo '<td>' . date('Y-m-d H:i:s', $experiment['experiment']->creationTime/1000) . '</td>';


            switch ($experiment['expValue']['experimentStatusString'])
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

        ?>
            <td>
                <a class="<?php echo $textClass; ?>" href="{{ URL::to('/') }}/experiment/summary?expId=<?php echo $experiment['experiment']->experimentID; ?>">
                    <?php echo $experiment['expValue']['experimentStatusString']; ?>
                </a>
            </td>

            </tr>

        <?php            
        }

        echo '
            </table>
            </div>
            ';
    }


}
?>


</div>

</body>
</html>
