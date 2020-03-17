<?php

    require_once('database.php');
    require_once('getter.php');


    /*
    *   verify that an inputted password is well formed. e.g. it has an uppercase letter, number, special char etc
    *
    *   $password   -   password to check
    *
    *   return      -   1 on success, 0 (zero) on failure
    */
    function verify_password_form($password) {
        // one upper and lowercase letter, one num, one special char
        $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"; 

        // test if password matches the above regex
        if (preg_match($password_regex, $password)) { 
            return 1; 
        } else { 
            return 0; 
        }   
    }


    /*
    *   Verify that a user's password hash matches the stored password hash
    *
    *   $password       -   password to verify
    *   $password_conf  -   
    *
    *   return          -   1 on success, 0 (zero) on failure
    */
    function verify_password_hash($username, $password) {
        $password_hash = get_user_attribute($username, "passwordHash");

        if (password_verify($password, $password_hash)) {
            return 1;
        } else {
            return 0;
        }
        
    }


    function verify_username($username) {

        // verify user inputted username
        if (preg_match("/^[a-zA-Z0-9_\-]{8,30}$/", $username)) {
            return 1;
        } else {
            return 0;
        }

    }

?>