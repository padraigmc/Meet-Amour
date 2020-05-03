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
        const ABOUT_US = "about-us.php";
        const CONTACT_US = "index.php#contact";
        const FAQ = "faq.php";
        const ADMIN_DASHBOARD = "admin-dashboard.php";
        const NOTIFICATIONS = "notifications.php";
        const MARK_NOTIFICATION_AS_SEEN = "php_scripts\mark_navbar_notifications_read.php";
        const MARK_ALL_NOTIFICATIONS_AS_SEEN = "php_scripts\mark_all_navbar_notifications_read.php";
        const BAN_USER = "php_scripts\ban_user.php";
        const UNBAN_USER = "php_scripts\unban_user.php";
        const DELETE_USER = "php_scripts\delete_user.php";


        /*
        *   Connect to the MySQL database.
        *
        *   return  -   mySQLi object on success, 0 on failure
        */
        public static function connect() {
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

        public static function insert_new_user($dbConnection, $email, $username, $password_hash) 
        {
            $sql = "INSERT INTO `User` (`email`, `username`, `passwordHash`, `dateCreated`, `lastLogin` ) VALUES (?, ?, ?, ?, ?);";
            $date = date("Y-m-d H:i:s");

            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("sssss", $email, $username, $password_hash, $date, $date);
                $stmt->execute();

                if ($stmt->affected_rows == 1) {
                    $success = 1;
                } else {
                    $success = 0;
                }

                $stmt->close();
            } else {
                $success = 0;
            }
            return $success;
        }
    }
?>