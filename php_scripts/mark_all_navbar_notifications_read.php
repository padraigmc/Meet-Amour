<?php

    session_start();
    require_once("../classes/User.php");
    require_once("../classes/Notification.php");

    if (isset($_SESSION[User::LOGGED_IN]) && $_SESSION[User::LOGGED_IN]) {
        $conn = Database::connect();

        Notification::set_all_as_seen($conn, $_SESSION[User::USER_ID]);

        if (isset($_GET[Notification::REDIRECT_PAGE])) {
            $redirectPage = $_GET[Notification::REDIRECT_PAGE];
            
        } else {
            $redirectPage = Database::VIEW_PROFILE;
        }
        $conn->close();

    } else {
        $redirectPage = Database::INDEX;
    }
    header("Location: " . $redirectPage);
    exit();

?>