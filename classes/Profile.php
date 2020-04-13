<?php


class Profile {

    public $userID;
    public $fname;
    public $lname;
    public $dob;
    public $age;
    public $gender;
    public $genderID;
    public $seeking;
    public $seekingID;
    public $description;
    public $location;
    public $locationID;
    public $imageFilePath;
    public $hobbies;
    public $lastLogin;

    private $databaseConnection;
    private $errorList;

    private function __construct($databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
        $this->errorList = array();
    }

    public function get_error() {
        return $this->errorList;
    }

    public static function constuct_with_session_variables($databaseConnection) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION[User::USER_ID])) {
            return 0;
        } else {

            $profile = new Profile($databaseConnection);
            
            $profile->userID = $_SESSION[User::USER_ID];
            $profile->fname = $_SESSION[User::FIRST_NAME];
            $profile->lname = $_SESSION[User::LAST_NAME];
            $profile->dob = $_SESSION[User::DATE_OF_BIRTH];
            $profile->age = Profile::calculate_age($_SESSION[User::DATE_OF_BIRTH]);
            $profile->gender = $_SESSION[User::GENDER];
            $profile->genderID = $_SESSION[User::GENDER_ID];
            $profile->seeking = $_SESSION[User::SEEKING];
            $profile->seekingID = $_SESSION[User::SEEKING_ID];
            $profile->description = $_SESSION[User::DESCRIPTION];
            $profile->location = $_SESSION[User::LOCATION];
            $profile->locationID = $_SESSION[User::LOCATION_ID];

            $profile->hobbies = Hobby::get_user_hobbies($profile->databaseConnection, $profile->userID);
            $profile->imageFilePath = Image::get_user_image_filepath($profile->databaseConnection, $profile->userID);

            $profile->dob = explode(" ", $profile->dob)[0];

            return $profile;
        }
    }


    public static function constuct_with_username($databaseConnection, $username) {
        $profile = new Profile($databaseConnection);

        $sql = "SELECT p.`userID`, p.`fname`, p.`lname`, p.`dob`, p.`genderID`, g.`gender`, 
                p.`seekingID`, s.`gender` AS `seeking`, p.`description`, p.`locationID`, l.`location`, `u`.`lastLogin`
            FROM `User` AS `u`
            LEFT JOIN `Profile` AS `p` ON `u`.`userID` = `p`.`userID`
            LEFT JOIN `Gender` AS `g` ON `p`.`genderID` = g.`genderID`
            LEFT JOIN `Gender` AS `s` ON `p`.`seekingID` = s.`genderID`
            LEFT JOIN `Location` AS `l` ON `p`.`locationID` = l.`locationID`
            WHERE u.`username` = ?;";

        if ($stmt = $profile->databaseConnection->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result(
                $profile->userID, 
                $profile->fname, 
                $profile->lname, 
                $profile->dob,
                $profile->genderID, 
                $profile->gender, 
                $profile->seekingID, 
                $profile->seeking, 
                $profile->description, 
                $profile->locationID, 
                $profile->location,
                $profile->lastLogin
            );

            $stmt->fetch();
            $stmt->close();

            $profile->dob = explode(" ", $profile->dob)[0];

            $profile->age = Profile::calculate_age($profile->dob);
            $profile->lastLogin = date("d/m/y", strtotime($profile->lastLogin));
            $profile->imageFilePath = Image::get_user_image_filepath($profile->databaseConnection, $profile->userID);
            $profile->hobbies = Hobby::get_user_hobbies($profile->databaseConnection, $profile->userID);
        }

        if (isset($profile->userID) && $profile->userID > 0) {
            return $profile;
        } else {
            return 0;
        }
    }

    public function store_profile_attributes() {
        if ($this->validate_attributes()) {
            $returnValue = $this->commit_attributes_to_database();
            $this->resolve_foreign_keys();
            if ($this->user_owns_profile()) {
                $this->update_session_variables();
            }
        } else {
            $_SESSION[User::ERROR] = $this->get_error();
            $returnValue = 0;
        }

        return $returnValue;
    }

    public static function calculate_age($dateOfBirth) {
        // if supplied date isn't correctly formatted, return 0 for failure
        if (!$dob_timestamp = strtotime($dateOfBirth))
            return 0;

        $dateOfBirth = date("Y-m-d", $dob_timestamp);
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

    public function is_profile_initialized() {
        return (isset($this->fname)) ? 1 : 0;
    }

    public function user_has_permission_to_edit() {
        return ($this->userID == $_SESSION[User::USER_ID] || $_SESSION[User::IS_ADMIN]);
    }

    public function user_owns_profile() {
        return ($this->userID == $_SESSION[User::USER_ID]);
    }

    private function commit_attributes_to_database() {
        if ($this->user_has_permission_to_edit()) {
            if ($this->is_profile_initialized()) {
                $returnValue = $this->update_existing_profile_in_database();   

            } else {
                $returnValue = $this->add_new_profile_to_database();
            }
        } else {
            $returnValue = 0;
        }

        return $returnValue;
    }

    private function validate_attributes() {
        $max_dob = date("Y-m-d", strtotime("-18 year", time()));
        $min_dob = date("Y-m-d", strtotime("-120 year", time()));
        $success = 1;
        
        if (strlen($this->fname) < 1 || strlen($this->lname) < 1) {
            $this->errorList[] = UserError::NAME_SHORT;
            $success = 0;
        } else if (strlen($this->fname) > 30 || strlen($this->lname) > 30) {
            $this->errorList[] = UserError::NAME_LONG;
            $success = 0;
        }

        if (strlen($this->description) > 255) {
            $this->errorList[] = UserError::DESCRIPTION_LONG;
            $success = 0;
        }

        if ($min_dob >= $this->dob || $this->dob >= $max_dob ) {

            $this->errorList[] = UserError::INVALID_DATE_OF_BIRTH;
            $success = 0;
        }
        return $success;
    }

    private function add_new_profile_to_database() {
        $sql = "INSERT INTO `Profile` (`userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $this->databaseConnection->prepare($sql);
        $stmt->bind_param("ssssssss", 
            $this->userID, 
            $this->fname, 
            $this->lname, 
            $this->dob, 
            $this->genderID, 
            $this->seekingID, 
            $this->description, 
            $this->locationID
        );

        $stmt->execute();
        $ret = $stmt->affected_rows;
        $stmt->close();
        return $ret;
    }

    private function update_existing_profile_in_database() {
        $returnValue = null;
        $sql = "UPDATE `Profile` 
                    SET `fname` = ?, `lname` = ?, `dob` = ?, `genderID` = ?, `seekingID` = ?, `description` = ?, `locationID` = ? 
                    WHERE `userID` = ?;";

        if ($stmt = $this->databaseConnection->prepare($sql)) {
            $stmt->bind_param("ssssssss", 
                $this->fname, 
                $this->lname, 
                $this->dob, 
                $this->genderID, 
                $this->seekingID, 
                $this->description, 
                $this->locationID,
                $this->userID
            );

            $returnValue = $stmt->execute();
            $stmt->close();
        }
        return $returnValue;
    }

    private function resolve_foreign_keys()
        {
            $returnValue = null;
            $sql = "SELECT `gender`.`gender`, `seeking`.`gender` AS `seeking`, `location`.`location`
                    FROM `Profile` AS `profile`
                    LEFT JOIN `Gender` AS `gender` ON `profile`.`genderID` = `gender`.`genderID`
                    LEFT JOIN `Gender` AS `seeking` ON `profile`.`seekingID` = `seeking`.`genderID`
                    LEFT JOIN `Location` AS `location` ON `profile`.`locationID` = `location`.`locationID`
                    WHERE `profile`.`userID` = ?;";

            if ($stmt = $this->databaseConnection->prepare($sql)) {
                $stmt->bind_param("i", $this->userID);
                $stmt->execute();
                $stmt->bind_result(
                    $this->gender,
                    $this->seeking,
                    $this->location
                );

                $returnValue = $stmt->fetch();
                $stmt->close();
            }
            return $returnValue;
        }

    private function update_session_variables() {
        $_SESSION[User::USER_ID] = $this->userID;
        $_SESSION[User::FIRST_NAME] = $this->fname;
        $_SESSION[User::LAST_NAME] = $this->lname;
        $_SESSION[User::DATE_OF_BIRTH] = $this->dob;
        $_SESSION[User::GENDER] = $this->gender;
        $_SESSION[User::GENDER_ID] = $this->genderID;
        $_SESSION[User::SEEKING] = $this->seeking;
        $_SESSION[User::SEEKING_ID] = $this->seekingID;
        $_SESSION[User::DESCRIPTION] = $this->description;
        $_SESSION[User::LOCATION] = $this->location;
        $_SESSION[User::LOCATION_ID] = $this->locationID;
    }


}

?>