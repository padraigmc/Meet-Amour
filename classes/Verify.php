<?php

require_once("UserError.php");

class Verify
{
    private $databaseConnection;
    private $errorList;

    function __construct($databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
        $this->errorList = array();
    }

    public function get_errors() {
        return $this->errorList;
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
    public function verify_login($username, $password) {
        $errorFlag = 0;

        if (!self::verify_username_form($username) || !self::username_exists($username) || 
            !self::verify_password_form($password) || !self::verify_password_hash($username, $password) || 
            self::is_banned($username)) {
            $errorFlag = 1;
        }

        if ($errorFlag) {
            $this->errorList[] = UserError::LOGIN_ERROR;
            return 0;
        } else {
            return 1;
        }
    }

    public function verify_register($email, $username, $password, $passwordConfirm)
    {
        $success = 1;

        if (!self::verify_username_form($username)) {
            $this->errorList[] = UserError::USERNAME_INVALID_FORMAT;
            $success = 0;
        } 
        
        if (self::username_exists($username)) {
            $this->errorList[] = UserError::USERNAME_EXISTS;
            $success = 0;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errorList[] = UserError::EMAIL_INVALID_FORMAT;
        }

        if (self::email_exists($email)) {
            $this->errorList[] = UserError::EMAIL_EXISTS;
            $success = 0;
        } 
        
        if (!self::verify_password_form($password)) {
            $this->errorList[] = UserError::PASSWORD_INVALID_FORMAT;
            $success = 0;
        } 
        
        if ($password != $passwordConfirm) {
            $this->errorList[] = UserError::PASSWORD_MISMATCH;
            $success = 0;
        }

        return $success;
    }

    public function is_banned($username) {
        $sql = "SELECT `isBanned` FROM `User` WHERE `username` = ?;";
        $isBanned = null;

        if ($stmt = $this->databaseConnection->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($isBanned);
                $stmt->fetch();
            }
        }

        return $isBanned;
    }

    private function verify_username_form($username) {
        if (preg_match("/^[a-zA-Z0-9_\-]{4,30}$/", $username)) {
            return 1;
        } else {
            return 0;
        }
    }

    private function verify_password_form($password) {
        // one uppercase letter and one number
        $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/"; 

        if (preg_match($password_regex, $password)) { 
            return 1; 
        } else { 
            return 0; 
        }   
    }

    private function verify_password_hash($username, $password) {
        $password_hash = User::get_user_attribute($this->databaseConnection, $username, "passwordHash");

        if (password_verify($password, $password_hash)) {
            return 1;
        } else {
            return 0;
        }
        
    }

    private function email_exists($email) 
    {
        $sql = "SELECT `email` FROM `User` WHERE `email` = ?;";
        $emailExists = 0;

        if ($stmt = $this->databaseConnection->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) { 
                $emailExists = 1; 
            } else { 
                $emailExists = 0;
            }
        }

        return $emailExists;
    }

    private function username_exists($username) 
    {
        $sql = "SELECT `username` FROM `User` WHERE `username` = ?;";
        $usernameExists = 0;

        if ($stmt = $this->databaseConnection->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) { 
                $usernameExists = 1; 
            } else { 
                $usernameExists = 0;
            }
        }

        return $usernameExists;
    }
}

?>