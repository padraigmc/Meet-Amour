<?php

    /*
        *   Connect to the MySQL database.
        *
        *   return  -   mySQLi object on success, 0 on failure
    */
    function db_connect() {
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

?>