<?php

    include('validate.php');
    include('getter.php');

    function login_user($username, $password) {

        // validate username
        if (!validate_username($username))
            return 0;

        // validate password, and get all user attributes as session variables
        if (validate_password($username, $password)) {
            get_all_user_attribute($username);
            $_SESSION["loggedIn"] = "1";
            return 1;
        } else {
            return 0;
        }
    }

?>