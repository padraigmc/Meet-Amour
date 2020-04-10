<?php

    class Admin
    {

        public static function delete_user($databaseConnection, $userID) {
            $sql = "DELETE FROM User
                WHERE `userID` = ?;";

            if ($stmt = $databaseConnection->prepare($sql)) {
                $stmt->bind_param("s", $userID);
                $stmt->execute();
                return $stmt->affected_rows;
            } else {
                return 0;
            }
        }
        
        public static function ban_user($databaseConnection, $userID) {
            $sql = "UPDATE `User` 
                SET `isBanned` = 1 
                WHERE `userID` = ? AND `isBanned` = 0;";

            if ($stmt = $databaseConnection->prepare($sql)) {
                $stmt->bind_param("s", $userID);
                $stmt->execute();
                return $stmt->affected_rows;
            } else {
                return 0;
            }
        }

        public static function unban_user($databaseConnection, $userID) {
            $sql = "UPDATE `User` 
                SET `isBanned` = 0 
                WHERE `userID` = ? AND `isBanned` = 1;";

            if ($stmt = $databaseConnection->prepare($sql)) {
                $stmt->bind_param("s", $userID);
                $stmt->execute();
                return $stmt->affected_rows;
            } else {
                return 0;
            }
        }
    }


?>