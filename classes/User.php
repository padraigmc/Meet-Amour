<?php

    require_once("Database.php");
    require_once("Profile.php");
    require_once("Image.php");
    require_once("Hobby.php");
    require_once("Verify.php");
    require_once("UserError.php");

    class User
    {
        const USER_ID = "userID";
        const USERNAME = "username";
        const EMAIL = "email";
        const PASSWORD = "password";
        const DATE_CREATED = "dateCreated";
        const LAST_LOGIN = "lastLogin";
        const IS_ADMIN = "isAdmin";
        const IS_BANNED = "isBanned";
        const IS_DEACTIVATED = "isDeactivated";
        const IS_VERIFIED = "isVerified";
        const ERROR = "error";
        const LOGGED_IN = "loggedIn";
        const NEW_USER = "newUser";

        const FIRST_NAME = "fname";
        const LAST_NAME = "lname";
        const NAME = "name";
        const DATE_OF_BIRTH = "dob";
        const GENDER_ID = "genderID";
        const GENDER = "gender";
        const SEEKING_ID = "seekingID";
        const SEEKING = "seeking";
        const DESCRIPTION = "description";
        const LOCATION_ID = "locationID";
        const LOCATION = "location";
        const HOBBIES = "hobbies";
        const USER_IMAGE = "userImage";

        const USER_IMAGES = "user_images/";
        const USER_IMAGE_DIR = "user_images/";
        const DEFAULT_USER_IMAGE = "img/blank-profile.png";


        public static function resolve_foreign_keys_in_profile_tbl($dbConnection, $userID)
        {
            $gender = $seeking = $location = "";
            $sql = "SELECT `gender`.`gender`, `seeking`.`gender` AS `seeking`, `location`.`location`
                    FROM `Profile` AS `profile`,
                            `Gender` AS `gender`, 
                            `Gender` AS `seeking`, 
                            `Location` AS `location`
                    WHERE `profile`.`userID` = ? AND 
                            `profile`.`genderID` = `gender`.`genderID` AND 
                            `profile`.`seekingID` = `seeking`.`genderID` AND
                            `profile`.`locationID` = `location`.`locationID`;";


            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                $stmt->bind_result($gender, $seeking, $location);

                if ($stmt->fetch()) {
                    $vals = array();
                    $vals[User::GENDER] = $gender;
                    $vals[User::SEEKING] = $seeking;
                    $vals[User::LOCATION] = $location;
                } else {
                    $vals = 0;
                }
            } else {
                $vals = 0;
            }
            return $vals;
        }

        public static function get_all_genders($dbConnection) 
        {
            try {
        
                // Query database for below statement, return mysqli result object
                $sql = "SELECT `genderID`, `gender` FROM `Gender`";
                return $dbConnection->query($sql);
            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            }
    
        }


        public static function get_all_locations($dbConnection) 
        {
            try {
                // Query database for below statement, return mysqli result object
                $sql = "SELECT `locationID`, `location` FROM `Location` ORDER BY `location`";
                return $dbConnection->query($sql);

            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            }
    
        }

        public static function set_profile_attributes($dbConnection, $userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID, $newUser = 0) 
        {
            
            // test user inputted string lengths
            if (strlen($fname) < 1) $_SESSION[User::ERROR][] = UserError::NAME_SHORT;
            if (strlen($fname) > 30) $_SESSION[User::ERROR][] = UserError::NAME_LONG;
            if (strlen($description) > 255) $_SESSION[User::ERROR][] = UserError::DESCRIPTION_LONG;

            // if the error session variable is not empty, return a failure
            if (!empty($_SESSION[User::ERROR]))
                return 0;

            try {
                
                if ($newUser) {
                    $sql = "INSERT INTO `Profile` (`userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
                
                    $stmt = $dbConnection->prepare($sql);
                    $stmt->bind_param("ssssssss", $userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID);

                } else {
                    $sql = "UPDATE `Profile` 
                            SET `fname` = ?, `lname` = ?, `dob` = ?, `genderID` = ?, `seekingID` = ?, `description` = ?, `locationID` = ? 
                            WHERE `userID` = ?;";

                    $stmt = $dbConnection->prepare($sql);
                    $stmt->bind_param("ssssssss", $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID, $userID);
                }

                if ($stmt->execute()) {
                    $_SESSION[User::FIRST_NAME] = $fname;
                    $_SESSION[User::LAST_NAME] = $lname;
                    $_SESSION[User::DATE_OF_BIRTH] = $dob;
                    $_SESSION[User::GENDER_ID] = $genderID;
                    $_SESSION[User::SEEKING_ID] = $seekingID;
                    $_SESSION[User::DESCRIPTION] = $description;
                    $_SESSION[User::LOCATION_ID] = $locationID;

                    $readable_foreign_keys = User::resolve_foreign_keys_in_profile_tbl($dbConnection, $userID);
                    $_SESSION[User::GENDER] = $readable_foreign_keys[User::GENDER];
                    $_SESSION[User::SEEKING] = $readable_foreign_keys[User::SEEKING];
                    $_SESSION[User::LOCATION] = $readable_foreign_keys[User::LOCATION];
                    return 1;
                } else {
                    return 0;
                }

            } catch (Throwable $t) {
                echo $t->getMessage();
            }
        }

        public static function register($dbConnection, $email, $username, $password, $passwordConfirm) 
        {
            $verify = new Verify($dbConnection);
      
			if ($verify->verify_register($email, $username, $password, $passwordConfirm)) {

                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $addUserWasSuccessful = Database::insert_new_user($dbConnection, $email, $username, $password_hash);
                
                if ($addUserWasSuccessful) {
                    User::set_session_vars($dbConnection, $username);
                }

                return $addUserWasSuccessful;
            } else {
                $_SESSION[User::ERROR] = $verify->get_error();
                return 0;
            }
        }

        public static function login($dbConnection, $username, $password) 
        {
            $verify = new Verify($dbConnection);

            if ($verify->verify_login($username, $password)) {
                User::update_last_login($dbConnection, $username);
                User::set_session_vars($dbConnection, $username);
                $_SESSION[User::LOGGED_IN] = 1;
                return 1;
            } else {
                $_SESSION[User::ERROR] = $verify->get_error();
                return 0;
            }
        }

        private static function update_last_login($dbConnection, $username) {
            $success = 0;
            $sql = "UPDATE `User` SET `lastLogin` = ?
                    WHERE `username` = ?;";

            if ($stmt = $dbConnection->prepare($sql)) {
                $current_date = date("Y-m-d H:i:s");
                $stmt->bind_param("ss", $current_date, $username);
                $success = $stmt->execute();
            }
            return $success;
        }

        public static function logout() 
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            unset($_SESSION);
            session_destroy();

            header("Location: index.php");
            exit();
        }

        public static function isLoggedIn() {
            if (isset($_SESSION[User::LOGGED_IN]) && $_SESSION[User::LOGGED_IN] == 1) {
                return 1;
            } else {
                return 0;
            }
        }


        /*
            *   Used to display variable value in an form input element if it is NOT null
            *   If the variable is null, a placeholder will be displayed
            *
            *   $value                  -   value to display if it is not null
            *   $placeholder_string     -   string to display as a placeholder if value is null
            *
            *   return                  -   string containing the 'value' or 'placeholder' form input attribute
            */
        public static function populate_form_input($value, $placeholder_string) 
        {
            if (isset($value)) {
                return "value=\"" . $value . "\"";
            } else {
                return "placeholder=\"" . $placeholder_string . "\"";
            }
        }

        private static function set_session_vars($dbConnection, $username) 
        {
            if ($userAttributes = User::query_base_attributes($dbConnection, $username)) {
                $_SESSION[User::USER_ID] = $userAttributes[User::USER_ID];
                $_SESSION[User::USERNAME] = $userAttributes[User::USERNAME];
                $_SESSION[User::IS_ADMIN] = $userAttributes[User::IS_ADMIN];
                $_SESSION[User::IS_BANNED] = $userAttributes[User::IS_BANNED];
                $_SESSION[User::IS_DEACTIVATED] = $userAttributes[User::IS_DEACTIVATED];
                $_SESSION[User::IS_VERIFIED] = $userAttributes[User::IS_VERIFIED];

                $_SESSION[User::FIRST_NAME] = $userAttributes[User::FIRST_NAME];
                $_SESSION[User::LAST_NAME] = $userAttributes[User::LAST_NAME];
                $_SESSION[User::DATE_OF_BIRTH] = $userAttributes[User::DATE_OF_BIRTH];
                $_SESSION[User::GENDER_ID] = $userAttributes[User::GENDER_ID];
                $_SESSION[User::GENDER] = $userAttributes[User::GENDER];
                $_SESSION[User::SEEKING_ID] = $userAttributes[User::SEEKING_ID];
                $_SESSION[User::SEEKING] = $userAttributes[User::SEEKING];
                $_SESSION[User::DESCRIPTION] = $userAttributes[User::DESCRIPTION];
                $_SESSION[User::LOCATION_ID] = $userAttributes[User::LOCATION_ID];
                $_SESSION[User::LOCATION] = $userAttributes[User::LOCATION];

                $_SESSION[User::LOGGED_IN] = 1;
                $_SESSION[User::ERROR] = array();
                $result = 1;
            } else {
                $result = 0;
            }

            return $result;
        }

        private static function query_base_attributes($dbConnection, $username) {
            $sql = "SELECT `u`.`userID`, `u`.`username`, `u`.`isAdmin`, `u`.`isBanned`, `u`.`isDeactivated`, `u`.`isVerified`,
                        `p`.`fname`, `p`.`lname`, `p`.`dob`, `p`.`genderID`, `p`.`seekingID`, `p`.`description`, `p`.`locationID`,
                        `gender`.`gender`, `seeking`.`gender`, `location`.`location`
                    FROM `User` AS `u`
                    LEFT JOIN `Profile` AS `p` ON `p`.`userID` = `u`.`userID`
                    LEFT JOIN `Gender` AS `gender` ON `gender`.`genderID` = `p`.`genderID`
                    LEFT JOIN `Gender` AS `seeking` ON `seeking`.`genderID` = `p`.`seekingID`
                    LEFT JOIN `Location` AS `location` ON `location`.`locationID` = `p`.`locationID`
                    WHERE `username` = ?;";
            $attributes = array();

            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                
                $stmt->bind_result(
                    $attributes[User::USER_ID], 
                    $attributes[User::USERNAME], 
                    $attributes[User::IS_ADMIN], 
                    $attributes[User::IS_BANNED], 
                    $attributes[User::IS_DEACTIVATED], 
                    $attributes[User::IS_VERIFIED],
                    $attributes[User::FIRST_NAME], 
                    $attributes[User::LAST_NAME], 
                    $attributes[User::DATE_OF_BIRTH], 
                    $attributes[User::GENDER_ID], 
                    $attributes[User::SEEKING_ID], 
                    $attributes[User::DESCRIPTION], 
                    $attributes[User::LOCATION_ID],
                    $attributes[User::GENDER], 
                    $attributes[User::SEEKING], 
                    $attributes[User::LOCATION]
                );
                $stmt->fetch();
                $stmt->close();
            }
            return $attributes;
        }


        /*
            *    Function to calculate the age of a user given their date of birth.
            *    Supported date formats are ones supported by the strtotime() function. (incl. MySQL's DATETIME data type)
            *
            *    $dateOfBirth    -   User's date of birth
            * 
            *    return          -   User's age in years on success, zero on failure
            */
        function calc_age($dateOfBirth) {

            // if supplied date isn't correctly formatted, return 0 for failure
            if (!$dob_timestamp = strtotime($dateOfBirth))
                return 0;

            // get formatted date string
            $dateOfBirth = date("Y-m-d", $dob_timestamp);

            //explode the date to get month, day and year
            $dateOfBirth = explode("-", $dateOfBirth);

            $year = $dateOfBirth[0];
            $month = $dateOfBirth[1];
            $day = $dateOfBirth[2];
            
            //get age from date or dateOfBirth
            if (date("md", date("U", mktime(0, 0, 0, $month, $day, $year))) > date("md")) {
                return ((date("Y") - $year) - 1);
            } else {
                return (date("Y") - $year);
            }
        }

    }
?>