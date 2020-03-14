<?php

    include('database.php');
    include('getter.php');


    /*
    *   Update an attribute relating to the supplied username
    *
    *   $username   -   username of user account to be queried
    *   $attribute  -   name of attribute (table column) to query
    *   $newValue   -   new value of attribute
    *
    *   return      -   one on success, zero on failure
    */
    function update_user_attribute($username, $attribute, $newValue) {

        // connect to database, terminate script on failure
        if (!$conn = dbConnect())
            die(__FUNCTION__ . "(): DB connection failed (Line " . __LINE__ . " in " . $_SERVER['PHP_SELF'] . ")");

        // prepare and bind statement
        $selectAttribute = $conn->prepare("UPDATE `User` SET {$attribute} = ?  WHERE `username` = ?;");
        $selectAttribute->bind_param("ss", $newValue, $username);
        
        // execute statement, terminate script on failure
        if (!$selectAttribute->execute())
            die(__FUNCTION__ . "(): SQL statement execution failed (Line " . __LINE__ . " in " . $_SERVER['PHP_SELF'] . ")");

        // test if attribute was actually updated, return zero for failure and one for success
        if (get_user_attribute($username, $attribute) == $newValue) {
            return 1;
        } else {
            return 0;
        }
    }

?>