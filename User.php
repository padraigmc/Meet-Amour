<?php

    public $username;
    public $email;
    public $passwordHash;
    public $dateCreated;
    public $lastLogin;
    public $isAdmin;
    public $isBanned;
    public $isDeactivated;
    public $isVerified;
    public $error = array();


    // =========================================================================================
    //  Getters
    // =========================================================================================
    function get_all_attributes() {
        // prepared statement to read all cols in User table here, set all public vars above
    } 
    
    function get_user_attribute($atrribute, $userID) {

        $error = array();

        $conn = dbConnect();
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = `User`";

        if (!mysqli_query($conn, $sql)) {
            die("Error: SQL query failed! (get_attribute())");
        }

        $cols = mysqli_fetch_assoc($result);

        if (in_array($atrribute, $cols) {

            // prepare and bind statement
            $selectAttribuet = $conn->prepare("SELECT ? FROM User WHERE userID = ?;");
            $updateEmail->bind_param("ss", $atrribute, $userID);

            // execute prepared statement
            $updateEmail->execute();

            $result = $stmt->get_result()->fetch_assoc();

            return $result[$atrribute];
        }
    }

    function get_username() {
        // prepared statement here
    }

    function get_email() {
        // prepared statement here
    }

    function get_passwordHash() {
        // prepared statement here
    }

    function get_dateCreated() {
        // prepared statement here
    }

    function get_lastLogin() {
        // prepared statement here
    }

    function get_isAdmin() {
        // prepared statement here
    }

    function get_isBanned() {
        // prepared statement here
    }

    function get_isDeactivated() {
        // prepared statement here
    }

    function get_isVerified() {
        // prepared statement here
    }


    // =========================================================================================
    //  Setters
    // =========================================================================================
    function set_all_attributes($username, $email, $passwordHash, $dateCreated, $lastLogin, $isAdmin, $isBanned, $isDeactivated, $isVerified) {
        // prepared statement to read all cols in User table here, set all public vars above
    }

    function set_attribute() {

    }

    function set_username($username_new) {
        // Set up db connection
        $conn = dbConnect();

        // prepare and bind statement
        $updateEmail = $dbConnection->prepare("UPDATE User SET username = ? WHERE username = ?;");
        $updateEmail->bind_param("sss", $username_new, get_username());

        // execute prepared statement
        $updateEmail->execute();
        
        // test if update statement was unsuccessful
        if (get_username()!=$username_new) {
            $this ->$error[] = "Error: set_username() unsuccessful";
        }
    }

    function set_email($email_new) {
        // Set up db connection
        $conn = dbConnect();

        // prepare and bind statement
        $updateEmail = $dbConnection->prepare("UPDATE User SET email = ? WHERE email = ?;");
        $updateEmail->bind_param("ss", $username_new, $this ->$username);

        // execute prepared statement
        $updateEmail->execute();
        
        // test if update statement was unsuccessful
        if (get_username()!=$username_new) {
            $this ->$error[] = "Error: set_username() unsuccessful";
        }
    }

    function set_passwordHash($passwordHash_new) {
        // prepared statement here
    }

    function set_dateCreated($dateCreated_new) {
        // prepared statement here
    }

    function set_lastLogin($lastLogin_new) {
        // prepared statement here
    }

    function set_isAdmin($isAdmin_new) {
        // prepared statement here
    }

    function set_isBanned($isBanned_new) {
        // prepared statement here
    }

    function set_isDeactivated($isDeactivated_new) {
        // prepared statement here
    }

    function set_isVerified($isVerified_new) {
        // prepared statement here
    }


    // =========================================================================================
    //  Methods
    // =========================================================================================



    function dbConnect() {
        // set db connection variables
        $dbServerName = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "meetamour";

        // Create connection
        $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

        // Check connection
        if ($conn->connect_error) {
            return NULL;
        } else {
            return $conn;
        }
    }

    public function registerUser($username_new, $email_new, $passwordHash_new) {
        
        
        set_username($user);
    }


?>