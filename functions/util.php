<?php

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

?>