<?php
class Suggest
{

    public static function suggest_matches($dbConnection, $userID) {
        $sql = "SELECT `Profile`.`userID`, `User`.`username`, concat(`Profile`.`fname`, ' ', `Profile`.`lname`) as `name`, 
                    `Profile`.`dob`, `Gender`.`gender`, `Profile`.`description`, `Location`.`location`, `Photo`.`filename`
                FROM Profile
                LEFT JOIN `User` on `Profile`.`userID` = `User`.`userID`
                LEFT JOIN `Gender` on `Profile`.`genderID` = `Gender`.`genderID`
                LEFT JOIN `Location` on `Profile`.`locationID` = `Location`.`locationID`
                LEFT JOIN `Photo` on `Profile`.`userID` = `Photo`.`userID`
                LEFT JOIN `Like` on ? = `Like`.`fromUserID` AND `Profile`.`userID` = `Like`.`toUserID`
                LEFT JOIN (
                    SELECT `uh1`.`userID`, COUNT(`uh2`.`hobbyID`) AS `mutualHobbies`
                    FROM UserHobby AS `uh1`
                    INNER JOIN `UserHobby` AS `uh2`
                    ON `uh2`.`userID` = ? AND `uh2`.`hobbyID` = `uh1`.`hobbyID`
                    GROUP BY `uh1`.`userID`
                ) as `UserHobby` ON `Profile`.`userID` = `UserHobby`.`userID`
                WHERE `Profile`.`userID` != ? AND `Profile`.`genderID` LIKE ? AND `Like`.`dateLiked` IS NULL
                ORDER BY `Profile`.`locationID` = ? DESC, `UserHobby`.`mutualHobbies` DESC
                LIMIT 6;";
        $profiles = null;
    
        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("sssss",
                $userID, 
                $userID, 
                $userID, 
                $_SESSION[User::SEEKING_ID], 
                $_SESSION[User::LOCATION_ID]
            );
            $stmt->execute();
    
            $result = $stmt->get_result();
            $profiles = array();
    
            while($row = $result->fetch_assoc()) {
                $profiles[] = $row;
            }
    
            $stmt->close();
        }
        return $profiles;
    }  
}


?>