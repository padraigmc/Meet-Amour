<?php

require_once("Notification.php");

class Like
{

    public static function check_like_status($dbConnection, $recipientUserID) 
        {
            $sql = "SELECT `toUserID`
                    FROM `Like`
                    WHERE `fromUserID` = ? AND `toUserID` = ?;";

            // prepare, bind and execute statement
            if ($stmt = $dbConnection->prepare($sql)) {
                $stmt->bind_param("ss", $_SESSION[User::USER_ID], $recipientUserID);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows() == 1) {
                    $stmt->close();
                    return 1;
                }
            } else {
                return 0;
            }
        }

    public static function like_user($dbConnection, $recipientUserID) 
    {
        if (Self::add_like_to_database($dbConnection, $recipientUserID)) {
            $success = Notification::add_on_user_like($dbConnection, $recipientUserID);
        } else {
            $success = 0;
        }
        return $success;
    }

    private static function add_like_to_database($dbConnection, $recipientUserID)
    {
        $current_timestamp = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `Like` (`fromUserID`, `toUserID`, `dateLiked`) 
                        VALUES (?, ?, ?);";

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("sss", $_SESSION[User::USER_ID], $recipientUserID, $current_timestamp);
            $stmt->execute();
            return $stmt->affected_rows;
        } else {
            return 0;
        }
    }

    public static function unlike_user($dbConnection, $recipientUserID) 
    {
        $sql = "DELETE FROM `Like`
                WHERE `fromUserID` = ? AND `toUserID` = ?;";

        if ($stmt = $dbConnection->prepare($sql)) {
            $stmt->bind_param("ss", $_SESSION[User::USER_ID], $recipientUserID);
            $stmt->execute();
            return $stmt->affected_rows;
        }
    }


}

?>