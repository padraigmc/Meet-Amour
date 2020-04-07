<?php

    include("Database.php");
    include("Verify.php");
    include("UserError.php");

    class User
    {
        // session variable names
        const USER_ID = "userID";
        const IS_ADMIN = "isAdmin";
        const IS_BANNED = "isBanned";
        const IS_DEACTIVATED = "isDeactivated";
        const IS_VERIFIED = "isVerified";
        const ERROR = "error";
        const LOGGED_IN = "loggedIn"; // flag set to 1 if user is logged in, else 0
        const NEW_USER = "newUser";

        const USERNAME = "username";
        const EMAIL = "email";
        const PASSWORD = "password";
        const DATE_CREATED = "dateCreated";
        const LAST_LOGIN = "lastLogin";
        const FIRST_NAME = "fname";
        const LAST_NAME = "lname";
        const DATE_OF_BIRTH = "dob";
        const GENDER_ID = "genderID";
        const GENDER = "gender";
        const SEEKING_ID = "seekingID";
        const SEEKING = "seeking";
        const DESCRIPTION = "description";
        const LOCATION_ID = "locationID";
        const LOCATION = "location";

        const USER_IMAGES = "user_images/";
        const DEFAULT_USER_IMAGE = "img/blank-profile.png";
     
        //  ======================================================================================================
        //                                                  Getters
        //  ======================================================================================================

        /*
            *   Query database for all attributes from User table relating to the supplied username.
            *   Sets qeury results as session variables
            *
            *   $username   -   username of user account to be queried
            *
            *   return      -   zero on failure, one on success
            */
        public static function get_all_user_attributes($dbConnection, $username) 
        {
            $userID = $email = $password = $dateCreated = $lastLogin = $isAdmin = $isBanned = $isDeactivated = $isVerified = "";
            $vals = array();
            $sql = "SELECT `userID`, `email`, `username`, `passwordHash`, `dateCreated`, `lastLogin`, `isAdmin`, `isBanned`, `isDeactivated`, `isVerified` 
                    FROM `User` 
                    WHERE `username` = ?;";

            try {

                // prepare, bind and execute sql statement
                $stmt = $dbConnection->prepare($sql);
                $stmt->bind_param("s", $username);
                if (!$stmt->execute()) return 0;
                
                // if sql statement is successful, bind parameters
                if (!$stmt->bind_result($userID, $email, $username, $password, $dateCreated, $lastLogin, $isAdmin, 
                                                $isBanned, $isDeactivated, $isVerified)) 
                    return 0; 

                // fetch value(s) and save to array
                // only one row is returned, so we don't need to iterate throw this to get column values
                if ($stmt->fetch()) {
                    // Populate array to be returned
                    $vals[User::USER_ID] = $userID;
                    $vals[User::USERNAME] = $username;
                    $vals[User::EMAIL] = $email;
                    $vals[User::PASSWORD] = $password;
                    $vals[User::DATE_CREATED] = $dateCreated;
                    $vals[User::LAST_LOGIN] = $lastLogin;
                    $vals[User::IS_ADMIN] = $isAdmin;
                    $vals[User::IS_BANNED] = $isBanned;
                    $vals[User::IS_DEACTIVATED] = $isDeactivated;
                    $vals[User::IS_VERIFIED] = $isVerified;

                    return $vals;
                } else {
                    return 0;
                }
            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            } finally {
                $stmt->close();
            }
        }

        /*
            *   Query database for an attribute relating to the supplied username
            *
            *   $username   -   username of user account to be queried
            *   $attribute  -   name of attribute (table column) to query
            *
            *   return      -   (string) a single attribute value on success, zero on failure
            */
        public static function get_user_attribute($dbConnection, $username, $attribute) 
        {
            $val ="";
            $sql = "SELECT {$attribute} FROM `User` WHERE `username` = ?;";

            try {

                // prepare, bind and execute statement
                if ($stmt = $dbConnection->prepare($sql)) {
                    $stmt->bind_param("s", $username);
                    $stmt->execute();

                    // statement was succesful, bind result
                    $stmt->bind_result($val);
                    
                    // fetch result and return it
                    if ($stmt->fetch()) {
                        return $val;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            } finally {
                $stmt->close();
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
        public static function get_user_attributes_equal_to($dbConnection, $attribute, $value) 
        {
            $sql = "SELECT {$attribute} FROM `User` WHERE {$attribute} = ?;";
            $arr = array();
            $val = "";

            try {

                // prepare, bind ad execute statement
                $stmt = $dbConnection->prepare($sql);
                $stmt->bind_param("s", $value);
                if (!$stmt->execute()) return 0;

                // bind variables to prepared statement
                if (!$stmt->bind_result($val)) return 0;

                // fetch value(s) and save to array if there are any
                while ($stmt->fetch()) {
                    $arr[] = $val;
                }

                // return array
                if ($arr) { 
                    return $arr; 
                } else { 
                    return 0; 
                }

            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            } finally {
                //$stmt->close();
            }
        }

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

        public static function profile_search($dbConnection, $name, $gender, $location , $min_age, $max_age, $rowOffset = 0) 
        {
            $name = htmlspecialchars($name);
            $name = trim($name);
            
            if (!isset($name) || $name == "") {
                return 0;
            }

            $date_min = date("Y-m-d", strtotime("-" . ($max_age+1) . " year +1 day", time())) . " 00:00:00";
            $date_max = date("Y-m-d", strtotime("-" . $min_age . " year", time())) . " 23:59:59";

            //abs(to_seconds({$age_dob}) - to_seconds(`p`.`dob`))

            $sql = "SELECT `p`.`userID`, `u`.`username`, concat(`p`.`fname`, ' ', `p`.`lname`) AS `name`, `p`.`dob`, `g`.`gender`, `s`.`gender` as `seeking`, `p`.`description`, `l`.`location`, `Photo`.`filename`, `u`.`lastLogin`
                    FROM `Profile` AS `p`
                    LEFT JOIN `User` AS `u` ON `p`.`userID`=`u`.`userID`
                    LEFT JOIN `Gender` AS `g` ON `p`.`genderID`=`g`.`genderID`
                    LEFT JOIN `Gender` AS `s` ON `p`.`seekingID`=`s`.`genderID`
                    LEFT JOIN `Location` AS `l` ON `p`.`locationID`=`l`.`locationID`
                    LEFT JOIN `Photo` ON `p`.`userID`=`Photo`.`userID`
                    WHERE concat(`p`.`fname`, `p`.`lname`) LIKE ? AND
                            `g`.`genderID` LIKE ? AND
                            `l`.`locationID` LIKE ? AND
                            `p`.`dob` >= ? AND `p`.`dob` <= ?
                    ORDER BY `u`.`lastLogin` DESC
                    LIMIT ?, 10;";

            $name = str_replace(array("?", "%"), "", $name);
            $name = "%" . $name . "%";

            $stmt = $dbConnection->prepare($sql);

            $stmt->bind_param("sssssi", $name, $gender, $location, $date_min, $date_max, $rowOffset);

            // execute statement, terminate script on failure
            if (!$stmt->execute()) return 0;

            $result = $stmt->get_result();
            $rows = array();

            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $stmt->close();
            return $rows;
        }

        public static function suggest_matches($dbConnection, $userID) {
            $sql = "SELECT `Profile`.`userID`, `User`.`username`, concat(`Profile`.`fname`, ' ', `Profile`.`lname`) as `name`, `Profile`.`dob`, `Gender`.`gender`, `Profile`.`description`, `Location`.`location`, `Photo`.`filename`
                    FROM Profile
                    LEFT JOIN `User` on `Profile`.`userID` = `User`.`userID`
                    LEFT JOIN `Gender` on `Profile`.`genderID` = `Gender`.`genderID`
                    LEFT JOIN `Location` on `Profile`.`locationID` = `Location`.`locationID`
                    LEFT JOIN `Photo` on `Profile`.`userID` = `Photo`.`userID`
                    LEFT JOIN (
                        SELECT `uh1`.`userID`, COUNT(`uh2`.`hobbyID`) AS `mutualHobbies`
                        FROM UserHobby AS `uh1`
                        INNER JOIN `UserHobby` AS `uh2`
                        ON `uh2`.`userID` = ? AND `uh2`.`hobbyID` = `uh1`.`hobbyID`
                        GROUP BY `uh1`.`userID`
                    ) as `UserHobby` ON `Profile`.`userID` = `UserHobby`.`userID`
                    WHERE `Profile`.`genderID` LIKE '%'
                    ORDER BY `Profile`.`locationID` = ? DESC, `UserHobby`.`mutualHobbies` DESC
                    LIMIT 6;";

            $genderID = 1;

            $stmt = $dbConnection->prepare($sql);
            $stmt->bind_param("ss", $userID, $genderID);

            // execute statement, terminate script on failure
            if (!$stmt->execute()) return 0;

            $result = $stmt->get_result();
            $rows = array();

            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $stmt->close();
            return $rows;
        }


//  ======================================================================================================
//                                                  Setters
//  ======================================================================================================


        public static function set_session_vars($dbConnection, $username) 
        {
            $sql = "SELECT `u`.`userID`, `u`.`username`, `u`.`isAdmin`, `u`.`isBanned`, `u`.`isDeactivated`, `u`.`isVerified`,
                `p`.`fname`, `p`.`lname`, `p`.`dob`, `p`.`genderID`, `p`.`seekingID`, `p`.`description`, `p`.`locationID`,
                `gender`.`gender`, `seeking`.`gender`, `location`.`location`
                FROM `User` AS `u`
                LEFT JOIN `Profile` AS `p` ON `p`.`userID` = `u`.`userID`
                LEFT JOIN `Gender` AS `gender` ON `gender`.`genderID` = `p`.`genderID`
                LEFT JOIN `Gender` AS `seeking` ON `seeking`.`genderID` = `p`.`seekingID`
                LEFT JOIN `Location` AS `location` ON `location`.`locationID` = `p`.`locationID`
                WHERE `username` = ?;";

            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                
                $stmt->bind_result(
                    $_SESSION[User::USER_ID], $_SESSION[User::USERNAME], $_SESSION[User::IS_ADMIN], $_SESSION[User::IS_BANNED], $_SESSION[User::IS_DEACTIVATED], $_SESSION[User::IS_VERIFIED],
                    $_SESSION[User::FIRST_NAME], $_SESSION[User::LAST_NAME], $_SESSION[User::DATE_OF_BIRTH], $_SESSION[User::GENDER_ID], $_SESSION[User::SEEKING_ID], $_SESSION[User::DESCRIPTION], $_SESSION[User::LOCATION_ID],
                    $_SESSION[User::GENDER], $_SESSION[User::SEEKING], $_SESSION[User::LOCATION]
                );

                $result = $stmt->fetch();
            } else {
                $result = 0;
            }

            return $result;
        }

        /*
            *   Chcecks if the loggedIn session variable is set and equal to 1
            *   
            *
            *   $username   -   username of user account to be queried
            *
            *   return      -   zero on failure, one on success
            */
        public static function isLoggedIn() {
            if (isset($_SESSION[User::LOGGED_IN]) && $_SESSION[User::LOGGED_IN] == 1) {
                return 1;
            } else {
                return 0;
            }
        }


        /*
            *   Update an attribute relating to the supplied username
            *
            *   $username   -   username of user account to be queried
            *   $attribute  -   name of attribute (table column) to query
            *   $newValue   -   new value of attribute
            *
            *   return      -   one on success, zero on failure
            */
        public static function update_user_attribute($dbConnection, $username, $attribute, $newValue) 
        {
            $sql = "UPDATE `User` SET {$attribute} = ?  WHERE `username` = ?;";

            try {

                // prepare and bind statement
                $stmt = $dbConnection->prepare($sql);
                $stmt->bind_param("ss", $newValue, $username);
                
                // execute statement, terminate script on failure
                if ($stmt->execute()) {
                    return 1;
                } else {
                    return 0;
                }
            
            
            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            } finally {
                $stmt->close();
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


//  ======================================================================================================
//                                                  Methods
//  ======================================================================================================

        public static function register($dbConnection, $email, $username, $password, $passwordConfirm) 
        {
            $sql = "INSERT INTO `User` (`email`, `username`, `passwordHash`, `dateCreated`, `lastLogin` ) VALUES (?, ?, ?, ?, ?);";
            $date = date("Y-m-d H:i:s");

            // verify user inputs, adds any errors to $_SESSION["error"]
			Verify::verify_email_register($dbConnection, $email);
			Verify::verify_username_register($dbConnection, $username);
			Verify::verify_password_register($password, $passwordConfirm);
      
			// if no errors were found
			if (empty($_SESSION[User::ERROR])) {

				// hash password
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
            
                try {
                    // prepare, bind and execute
                    if (!$stmt = $dbConnection->prepare($sql)) {
                        $stmt->close();
                        return 0;
                    }

                    $stmt->bind_param("sssss", $email, $username, $password_hash, $date, $date);
                
                    // if sql query is true, return userID else 0
                    if ($stmt->execute()) {
                        User::set_session_vars($dbConnection, $username);
                        $_SESSION[User::LOGGED_IN] = 1; // set session variable logged in
                        $success = 1;
                    } else {
                        $success = 0;
                    }

                    $stmt->close();
                    return $success;

                } catch (Throwable $t) {
                    echo $t->getMessage();
                    return 0;
                } finally {
                    $stmt->close();
                }
            }
        }

        public static function profile_set_up($dbConnection, $userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID) 
        {
            // test user inputted string lengths
            if (strlen($fname) < 1) $_SESSION[User::ERROR][] = UserError::NAME_SHORT;
            if (strlen($fname) > 30) $_SESSION[User::ERROR][] = UserError::NAME_LONG;
            if (strlen($description) > 255) $_SESSION[User::ERROR][] = UserError::DESCRIPTION_LONG;
            
            
            try {
                // if no errors were found
                if (empty($_SESSION[User::ERROR])) {
                    $success = 1;

                    // declare variables
                    $sql = "INSERT INTO `Profile` (`userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
                    
                    // prepare bind and execute prepared statement
                    if (!$stmt = $dbConnection->prepare($sql))
                        $success = 0;

                    $stmt->bind_param("ssssssss", $userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID);
                    if (!$stmt->execute())
                        $success = 0;
                    
                    $stmt->close();
                    return $success;

                } else {
                    return 0;
                }
            } catch (Throwable $t) {
                echo $t->getMessage() . " " . $t->getLine();
                return 0;
            } finally {
                $stmt->close();
            }
        }

        public static function login($dbConnection, $username, $password) 
        {

            // test login, if successful set session variables
            if (Verify::verify_login($dbConnection, $username, $password)) {
                User::set_session_vars($dbConnection, $username);

                // add error to list if user account is banned
                if ($_SESSION[User::IS_BANNED]) {
                    $_SESSION[User::ERROR][] = UserError::ACCOUNT_BANNED;
                }
            }
            
            // if no errors found, set loggedIn session var and return 1, else return 0
            if (empty($_SESSION[User::ERROR])) {
                $_SESSION[User::LOGGED_IN] = 1;
                return 1;
            } else {
                return 0;
            }
        }

        public static function logout() 
        {

            // if a session exists, destory it
            if (session_status() == PHP_SESSION_ACTIVE) {
                session_destroy();
            }

            // redirect to login page
            header("Location: index.php");
            exit();
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

        /*
            *   Returns the relative file path of a user's profile image e.g. "my_profile.png"
            *
            *   $userID         -   user id of the user
            *   $getRelative    -   if 1, the relative path will be returned according to User::USER_IMAGES, otherwise the filename will be returned
            *
            *   return      -   filename of the user's profile image on success appended onto 'User::USER_IMAGES', 0 on failure
            */
        public static function get_user_image_filename($dbConnection, $userID) 
        {
            if (!isset($userID) || $userID < 1)
                return 0;

            $fileName = "";
            $sql = "SELECT `fileName` 
                    FROM `Photo` 
                    WHERE `userID` = ?;";
            

            if ($stmt = $dbConnection->prepare($sql)) {
                // params and execute
                $stmt->bind_param("s", $userID);
                $stmt->execute(); 

                // get result
                $stmt->bind_result($fileName);
                $stmt->fetch();

                // close mysli_stmt object and connection
                $stmt->close();
            }

            if ($fileName && is_file(User::USER_IMAGES . $fileName)) {
                return $fileName;
            } else {
                return 0;
            }
        }

        public static function get_filepath($dbConnection, $userID) 
        {
            if (!isset($userID) || $userID < 1)
                return 0;

            $fileName = null;
            $sql = "SELECT `fileName` 
                    FROM `Photo` 
                    WHERE `userID` = ?;";
            

            if ($stmt = $dbConnection->prepare($sql)) {
                // params and execute
                $stmt->bind_param("s", $userID);
                $stmt->execute(); 

                // get result
                $stmt->bind_result($fileName);
                $stmt->fetch();

                // close mysli_stmt object and connection
                $stmt->close();

                if (isset($fileName) && is_file(User::USER_IMAGES . $fileName)) {
                    return $fileName;
                }
            }

            if (isset($fileName) && is_file(User::USER_IMAGES . $fileName)) {
                return $fileName;
            } else {
                return 0;
            }
        }


        /*
            *   Delete's a user's profile image from the database and file system
            *
            *   $userID     -   user id of the user
            *   $filename   -   name of the image to be deleted e.g. 'my_profile.png'
            *
            *   return      -   filename of the user's profile image on success, 0 on failure
            */
        public static function delete_user_image($dbConnection, $userID) 
        {
            if (!isset($userID) || $userID < 1) {
                return 0;
            }

            $fileName = User::get_user_image_filename($dbConnection, $userID);

            $sql = "DELETE FROM `Photo` 
                    WHERE `fileName` = ?;";

            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("s", $fileName);
                $stmt->execute();

                $stmt->close();
            
                $filePath = User::USER_IMAGES . $fileName;
                if (is_file($filePath)) unlink($filePath);
                return 1;
            } else {
                return 0;
            }
        }


        public static function upload_user_image($dbConnection, $userID, $fileInputName) 
        {
            $dateUploaded = date("Y-m-d H:i:s");
            $epoch_milli = round(microtime(true) * 1000);
            $target_dir = User::USER_IMAGES;

            // if the user already has an image, delete it
            User::delete_user_image($dbConnection, $userID);

            // get full filename incl. extension
            $ext = pathinfo($_FILES[$fileInputName]["name"], PATHINFO_EXTENSION);
            $filename_original = pathinfo($_FILES[$fileInputName]["name"], PATHINFO_FILENAME);
            $filename = substr($filename_original, 0, 30) . "_" . $epoch_milli . "." . $ext;
            $target_file = $target_dir . $filename;
            
            // Check if image file is a actual image or fake image
            if(getimagesize($_FILES[$fileInputName]["tmp_name"]) === false) {
                $_SESSION[User::ERROR][] = UserError::IMAGE_UNSUPPORTED;
                return 0;
            }            
            
            // Check file size 2MB
            if ($_FILES[$fileInputName]["size"] > 2097152) {
                $_SESSION[User::ERROR][] = UserError::IMAGE_LARGE;
                return 0;
            }

            // Allow certain file formats
            if($ext != "jpg" && $$ext != "png" && $$ext != "jpeg" && $$ext != "gif" ) {
                $_SESSION[User::ERROR][] = UserError::IMAGE_UNSUPPORTED;
                return 0;
            }

            // try to move file to target folder
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO `Photo` (`userID`, `fileName`, `dateUploaded`) 
                        VALUES (?, ?, ?);";

                if (!$stmt = $dbConnection->prepare($sql)) {
                    $stmt->close();
                    return 0;
                }

                $stmt->bind_param("sss", $userID, $filename, $dateUploaded);
                $sucess = $stmt->execute();

                $stmt->close();
                return $sucess;

            } else {
                $_SESSION[User::ERROR][] = UserError::GENERAL_ERROR;
                return 0;
            }
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

        public static function check_like_status($dbConnection, $recipientUserID) 
        {
            $sql = "SELECT `toUserID`
                    FROM `Like`
                    WHERE `fromUserID` = ? AND `toUserID` = ?;";

            // prepare, bind and execute statement
            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("ss", $_SESSION[User::USER_ID], $recipientUserID);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows() == 1) {
                    $stmt->close();
                    return 1;
                }
            } else {
                return 0;
            }
        }


        public static function like_user($dbConnection, $recipientUserID) 
        {
            $current_timestamp = date("Y-m-d H:i:s");

            $sql = "INSERT INTO `Like` (`fromUserID`, `toUserID`, `dateLiked`) 
                            VALUES (?, ?, ?);";

            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("sss", $_SESSION[User::USER_ID], $recipientUserID, $current_timestamp);
                $stmt->execute();
                return $stmt->affected_rows;
            } else {
                return 0;
            }
        }


        public static function unlike_user($dbConnection, $recipientUserID) 
        {
            $sql = "DELETE FROM `Like`
                    WHERE `fromUserID` = ? AND `toUserID` = ?;";

            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("ss", $_SESSION[User::USER_ID], $recipientUserID);
                $stmt->execute();
                return $stmt->affected_rows;
            }
        }

        static function sendNotificationOnUserLike($dbConnection, $recipientUserID) 
        {
            $current_timestamp = date("Y-m-d H:i:s");
            $message = "";

            $sql = "INSERT INTO `Notification` (`fromUserID`, `toUserID`, `message`, `dateSent`, `seen`) 
                            VALUES (?, ?, ?, ?, 0);";

            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("ssss", $_SESSION[User::USER_ID], $recipientUserID, $current_timestamp);
                $stmt->execute();
                return $stmt->affected_rows;
            } else {
                return 0;
            }
        }
    }
?>