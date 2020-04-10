<?php

    class Database
    {
        const INDEX = "index.php";
        const LOGIN = "login.php";
        const LOGOUT = "logout.php";
        const REGISTER = "register.php";
        const SEARCH_PROFILE = "profile_search.php";
        const SUGGEST_MATCH = "suggest_matches.php";
        const VIEW_PROFILE = "user_profile.php";
        const EDIT_PROFILE = "profile-edit.php";
        const ABOUT_US = "about-us.html";
        const ADMIN_DASHBOARD = "admin.php";
        const NOTIFICATIONS = "notifications.php";
        const MARK_NOTIFICATION_AS_SEEN = "php_scripts\mark_navbar_notifications_read.php";
        const MARK_ALL_NOTIFICATIONS_AS_SEEN = "php_scripts\mark_all_navbar_notifications_read.php";
        const BAN_USER = "php_scripts\ban_user.php";
        const DELETE_USER = "php_scripts\delete_user.php";


        /*
        *   Connect to the MySQL database.
        *
        *   return  -   mySQLi object on success, 0 on failure
        */
        function connect() {
            // set db connection variables
            $dbServerName = "hive.csis.ul.ie";
            $dbUsername = "group13";
            $dbPassword = "X2KU>WN7b=aM]-&$";
            $dbName = "dbgroup13"; 

            // Create connection
            $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

            // Check connection
            if ($conn->connect_error) {
                return 0;
            } else {
                return $conn;
            }
        }
    }
?>