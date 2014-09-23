<?php

Utilities::create_http_header();
Utilities::connect_to_id_store();
Utilities::verify_login();

$airavataclient = Utilities::get_airavata_client();



?>

<html>

<?php Utilities::create_html_head(); ?>

<body>

<?php Utilities::create_nav_bar(); ?>
<div class="container" style="max-width: 750px;">

	<?php if( Session::has("project_edited")) { ?>
		<div class="alert alert-success">
			The project has been edited
		</div>
		<?php Session::forget("project_edited"); 

		}
	?>


    <h1>Edit Project</h1>

    <form action="edit" method="post" role="form">
        <div class="form-group">
            <label for="project-name">Project Name</label>
            <input type="text"
                   class="form-control"
                   name="project-name"
                   id="project-name"
                   value="{{ $project->name }}">
        </div>
        <div class="form-group">
            <label for="project-description">Project Description</label>
            <textarea class="form-control"
                      name="project-description"
                      id="project-description">{{ $project->description }}
            </textarea>
            <input type="hidden" name="projectId" value="{{ Input::get('projId') }}"/>
        </div>

        <div class="btn-toolbar">
            <input name="save" type="submit" class="btn btn-primary" value="Save">
            <input name="clear" type="reset" class="btn btn-default" value="Reset values">
        </div>


    </form>


</div>
</body>
</html>