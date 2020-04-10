<?php

    session_start();
    require_once("../classes/User.php");
    require_once("../classes/Notification.php");

    if (isset($_SESSION[User::LOGGED_IN]) && $_SESSION[User::LOGGED_IN]) {

        $conn = Database::connect();

        if (isset($_GET[Notification::FROM_USER_ID])) {
            $fromUserID = $_GET[Notification::FROM_USER_ID];
            $toUserID = $_SESSION[User::USER_ID];
            Notification::set_as_seen($conn, $fromUserID, $toUserID);
        }

        if (isset($_GET[Notification::REDIRECT_PAGE])) {
            $redirectPage = $_GET[Notification::REDIRECT_PAGE];
        } else {
            $redirectPage = Database::VIEW_PROFILE;;
        }
        $conn->close();
    } else {
        $redirectPage = Database::INDEX;
    }  
    header("Location: " . $redirectPage);
    exit();

?>