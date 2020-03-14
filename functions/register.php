<?php

    include('database.php');
    include('database.php');
    include('getter.php');



    /*
    *   Populate User table with basic user information
    *
    *   $email          -   email of user
    *   $username       -   username of user
    *   $password       -   password of user
    *   $password_conf  -   confirmed password of user
    *
    *   return          -   userID on success, zero on failure
    */
    function registerUser($email, $username, $password, $password_conf) {

        $error = array();
        $date = date("Y-m-d H:i:s");

        // if password validation failed, return 0
        if (!$password_hash = validate_password($password, $password_conf)) {
            $error[] = "Invalid email!";
            return 0;
        }

        // connect to database, terminate script on failure
        if (!$conn = dbConnect()) {
            die(__FUNCTION__ . "(): DB connection failed (Line " . __LINE__ . " in " . $_SERVER['PHP_SELF'] . ")");
        }

        // prepare and bind
        $insertUser = $conn->prepare("INSERT INTO User (`email`, `username`, `password`, `dateCreated`, `lastLogin` ) VALUES (?, ?, ?, ?, ?);");
        $insertUser->bind_param("sssss", $email, $username, $password_hash, $date, $date);

        // execute prepared statement
        // if successful, userID is returned else zero is returned
        if ($insertUser->execute()) {
            
            if (!get_all_user_attribute($username)) {
                $error[] = "User details session storage failed.";
            }

            $_SESSION["loggedIn"] = "1";
            return 1;
        } else {
            return 0;
        }
    }

?>