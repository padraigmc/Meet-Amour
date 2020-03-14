<?php

    include('database.php');
    include('getter.php');


    function validate_password_form($password, $password_conf = "") {

    $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"; // one upper and lowercase letter, one num, one special char
    $passwordGood = false;

    if ($password_conf != "") {
        // validate user inputted password
        if (preg_match($password_regex, $password) && $password == $password_conf) {
            // if password is well formed and matches confirmation field set $passwordGood to true
            $passwordGood = true;
        } else { return 0; } // return 0 for failure
    } else {
        // validate user inputted password
        if (preg_match($password_regex, $password)) {
            // if password is well formed and matches confirmation field set $passwordGood to true
            $passwordGood = true;
        } else { return 0; } // return 0 for failure

        // if password entered is valid one, hash and return it
        if ($passwordGood)
            return password_hash($password, PASSWORD_DEFAULT);
    }


    }

    function validate_password($username, $password_hash) {
    // query db for users hash
    $stored_password_hash = get_user_attribute($username, "password");

    if ($password_hash == $stored_password_hash) {
        # code...
    }

    }

    function validate_email($email) {

    // validate user inputted email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || get_attributes_equal_to("email", $email)) {
        $error[] = "Invalid email!";
        return 0;
    }

    return 1;        
    }


    function validate_username($username) {

    // validate user inputted username
    if (!preg_match("/^[a-zA-Z0-9_\-]{8,30}$/", $username)) {
        $error[] = "Invalid username!";
    }

    // query db for usernames equal to user inputted one
    // add to error array and return zero if another email is found
    if (get_attributes_equal_to("username", $username)) {
        $error[] = "Username already exists!";
        return 0;
    }

    return 1;        
    }

?>