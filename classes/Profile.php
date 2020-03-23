<?php

    class Profile
    {

        
        /*
            *   Query database for all attributes from Profile table relating to the supplied userID and sets all resulting fields as session variables
            *
            *   $userID     -   username of user account to be queried
            *
            *   return      -   zero on failure
            */
        function get_all_profile_attributes($userID) {
            $sql = "SELECT `userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID` 
                    FROM `Profile` 
                    WHERE `userID` = ?;";

            // if a session hasn't already been started, start one
            if (session_status() == PHP_SESSION_NONE)
                session_start();

            // connect to database, terminate script on failure
            if (!$conn = Database::connect())
                return 0;

            // prepare and bind statement
            $selectAttribute = $conn->prepare($sql);
            $selectAttribute->bind_param("s", $userID);
            
            // execute statement, terminate script on failure
            if (!$selectAttribute->execute())
                return 0;

            // bind variables to prepared statement
            if (!$selectAttribute->bind_result(
                                                $_SESSION["userID"], 
                                                $_SESSION["fname"], 
                                                $_SESSION["lname"],
                                                $_SESSION["dob"], 
                                                $_SESSION["genderID"], 
                                                $_SESSION["seekingID"], 
                                                $_SESSION["description"], 
                                                $_SESSION["locationID"]
                                            )) {
                return 0;    
            }

            // fetch value(s) and save to array
            if (!$selectAttribute->fetch()) {
                return 0;
            } else {        
                return 1;
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
    }
?>