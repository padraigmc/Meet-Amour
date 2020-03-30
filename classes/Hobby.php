<?php 

    class Hobby
    {

        public function get_all_hobbies($dbConnection) {
            $sql = "SELECT `hobbyID`, `hobby` FROM `Hobby`;";
            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->execute();
                $res = $stmt->get_result()->fetch_all();

                
                $stmt->close();
                return $res;
            } else {
                $stmt->close();
                return 0;
            }
        }


        public function get_user_hobbies($dbConnection, $userID) {
            $res = array();
            $hobbyID = $hobby = "";
            $sql = "SELECT `h`.`hobbyID`, `h`.`hobby` 
                    FROM `Hobby` AS `h`, `UserHobby` AS `u` 
                    WHERE `h`.`hobbyID` = `u`.`hobbyID` AND
                            `u`.`userID` = ?;";


            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("s", $userID);
                $stmt->execute();
                $stmt->bind_result($hobbyID, $hobby);
                while ($stmt->fetch()) {
                    $res[$hobby] = $hobbyID;
                }
                
                $stmt->close();
                return $res;
            } else {
                $stmt->close();
                return 0;
            }
        }


        public function set_user_hobbies($dbConnection, $userID, $current_user_hobbies, $new_user_hobbies) {
            $insert_hobby = "INSERT INTO `UserHobby` (`hobbyID`, `userID`) VALUES (?, ?);";
            $delete_hobby = "DELETE FROM `UserHobby` WHERE `hobbyID` = ? AND `userID` = ?;";

            $hobbyID = null;
            $hobbies_to_add = array_diff($new_user_hobbies, $current_user_hobbies);
            $hobbies_to_del = array_diff($current_user_hobbies, $new_user_hobbies);

            var_dump($hobbies_to_add);
            var_dump($hobbies_to_del);

            // remove hobbies in $current_user_hobbies not included in $new_user_hobbies
            if ($stmt = $dbConnection->prepare($delete_hobby)) {
                $stmt->bind_param("ss", $hobbyID, $userID);
                foreach ($hobbies_to_del as $hobbyID) {
                    $stmt->execute();
                }
            }

            // add new hobbies in $new_user_hobbies not included in $current_user_hobbies
            if ($stmt = $dbConnection->prepare($insert_hobby)) {
                $stmt->bind_param("ss", $hobbyID, $userID);

                foreach ($hobbies_to_add as $hobbyID) {
                    $stmt->execute();
                }
            }
            return 1;
        }
    }
    
?>