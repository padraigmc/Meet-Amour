<?php

class Notification
{

    const FROM_USER_ID = "fromUserID";
    const FROM_USERNAME = "fromUsername";
    const MESSAGE = "message";
    const DATE_SENT = "dateSent";
    const SEEN = "seen";
    const REDIRECT_PAGE = "redirectPage";
    const MARK_ALL_SEEN = "markAllSeen";


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

    public static function get_all_notifications($dbConnection, $maxNumberOfNotifications = 10)
    {
        $sql = "SELECT `Notification`.`fromUserID`, `User`.`username` AS `fromUsername`, concat(`Profile`.`fname`, ' ', `Profile`.`lname`) AS `name`, `Notification`.`toUserID`, `Notification`.`message`, `Notification`.`dateSent`, `Notification`.`seen`
                    FROM `Notification`
                    LEFT JOIN `User` ON `User`.`userID` = `Notification`.`fromUserID`
                    LEFT JOIN `Profile` ON `Profile`.`userID` = `Notification`.`fromUserID`
                    WHERE  `toUserID` = ?
                    ORDER BY `Notification`.`seen` = 0 DESC, `Notification`.`dateSent` DESC
                    LIMIT ?;";
                    
        $notifications = null;

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("ss", $_SESSION[User::USER_ID], $maxNumberOfNotifications);
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                $dateSent = $row[Notification::DATE_SENT];
                $row[Notification::DATE_SENT] = Notification::format_datetime($dateSent);
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
                $dateSent = $row[Notification::DATE_SENT];
                $row[Notification::DATE_SENT] = Notification::format_datetime($dateSent);
                $notifications[] = $row;
            }
        }
        
        return $notifications;
    }

    public static function set_as_seen($dbConnection, $fromUserID, $toUserID)
    {
        $sql = "UPDATE `Notification` SET `seen` = 1  WHERE `fromUserID` = ? AND `toUserID` = ?;";

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("ss", $fromUserID, $toUserID);
            $stmt->execute();
            return $stmt->affected_rows;
        } else {
            return 0;
        }
    }

    public static function set_all_as_seen($dbConnection, $toUserID)
    {
        $sql = "UPDATE `Notification` SET `seen` = 1  WHERE  `toUserID` = ?;";

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("s", $toUserID);
            $stmt->execute();
            return $stmt->affected_rows;
        } else {
            return 0;
        }
    }

    private static function format_datetime($datetime) {
        return date("d/m/y H:m", strtotime($datetime));
    }


}

?>