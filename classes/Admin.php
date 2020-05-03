<?php


    class Admin
    {

        public static function get_admin_users($databaseConnection) {
            $sql = "SELECT `p`.`userID`, `u`.`username`, concat(`p`.`fname`, ' ', `p`.`lname`) AS `name`, `p`.`dob`,  `l`.`location`, `u`.`lastLogin`
            FROM `Profile` AS `p`
            LEFT JOIN `User` AS `u` ON `p`.`userID`=`u`.`userID`
            LEFT JOIN `Location` AS `l` ON `p`.`locationID`=`l`.`locationID`
            WHERE `u`.`isAdmin` = 1
            ORDER BY `u`.`lastLogin` DESC;";
            $users = array();

            $result = mysqli_query($databaseConnection, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }
            }

            return $users;
        }

        public static function get_banned_users($databaseConnection) {
            $sql = "SELECT `p`.`userID`, `u`.`username`, concat(`p`.`fname`, ' ', `p`.`lname`) AS `name`, `p`.`dob`, `u`.`email`,  `l`.`location`, `u`.`lastLogin`
            FROM `Profile` AS `p`
            LEFT JOIN `User` AS `u` ON `p`.`userID`=`u`.`userID`
            LEFT JOIN `Location` AS `l` ON `p`.`locationID`=`l`.`locationID`
            WHERE `u`.`isBanned` = 1
            ORDER BY `u`.`lastLogin` DESC;";
            $users = array();

            $result = mysqli_query($databaseConnection, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $users = array();
                while($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }
            }

            return $users;
        }

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