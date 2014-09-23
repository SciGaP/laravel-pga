<?php

Utilities::create_http_header();

Utilities::connect_to_id_store();
Utilities::verify_login();


?>

<html>

<?php Utilities::create_html_head(); ?>

<body>

<?php Utilities::create_nav_bar(); ?>

<div class="container" style="max-width: 750px">
    
<h1>Create a new project</h1>


<form action="create" method="post" role="form">
    <div class="form-group">
        <label for="project-name">Project Name</label>
        <input type="text" class="form-control" name="project-name" id="project-name" placeholder="Enter project name" autofocus required>
    </div>

    <div class="form-group">
        <label for="project-description">Project Description</label>
        <textarea class="form-control" name="project-description" id="project-description" placeholder="Optional: Enter a short description of the project"></textarea>
    </div>

    <input name="save" type="submit" class="btn btn-primary" value="Save">
    <input name="clear" type="reset" class="btn btn-default" value="Clear">

</form>

</div>
</body>
</html>

<?php



?>