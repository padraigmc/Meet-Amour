<?php 

    class Hobby
    {

        public static function get_all_hobbies($dbConnection) {
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


        public static function get_user_hobbies($dbConnection, $userID) {
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
                return 0;
            }
        }


        public static function set_user_hobbies($dbConnection, $userID, $current_user_hobbies, $new_user_hobbies) {
            $hobbies_to_add = array_diff($new_user_hobbies, $current_user_hobbies);
            $hobbies_to_delete = array_diff($current_user_hobbies, $new_user_hobbies);
            $returnValue = 1;

            if (!empty($hobbies_to_delete))
                $returnValue = self::delete_old_user_hobbies($dbConnection, $userID, $hobbies_to_delete);
            
            if (!empty($hobbies_to_add))
                $returnValue = self::insert_new_user_hobbies($dbConnection, $userID, $hobbies_to_add);
            
            return $returnValue;
        }

        private static function insert_new_user_hobbies($dbConnection, $userID, $hobbies_to_add) {
            $sql = "INSERT INTO `UserHobby` (`hobbyID`, `userID`) VALUES (?, ?);";

            $hobbyID = null;
            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("ss", $hobbyID, $userID);
                foreach ($hobbies_to_add as $hobbyID) {
                    if (!$stmt->execute())
                        return 0;
                }
            }
            return 1;
        }

        private static function delete_old_user_hobbies($dbConnection, $userID, $hobbies_to_delete) {
            $sql = "DELETE FROM `UserHobby` WHERE `hobbyID` = ? AND `userID` = ?;";

            $hobbyID = null;
            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("ss", $hobbyID, $userID);
                foreach ($hobbies_to_delete as $hobbyID) {
                    if (!$stmt->execute())
                        return 0;
                }
            }
            return 1;
        }

    }
    
?>