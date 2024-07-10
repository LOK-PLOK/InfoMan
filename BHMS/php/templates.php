<?php

    // HTML PREREQUISITES
    function html_start($page_css_file, $more_links=''){

        $page = ucfirst(basename($page_css_file, '.css'));

        echo ('
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>'.$page.'</title>
                <link rel="stylesheet" href="/styles/general.css">
                <link rel="stylesheet" href="/styles/modals.css">
                <link rel="stylesheet" href="/styles/'.$page_css_file.'">
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Mallanna&display=swap" rel="stylesheet">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                <script src="https://kit.fontawesome.com/d13ff814c5.js" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                <script src="/js/general.js"></script>
                '.$more_links.'
            </head>
            <body>
        ');
    }

    
    function html_end(){
        echo ('
                <script src="/js/sliding-tab.js"></script>
                </body>
                </html>');
    }


    function html_sidebar($page_name){

        $styles = array("class-align-tabs-active", "light", "dark");

        echo ('
            <nav class="off-screen-menu">
                <!-- Logo -->
                <div class="bh-logo">
                    <img src="/images/MBH_logo.png" width="150px">
                </div>
                <!-- Navigation Tabs -->
                <div class="navigation-tabs">
                    <a href="dashboard.html">
                        <div class="class-align-tabs ">
                            <img src="/images/icons/Dashboard/Navigation Bar/dashboard_light.png">
                            <h3 class="paddingleft">Dashboard</h3>
                        </div>
                    </a>
                    <a href="">
                        <div class="class-align-tabs">
                            <img src="/images/icons/Dashboard/Navigation Bar/statistics_dark.png">
                            <h3 class="paddingleft">Statistics</h3>
                        </div>
                    </a>
                    <a href="residents.html">
                        <div class="class-align-tabs">
                            <img src="/images/icons/Dashboard/Navigation Bar/residents_dark.png">
                            <h3 class="paddingleft">Residents</h3>
                        </div>
                    </a>
                    <a href="room_logs.html">
                        <div class="class-align-tabs">
                            <img src="/images/icons/Dashboard/Navigation Bar/room_logs_dark.png">
                            <h3 class="paddingleft">Room Logs</h3>
                        </div>
                    </a>
                    <a href="billings.html">
                        <div class="class-align-tabs">
                            <img src="/images/icons/Dashboard/Navigation Bar/billing_dark.png">
                            <h3 class="paddingleft">Billings</h3>
                        </div>
                    </a>
                    <a href="maintenance.html">
                        <div class="class-align-tabs">
                            <img src="/images/icons/Dashboard/Navigation Bar/maintenance_dark.png">
                            <h3 class="paddingleft">Maintenance</h3>
                        </div>
                    </a>
                    <a href="settings.html">
                        <div class="class-align-tabs">
                            <img src="/images/icons/Dashboard/Navigation Bar/setting_dark.png">
                            <h3 class="paddingleft">Settings</h3>
                        </div>
                    </a>
                </div>
                <!-- Sign-out Button -->
                <div class="sign-out">
                    <div class="class-align-tabs">
                        <img src="/images/icons/Dashboard/Navigation Bar/logout.png">
                        <h3 class="paddingleft" style="color: white">Sign out</h3>
                    </div>
                </div>
            </nav>
        ');
    }

?>