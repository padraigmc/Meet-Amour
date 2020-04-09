<?php

class Notification
{


    public static function add_on_user_like($dbConnection, $recipientUserID) 
    {
        $current_timestamp = date("Y-m-d H:i:s");
        $message = $_SESSION[User::FIRST_NAME] . " liked you!";

        $sql = "INSERT INTO `Notification` (`fromUserID`, `toUserID`, `message`, `dateSent`, `seen`) 
                        VALUES (?, ?, ?, ?, 0);";

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("ssss", $_SESSION[User::USER_ID], $recipientUserID, $message, $current_timestamp);
            $stmt->execute();
            return $stmt->affected_rows;
        } else {
            return 0;
        }
    }

    public static function get_current_user_notifications($dbConnection, $maxNumberOfNotifications = 10)
    {
        $sql = "SELECT `Notification`.`fromUserID`, `User`.`username` AS `fromUsername`, concat(`Profile`.`fname`, `Profile`.`lname`) AS `name`, `Notification`.`toUserID`, `Notification`.`message`, `Notification`.`dateSent`, `Notification`.`seen`
                    FROM `Notification`
                    LEFT JOIN `User` ON `User`.`userID` = `Notification`.`fromUserID`
                    LEFT JOIN `Profile` ON `Profile`.`userID` = `Notification`.`toUserID`
                    WHERE  `toUserID` = ?
                    ORDER BY `Notification`.`seen` = 0 DESC, `Notification`.`dateSent` DESC
                    LIMIT ?;";
                    
        $notifications = null;

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("ss", $_SESSION[User::USER_ID], $maxNumberOfNotifications);
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                $notifications[] = $row;
            }
        }
        
        return $notifications;
    }

    public static function get_unseen_user_notifications($dbConnection, $maxNumberOfNotifications = 3)
    {
        $sql = "SELECT `Notification`.`fromUserID`, `User`.`username` AS `fromUsername`, concat(`Profile`.`fname`, ' ', `Profile`.`lname`) AS `name`, `Notification`.`toUserID`, `Notification`.`message`, `Notification`.`dateSent`, `Notification`.`seen`
                    FROM `Notification`
                    LEFT JOIN `User` ON `User`.`userID` = `Notification`.`fromUserID`
                    LEFT JOIN `Profile` ON `Profile`.`userID` = `Notification`.`fromUserID`
                    WHERE  `toUserID` = ? AND `Notification`.`seen` = 0
                    ORDER BY `Notification`.`dateSent` DESC
                    LIMIT ?;";
        $notifications = null;

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("ss", $_SESSION[User::USER_ID], $maxNumberOfNotifications);
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                $notifications[] = $row;
            }
        }
        
        return $notifications;
    }



}

?>