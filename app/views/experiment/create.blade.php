@extends('layout.basic')

@section('page-header')
    @parent
@stop

@section('content')
<div class="col-md-offset-3 col-md-6">
    
<h1>Create a new experiment</h1>

<form action="create" method="post" role="form" enctype="multipart/form-data">

    <?php

    if (Session::has( 'exp_create_continue'))
    {
        

        echo '<input type="hidden" name="experiment-name" value="' . $experimentName . '">';
        echo '<input type="hidden" name="experiment-description" value="' . $experimentDescription . '">';
        echo '<input type="hidden" name="project" value="' . $project . '">';
        echo '<input type="hidden" name="application" value="' . $application . '">';
    }
    else
    {
        $disabled = '';
        $experimentName = '';
        $experimentDescription = '';
        $project = '';
        $application = '';

        $echo = '';
        $wrf = '';
    }
    ?>

    <div class="form-group required">
        <label for="experiment-name" class="control-label">Experiment Name</label>
        <input type="text" class="form-control" name="experiment-name" id="experiment-name" placeholder="Enter experiment name" autofocus required="required" {{ $disabled }} value="{{ $experimentName }}">
    </div>
    <div class="form-group">
        <label for="experiment-description">Experiment Description</label>
        <textarea class="form-control" name="experiment-description" id="experiment-description" placeholder="Optional: Enter a short description of the experiment" {{ $disabled }}>{{ $experimentDescription }}</textarea>
    </div>
    <div class="form-group required">
        <label for="project" class="control-label">Project</label>


    {{ Utilities::create_project_select($project, !$disabled) }}

    </div>
        <div class="form-group">
        <label for="application">Application</label>

        {{ Utilities::create_application_select($application, !$disabled) }}

    </div>


    <?php
    if (! Session::has( 'exp_create_continue'))
    {
        echo '<div class="btn-toolbar">
        <input name="continue" type="submit" class="btn btn-primary" value="Continue">
        <input name="clear" type="reset" class="btn btn-default" value="Reset values">
        </div>
        ';
    }
    else
    {
        echo '<div class="panel panel-default">
        <div class="panel-heading">Application configuration</div>
        <div class="panel-body">
        <label>Application input</label>
        <div class="well">
        ';



        Utilities::create_inputs($application, true);


        echo '</div>
            <div class="form-group">
                <label for="compute-resource">Compute Resource</label>';

        Utilities::create_compute_resources_select($application, null);

        echo '
            </div>
            <div class="form-group">
                <label for="node-count">Node Count</label>
                <input type="number" class="form-control" name="node-count" id="node-count" value="1" min="1">
            </div>
            <div class="form-group">
                <label for="cpu-count">Total Core Count</label>
                <input type="number" class="form-control" name="cpu-count" id="cpu-count" value="4" min="1">
            </div>
            <!--
            <div class="form-group">
                <label for="threads">Number of Threads</label>
                <input type="number" class="form-control" name="threads" id="threads" value="0" min="0">
            </div>
            -->
            <div class="form-group">
                <label for="wall-time">Wall Time Limit</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="wall-time" id="wall-time" value="30" min="0">
                    <span class="input-group-addon">minutes</span>
                </div>
            </div>
            <!--
            <div class="form-group">
                <label for="memory">Total Physical Memory</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="memory" id="memory" value="0" min="0">
                    <span class="input-group-addon">kB</span>
                </div>
            </div>
            -->


            </div>
            </div>

            <!-- use <button> instead of <input> in order to match height of <a> in Firefox -->
            <div class="btn-toolbar">
                <div class="btn-group">
                    <button name="save" type="submit" class="btn btn-primary" value="Save">Save</button>
                    <button name="launch" type="submit" class="btn btn-success" value="Save and launch">Save and launch</button>
                </div>
                
                <a href="' . URL::to('/') . '/experiment/create" class="btn btn-default" role="button">Start over</a>
        </div>';
    }

    ?>
    
</form>

</div>

@stop