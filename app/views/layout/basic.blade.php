@section ('page-header')

<!DOCTYPE html>
        <html lang="en">
        <head>
            <title>PHP Reference Gateway</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="resources/assets/favicon.ico" type="image/x-icon">
            {{ HTML::style('css/bootstrap.min.css')}}            
        </head>
        
        <?php
            // Alerts if guests users try to go to the link without signing in.
            if( Session::has("login-alert"))
            {
                Utilities::print_error_message("You need to login to use this service.");
                Session::forget("login-alert");
            } 
            // if signed in user is not an admin.           
            if( Session::has("admin-alert"))
            {
                Utilities::print_error_message("You need to be an admin to use this service.");
                Session::forget("admin-alert");
            }
            
        ?>

<?php

Utilities::connect_to_id_store();

?>
<body>

<?php Utilities::create_nav_bar(); ?>

@show

@yield('content')

</body>
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <!-- Jira Issue Collector - Report Issue -->
    <script type="text/javascript"
            src="https://gateways.atlassian.net/s/31280375aecc888d5140f63e1dc78a93-T/en_USmlc07/6328/46/1.4.13/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?locale=en-US&collectorId=b1572922"></script>

    <!-- Jira Issue Collector - Request Feature -->
    <script type="text/javascript"
        src="https://gateways.atlassian.net/s/31280375aecc888d5140f63e1dc78a93-T/en_USmlc07/6328/46/1.4.13/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?locale=en-US&collectorId=674243b0"></script>


    <script type="text/javascript">
        window.ATL_JQ_PAGE_PROPS = $.extend(window.ATL_JQ_PAGE_PROPS, {
            "b1572922":
            {
                "triggerFunction": function(showCollectorDialog) {
                    //Requries that jQuery is available!
                    jQuery("#report-issue").click(function(e) {
                        e.preventDefault();
                        showCollectorDialog();
                    });
                }
            },
            "674243b0":
            {
                "triggerFunction": function(showCollectorDialog) {
                    //Requries that jQuery is available!
                    jQuery("#request-feature").click(function(e) {
                        e.preventDefault();
                        showCollectorDialog();
                    });
                }
            }
        });
    </script>

@show

</html>