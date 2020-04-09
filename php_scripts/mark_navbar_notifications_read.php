<?php

    session_start();
    require_once("../classes/User.php");
    require_once("../classes/Notification.php");

    $conn = Database::connect();

    if (isset($_GET[Notification::FROM_USER_ID])) {
        $fromUserID = $_GET[Notification::FROM_USER_ID];
        $toUserID = $_SESSION[User::USER_ID];
        Notification::set_as_seen($conn, $fromUserID, $toUserID);
    }

    if (isset($_GET[Notification::REDIRECT_PAGE])) {
        header("Location: " . $_GET[Notification::REDIRECT_PAGE]);
    } else {
        header("Location: " . Database::VIEW_PROFILE);
    }
    $conn->close();
    exit();

?>