<?php

    class Search
    {
        private $currentPageNumber;
        private $numberOfSearchResults;
        private $indexOfFirstResult;
        private $pageURLS = array();
        private $databaseConnection;
        private $moreResultsThanDisplayed = false;
        
        const NUM_RESULTS_IN_A_PAGE = 10;
        const RESULTS_PAGE_NUMBER = "pageNumber";
        const SEARCH_TEXT = "search_text";
        const GENDER_ID = "genderID";
        const LOCATION_ID = "locationID";
        const MIN_AGE = "minAge";
        const MAX_AGE = "maxAge";
        

        public function __construct($databaseConnection, $currentPageNumber = 1)
        {
            $this->databaseConnection = $databaseConnection;
            $this->currentPageNumber = $currentPageNumber;
            $this->indexOfFirstResult = ($currentPageNumber * $this::NUM_RESULTS_IN_A_PAGE) - $this::NUM_RESULTS_IN_A_PAGE;
        }

        public function profile_search($textInput, $gender, $location , $min_age, $max_age) 
        {
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
                    LIMIT ? OFFSET ?;";
            $profiles = NULL;
            $resultLimit = $this::NUM_RESULTS_IN_A_PAGE + 1;
            $resultOffset = $this->indexOfFirstResult;
            
            $textInput= htmlspecialchars($textInput);
            $textInput = trim($textInput);
            $textInput = str_replace(array("?", "%"), "", $textInput);
            $textInput = "%" . $textInput . "%";

            $date_min = date("Y-m-d", strtotime("-" . ($max_age+1) . " year +1 day", time())) . " 00:00:00";
            $date_max = date("Y-m-d", strtotime("-" . $min_age . " year", time())) . " 23:59:59";

            if ($stmt = $this->databaseConnection->prepare($sql)) {
                $stmt->bind_param("sssssii", $textInput, $gender, $location, $date_min, $date_max, $resultLimit, $resultOffset);
                $stmt->execute();
                $result = $stmt->get_result();

                $numRowsReturned = $result->num_rows;
                $this->moreResultsThanDisplayed = $this->more_results_for_next_page($numRowsReturned);

                $profiles = array();
                while(($row = $result->fetch_assoc()) && sizeof($profiles) < $this::NUM_RESULTS_IN_A_PAGE) {
                    $profiles[] = $row;
                }
    
                $stmt->close();
            }

            return $profiles;
        }
        
        public function get_next_page_url() {
            if ($this->moreResultsThanDisplayed) {
                $currentURL = $_SERVER["REQUEST_URI"];
                $getVairable = "&" . $this::RESULTS_PAGE_NUMBER . "=" . ($this->currentPageNumber + 1);
                $generatedURL = $currentURL . $getVairable;
            } else {
                $generatedURL = null;
            }

            return $generatedURL;
        }

        public function get_previous_page_url() {
            if ($this->currentPageNumber > 1) {
                $currentURL = $_SERVER["REQUEST_URI"];
                $getVairable = "&" . $this::RESULTS_PAGE_NUMBER . "=" . ($this->currentPageNumber - 1);
                $generatedURL = $currentURL . $getVairable;
            } else {
                $generatedURL = null;
            }

            return $generatedURL;
        }

        private function more_results_for_next_page($numRowsReturned) {
            if ($numRowsReturned > $this::NUM_RESULTS_IN_A_PAGE) {
                return true;
            } else {
                return false;
            }
        }

    }


?>