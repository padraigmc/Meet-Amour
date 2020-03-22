<?php

class Verify
{

    /*
        *   Verify an inputted email for registration.
        *   Adds an error message to session var when error found
        *   Session must be active and variable 'error' must be declares as an array to function properly.
        *   Session var does not have to be empty.
        *
        *   $email  -   email to check
        *
        *   return  -   1 on success, 0 (zero) on failure
        */
    public static function verify_email_register($email) {
        // verify email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				$_SESSION[User::ERROR][] = UserError::EMAIL_INVALID_FORMAT;

        // check if email exists in db
        if (User::get_user_attributes_equal_to("email", $email))
            $_SESSION[User::ERROR][] = UserError::EMAIL_EXISTS;
    }

    /*
        *   Verify an inputted email for login.
        *   Adds an error message to session var when error found
        *   Session must be active and variable 'error' must be declares as an array to function properly.
        *   Session var does not have to be empty.
        *
        *   $email  -   email to check
        *
        *   return  -   1 on success, 0 (zero) on failure
        */
    public static function verify_email_login($email) {
        // verify email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                $_SESSION[User::ERROR][] = UserError::EMAIL_INVALID_FORMAT;

        // check if email exists i db
        if (!User::get_user_attributes_equal_to("email", $email))
            $_SESSION[User::ERROR][] = UserError::ACCOUNT_NOT_FOUND;
    }

    /*
        *   Verify an inputted username for registration.
        *   Adds an error message to session var when error found
        *   Session must be active and variable 'error' must be declares as an array to function properly.
        *   Session var does not have to be empty.
        *
        *   $username   -   username to check
        *
        *   return      -   1 on success, 0 (zero) on failure
        */
    public static function verify_username_register($username) {
        // test username format
        if (!Verify::verify_username_form($username))
            $_SESSION[User::ERROR][] = UserError::USERNAME_INVALID_FORMAT;


        // test if username already exists
        if (User::get_user_attributes_equal_to("username", $username))
            $_SESSION[User::ERROR][] = UserError::USERNAME_EXISTS;
    }

    /*
        *   Verify an inputted username for login.
        *   Adds an error message to session var when error found
        *   Session must be active and variable 'error' must be declares as an array to function properly.
        *   Session var does not have to be empty.
        *
        *   $username   -   username to check
        *
        *   return      -   1 on success, 0 (zero) on failure
        */
    public static function verify_username_login($username) {
        // test username format
        if (!Verify::verify_username_form($username))
            $_SESSION[User::ERROR][] = UserError::USERNAME_INVALID_FORMAT;


        // test if username exists
        if (!User::get_user_attributes_equal_to("username", $username))
            $_SESSION[User::ERROR][] = UserError::ACCOUNT_NOT_FOUND;
    }


    /*
        *   Verify an inputted password for registration.
        *   Adds an error message to session var when error found
        *   Session must be active and variable 'error' must be declares as an array to function properly.
        *   Session var does not have to be empty.
        *
        *   $password   -   password to check
        *
        *   return      -   1 on success, 0 (zero) on failure
        */
    public static function verify_password_register($password, $password_conf) {
        // verify user inputted password
        if (!Self::verify_password_form($password)) // if the password doesn't match the regex, add error to error array
            $_SESSION[User::ERROR][] = UserError::PASSWORD_INVALID_FORMAT;
        
        if ($password != $password_conf) // if the password doesn't match the confirm password, add error to error array
            $_SESSION[User::ERROR][] = UserError::PASSWORD_MISMATCH;
    }

    /*
        *   Verify an inputted password for login.
        *   Adds an error message to session var when error found
        *   Session must be active and variable 'error' must be declares as an array to function properly.
        *   Session var does not have to be empty.
        *
        *   $password   -   password to check
        *
        *   return      -   1 on success, 0 (zero) on failure
        */
    public static function verify_password_login($username, $password) {
        // validate password, and get all user attributes as session variables
        if (!Self::verify_password_form($password))
            $_SESSION[User::ERROR][] =  UserError::PASSWORD_INVALID_FORMAT;

        // compare hashed user inputted password with stored password hash
        if (!Self::verify_password_hash($username, $password))
            $_SESSION[User::ERROR][] = UserError::PASSWORD_INCORRECT;
    }


    /*
        *   Verify that an inputted password is well formed. e.g. it has an uppercase letter, number, special char etc
        *
        *   $password   -   password to check
        *
        *   return      -   1 on success, 0 (zero) on failure
        */
    public static function verify_password_form($password) {
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
        *   $password       -   plaintext password to verify
        *
        *   return          -   1 on success, 0 (zero) on failure
        */
    public static function verify_password_hash($username, $password) {
        $password_hash = get_user_attribute($username, "passwordHash");

        if (password_verify($password, $password_hash)) {
            return 1;
        } else {
            return 0;
        }
        
    }

    /*
        *   Verify username form
        *
        *   $username       -   username to verify
        *
        *   return          -   1 on success, 0 (zero) on failure
        */
    public static function verify_username_form($username) {

        // verify user inputted username
        if (preg_match("/^[a-zA-Z0-9_\-]{8,30}$/", $username)) {
            return 1;
        } else {
            return 0;
        }

    }
}

?>