<?php
/**
 * Allow users to create a new user account
 */
Utilities::create_http_header();

Utilities::connect_to_id_store();
?>

<html>

<?php Utilities::create_html_head(); ?>

<body>

<?php Utilities::create_nav_bar(); ?>

    <div class="container" style="max-width: 330px;">

        <h3>
            Login
            <small>
                <small> (Not registered? <a href="create">Create account</a>)</small>
            </small>
        </h3>

        

        <form action="login" method="post" role="form">
            <div class="form-group">
                <label class="sr-only" for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username" autofocus required>
            </div>
            <div class="form-group">
                <label class="sr-only" for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <input name="Submit" type="submit" class="btn btn-primary btn-block" value="Sign in">
        </form>
    </div>
    </body>
    </html>

<?php

unset($_POST);


?>