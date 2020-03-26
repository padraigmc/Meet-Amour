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

        // not needed?
        const USERNAME = "username"; // not needed?
        const EMAIL = "email";
        const PASSWORD = "password";
        const DATE_CREATED = "dateCreated";
        const LAST_LOGIN = "lastLogin";
        const FIRST_NAME = "fname";
        const LAST_NAME = "lname";
        const DATE_OF_BIRTH = "dob";
        const GENDER = "gender";
        const SEEKING = "seeking";
        const DESCRIPTION = "description";
        const LOCATION = "location";

        const USER_IMAGES = "user_images/";
     
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
        public static function get_all_user_attributes($username) {
            $userID = $email = $password = $dateCreated = $lastLogin = $isAdmin = $isBanned = $isDeactivated = $isVerified = "";
            $vals = array();
            $sql = "SELECT `userID`, `email`, `username`, `passwordHash`, `dateCreated`, `lastLogin`, `isAdmin`, `isBanned`, `isDeactivated`, `isVerified` 
                    FROM `User` 
                    WHERE `username` = ?;";

            try {

                // connect to database, terminate script on failure
                $conn = Database::connect();

                // prepare, bind and execute sql statement
                $stmt = $conn->prepare($sql);
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
                    $vals[Self::USER_ID] = $userID;
                    $vals[Self::USERNAME] = $username;
                    $vals[Self::EMAIL] = $email;
                    $vals[Self::PASSWORD] = $password;
                    $vals[Self::DATE_CREATED] = $dateCreated;
                    $vals[Self::LAST_LOGIN] = $lastLogin;
                    $vals[Self::IS_ADMIN] = $isAdmin;
                    $vals[Self::IS_BANNED] = $isBanned;
                    $vals[Self::IS_DEACTIVATED] = $isDeactivated;
                    $vals[Self::IS_VERIFIED] = $isVerified;

                    return $vals;
                } else {
                    return 0;
                }
            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            } finally {
                $stmt->close();
                $conn->close();
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
        public static function get_user_attribute($username, $attribute) {
            $sql = "SELECT {$attribute} FROM `User` WHERE `username` = ?;";

            try {
                // connect to database
                $conn = Database::connect();

                // prepare, bind and execute statement
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                if (!$stmt->execute()) return 0;

                // statement was succesful, bind result
                if (!$stmt->bind_result($val)) return 0;
                
                // fetch result and return it
                if ($stmt->fetch()) {
                    return $val;
                } else {
                    return 0;
                }
            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            } finally {
                $stmt->close();
                $conn->close();
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
        public static function get_user_attributes_equal_to($attribute, $value) {
            $sql = "SELECT {$attribute} FROM `User` WHERE {$attribute} = ?;";
            $arr = array();

            try {
                // connect to database, terminate script on failure
                $conn = Database::connect();

                // prepare, bind ad execute statement
                $stmt = $conn->prepare($sql);
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
                $stmt->close();
                $conn->close();
            }
        }

        /*
            *   Query database for all attributes from Profile table relating to the supplied username.
            *   Sets qeury results as session variables
            *
            *   $username   -   username of user account to be queried
            *
            *   return      -   zero on failure, one on success
            */
        public static function get_all_profile_attributes($userID) {
            $sql = "SELECT p.`userID`, p.`fname`, p.`lname`, p.`dob`, g.`gender`, s.`gender` AS `seeking`, p.`description`, l.`location`
                    FROM `Profile` AS `p`, 
                            `Gender` AS `g`, 
                            `Gender` AS `s`, 
                            `Location` AS `l`
                    WHERE p.`userID` = ? AND 
                            p.`genderID` = g.`genderID` AND 
                            p.`seekingID` = s.`genderID` AND
                            p.`locationID` = l.`locationID`;";

            try {
                // connect to database, terminate script on failure
                $conn = Database::connect();

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $userID);
                
                // execute statement, terminate script on failure
                if (!$stmt->execute()) return 0;

                // bind variables for fetch
                if (!$stmt->bind_result($userID, $firstName, $lastName, $dob, $gender, $seeking, $description, $location))
                    return 0;

                // fetch values and save to array
                if ($stmt->fetch()) {
                    $vals = array();
                    // Populate array to be returned
                    $vals[Self::USER_ID] = $userID;
                    $vals[Self::FIRST_NAME] = $firstName;
                    $vals[Self::LAST_NAME] = $lastName;
                    $vals[Self::DATE_OF_BIRTH] = $dob;
                    $vals[Self::GENDER] = $gender;
                    $vals[Self::SEEKING] = $seeking;
                    $vals[Self::DESCRIPTION] = $description;
                    $vals[Self::LOCATION] = $location;

                    return $vals;
                } else {
                    return 0;
                }
            } catch (Throwable $t) {
                echo $t->getMessage();
            } finally {
                $stmt->close();
                $conn->close();
            }
        }

        public static function get_all_genders() {
            try {
                // connect to database, terminate script on failure
                $conn = Database::connect();
        
                // Query database for below statement, return mysqli result object
                $sql = "SELECT `genderID`, `gender` FROM `Gender`";
                return $conn->query($sql);
            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            }
    
        }


        public static function get_all_locations() {
            try {
                // connect to database, terminate script on failure
                $conn = Database::connect();
        
                // Query database for below statement, return mysqli result object
                $sql = "SELECT `locationID`, `location` FROM `Location`";
                return $conn->query($sql);
            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            }
    
        }


//  ======================================================================================================
//                                                  Setters
//  ======================================================================================================


        /*
            *   Query database for values to be set as session vars
            *   The values queried should be user attributes that are highly unlikely to change.
            *   
            *
            *   $username   -   username of user account to be queried
            *
            *   return      -   zero on failure, one on success
            */
        public static function set_session_vars($username) {
            $sql = "SELECT `userID`, `isAdmin`, `isBanned`, `isDeactivated`, `isVerified`
                    FROM `User` 
                    WHERE `username` = ?;";

            try {

                // connect to database, terminate script on failure
                $conn = Database::connect();

                // prepare, bind and execute sql statement
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                if (!$stmt->execute()) return 0;
                
                // if sql statement is successful, bind parameters
                if (!$stmt->bind_result($_SESSION[Self::USER_ID],
                                        $_SESSION[Self::IS_ADMIN],
                                        $_SESSION[Self::IS_BANNED],
                                        $_SESSION[Self::IS_DEACTIVATED],
                                        $_SESSION[Self::IS_VERIFIED]
                )) 
                    return 0; 

                // fetch value(s) and save to array
                // only one row is returned, so we don't need to iterate throw this to get column values
                if ($stmt->fetch()) {
                    return 1; 
                } else { 
                    return 0; 
                }

            } catch (Throwable $t) {
                echo $t->getMessage();
                return 0;
            } finally {
                $stmt->close();
                $conn->close();
            }
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
            if (isset($_SESSION[Self::LOGGED_IN]) && $_SESSION[Self::LOGGED_IN] == 1) {
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
        public static function update_user_attribute($username, $attribute, $newValue) {
            $sql = "UPDATE `User` SET {$attribute} = ?  WHERE `username` = ?;";

            try {
                // connect to database, terminate script on failure
                $conn = Database::connect();

                // prepare and bind statement
                $stmt = $conn->prepare($sql);
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
                $conn->close();
            }
        }

        public static function set_profile_attributes($userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID, $newUser = 0) {
            // test user inputted string lengths
            if (strlen($fname) < 1) $_SESSION[Self::ERROR][] = UserError::NAME_SHORT;
            if (strlen($fname) > 30) $_SESSION[Self::ERROR][] = UserError::NAME_LONG;
            if (strlen($description) > 255) $_SESSION[Self::ERROR][] = UserError::DESCRIPTION_LONG;

            // if the error session variable is not empty, return a failure
            if (!empty($_SESSION[Self::ERROR]))
                return 0;

            try {            

                // Open connection
                $conn = Database::connect();

                echo $newUser;
                echo "<BR>";
                
                // if a new row is to be inserted
                if ($newUser) {
                    // set sql statement
                    $sql = "INSERT INTO `Profile` (`userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
                
                    // prepare bind and execute prepared statement
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssssss", $userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID);

                    var_dump($stmt);

                // update a row
                } else {
                    // set sql statement
                    $sql = "UPDATE `Profile` 
                            SET `fname` = ?, `lname` = ?, `dob` = ?, `genderID` = ?, `seekingID` = ?, `description` = ?, `locationID` = ? 
                            WHERE `userID` = ?;";

                    // prepare bind and execute prepared statement
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssssss", $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID, $userID);
                }

                // if statement execution is a success, return 1, else 0
                if ($stmt->execute() && $stmt->affected_rows == 1) {
                    echo "execute 1";
                    return 1;
                } else {
                    echo $sql;
                    echo $stmt->error;
                    return 0;
            }

            } catch (Throwable $t) {
                echo $t->getMessage();
            }
        }


//  ======================================================================================================
//                                                  Methods
//  ======================================================================================================

        public static function register($email, $username, $password, $passwordConfirm) {
            $sql = "INSERT INTO `User` (`email`, `username`, `passwordHash`, `dateCreated`, `lastLogin` ) VALUES (?, ?, ?, ?, ?);";
            $date = date("Y-m-d H:i:s");

			// verify user inputs, adds any errors to $_SESSION["error"]
			Verify::verify_email_register($email);
			Verify::verify_username_register($username);
			Verify::verify_password_register($password, $passwordConfirm);
      
			// if no errors were found
			if (empty($_SESSION[Self::ERROR])) {

				// Check connection
				if (!$conn = Database::connect()) {
					die("Connection failed: " . $conn->connect_error);
				}

				// hash password
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
            
                try {
                    // prepare, bind and execute
                    $stmt = $conn->prepare($sql);
                     if (!$stmt->bind_param("sssss", $email, $username, $password_hash, $date, $date)) return 0;
                
                    // if sql query is true, return userID else 0
                    if ($stmt->execute()) {
                        User::set_session_vars($username);
                        $_SESSION[self::LOGGED_IN] = 1; // set session variable logged in
                        return 1;
                    } else {
                        return 0;
                    }

                } catch (Throwable $t) {
                    echo $t->getMessage();
                    return 0;
                } finally {
                    $stmt->close();
                    $conn->close();
                }
            } else {
                // ==================================================== to delete, testing purposes only
                var_dump($_SESSION[Self::ERROR]);
            }
        }

        public static function profile_set_up($userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID) {
            // test user inputted string lengths
            if (strlen($fname) < 1) $_SESSION[Self::ERROR][] = UserError::NAME_SHORT;
            if (strlen($fname) > 30) $_SESSION[Self::ERROR][] = UserError::NAME_LONG;
            if (strlen($description) > 255) $_SESSION[Self::ERROR][] = UserError::DESCRIPTION_LONG;
            
            
            try {
                // if no errors were found
                if (empty($_SESSION[Self::ERROR])) {

                    // declare variables
                    $sql = "INSERT INTO `Profile` (`userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
                    

                    // Open connection
                    $conn = Database::connect();
                
                    echo "-" . $dob . "-<BR>";
                    // prepare bind and execute prepared statement
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssssss", $userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID);
                    if ($stmt->execute()) {
                        return 1;
                    } else {
                        return 0;
                    }

                } else {
                    return 0;
                }
            } catch (Throwable $t) {
                echo $t->getMessage() . " " . $t->getLine();
                return 0;
            } finally {
                $stmt->close();
                $conn->close();
            }
        }

        public static function login($username, $password) {

            // test login, if successful set session variables
            if (Verify::verify_login($username, $password)) {
                User::set_session_vars($username);

                // add error to list if user account is banned
                if ($_SESSION[User::IS_BANNED]) {
                    $_SESSION[User::ERROR][] = UserError::ACCOUNT_BANNED;
                }
            }
            
            // if no errors found, set loggedIn session var and return 1, else return 0
            if (empty($_SESSION[Self::ERROR])) {
                $_SESSION[User::LOGGED_IN] = 1;
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
        public static function populate_form_input($value, $placeholder_string) {
            if (isset($value)) {
                return "value=\"" . $value . "\"";
            } else {
                return "placeholder=\"" . $placeholder_string . "\"";
            }
        }

        public static function get_user_image_path($userID) {
            if (!isset($userID) || $userID < 1)
                return 0;

            $fileName = "";
            $sql = "SELECT `fileName` 
                    FROM `Photo` 
                    WHERE `userID` = ?;";
            
            $conn = Database::connect();
            if ($stmt = $conn->prepare($sql)) {
                // params and execute
                $stmt->bind_param("s", $userID);
                $stmt->execute(); 

                // get result
                $stmt->bind_result($fileName);
                $stmt->fetch();
                return (User::USER_IMAGES . $fileName);
            } else {
                return 0;
            }
        }


        public static function delete_user_image($userID) {
            if (!isset($userID) || $userID < 1)
                return 0;

            // if the user doesn't have an image, return 0
            if (!($filePath = User::get_user_image_path($userID))) {
                return 0;
            }

            $sql = "DELETE FROM `Photo` 
                    WHERE `fileName` = ?;";
            
            if (!$conn = Database::connect())
                return 0;

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $$filePath);
                $stmt->execute();
                unlink($filePath);
                return 1;
            } else {
                return 0;
            }
        }


        public static function upload_user_image($userID, $fileInputName) {
            $dateUploaded = date("Y-m-d H:i:s");
            $milliseconds = round(microtime(true) * 1000);
            $target_dir = User::USER_IMAGES;

            // if the user already has an image, delete it
            User::delete_user_image($userID);

            // get full filename incl. extension
            $ext = pathinfo($_FILES[$fileInputName]["name"], PATHINFO_EXTENSION);
            $filename_orig = pathinfo($_FILES[$fileInputName]["name"], PATHINFO_FILENAME);
            $filename = substr($filename_orig, 0, 30) . "_" . $milliseconds . "." . $ext;
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

                $conn = Database::connect();
                $stmt = $conn->prepare($sql);
                if (!$stmt->bind_param("sss", $userID, $filename, $dateUploaded)) 
                    return 0;
        
                // if sql query is true, return userID else 0
                if ($stmt->execute()) {
                    return 1;
                } else {
                    return 0;
                }
                

            } else {
                $_SESSION[User::ERROR][] = UserError::GENERAL_ERROR;
                $conn->close();
                return 0;
            }
            
            $conn->close();
        }
    }
?>