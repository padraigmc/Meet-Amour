<?php

    include('database.php');


    /*
    *   Query database for all attributes relating to the supplied username and sets all resulting fields as session variables
    *
    *   $username   -   username of user account to be queried
    *
    *   return      -   zero on failure
    */
    function get_all_user_attribute($username) {

        // if a session hasn't already been started, start one
        if (session_status() == PHP_SESSION_NONE)
            session_start();

        // connect to database, terminate script on failure
        if (!$conn = dbConnect())
            return 0;

        // prepare and bind statement
        $sql = "SELECT `userID`, `email`, `username`, `password`, `dateCreated`, `lastLogin`, `isAdmin`, `isBanned`, `isDeactivated`, `isVerified` 
                FROM `User` 
                WHERE `username` = ?;";

        $selectAttribute = $conn->prepare($sql);
        $selectAttribute->bind_param("ssssssssss", $userID, $email, $username, $password, $dateCreated, 
                            $lastLogin, $isAdmin, $isBanned, $isDeactivated, $isVerified);
        
        // execute statement, terminate script on failure
        if (!$selectAttribute->execute())
            return 0;

        // bind variables to prepared statement
        if (!$selectAttribute->bind_result($userID, $email, $username, $password, $dateCreated, $lastLogin, $isAdmin, $isBanned, $isDeactivated, $isVerified))
            return 0;    

        // fetch value(s) and save to array
        $selectAttribute->fetch();
        
        // set all results to session variables
        $_SESSION["userID"] = $userID;
        $_SESSION["email"] = $email;
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        $_SESSION["dateCreated"] = $dateCreated;
        $_SESSION["lastLogin"] = $lastLogin;
        $_SESSION["isAdmin"] = $isAdmin;
        $_SESSION["isBanned"] = $isBanned;
        $_SESSION["isDeactivated"] = $isDeactivated;
        $_SESSION["isVerified"] = $isVerified;

        return 1;
    }

    /*
    *   Query database for an attribute relating to the supplied username
    *
    *   $username   -   username of user account to be queried
    *   $attribute  -   name of attribute (table column) to query
    *   return      -   (string) a single attribute value on success, zero on failure
    */
    function get_user_attribute($username, $attribute) {

        // connect to database, terminate script on failure
        if (!$conn = dbConnect())
            die(__FUNCTION__ . "(): DB connection failed (Line " . __LINE__ . " in " . $_SERVER['PHP_SELF'] . ")");

        // prepare and bind statement
        $selectAttribute = $conn->prepare("SELECT {$attribute} FROM `User` WHERE `username` = ?;");
        $selectAttribute->bind_param("s", $username);
        
        // execute statement, terminate script on failure
        if (!$selectAttribute->execute())
            die(__FUNCTION__ . "(): SQL statement execution failed (Line " . __LINE__ . " in " . $_SERVER['PHP_SELF'] . ")");

        // bind variables to prepared statement
        $selectAttribute->bind_result($val);

        // fetch value(s) and save to array
        $res = array();
        while ($selectAttribute->fetch()) {
            $res[] = $val;
        }

        // if more than one results were returned, give error
        if (sizeof($res) != 1) {
            return 0;
        } else {
            return $res[0];
        }
    }

    /*
    *   Query the db for a list of specified user attributes with value equal to $value
    *
    *   $attribute  -   name of attribute (table column) to query
    *   $value      -   value of attribute
    *
    *   return      -   array of values if values found, otherwise empty array
    */  
    function get_attributes_equal_to($attribute, $value) {
        
        // connect to database, terminate script on failure
        if (!$conn = dbConnect())
            die(__FUNCTION__ . "(): DB connection failed (Line " . __LINE__ . " in " . $_SERVER['PHP_SELF'] . ")");

        // prepare and bind statement
        $selectAttribute = $conn->prepare("SELECT {$attribute} FROM `User` WHERE {$attribute} = ?;");
        $selectAttribute->bind_param("s", $value);
        
        // execute statement, terminate script on failure
        if (!$selectAttribute->execute())
            die(__FUNCTION__ . "(): SQL statement execution failed (Line " . __LINE__ . " in " . $_SERVER['PHP_SELF'] . ")");

        // bind variables to prepared statement
        $selectAttribute->bind_result($val);

        // fetch value(s) and save to array if there are any
        $res = array();
        while ($selectAttribute->fetch()) {
            $res[] = $val;
        }

        // return array
        if ($res) { return $res; } else { return 0; }
    }

?>