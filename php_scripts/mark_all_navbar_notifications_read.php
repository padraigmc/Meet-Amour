<?php

    session_start();
    require_once("../classes/User.php");
    require_once("../classes/Notification.php");

    $conn = Database::connect();

    Notification::set_all_as_seen($conn, $_SESSION[User::USER_ID]);

    if (isset($_GET[Notification::REDIRECT_PAGE])) {
        header("Location: " . $_GET[Notification::REDIRECT_PAGE]);
    } else {
        header("Location: " . Database::VIEW_PROFILE);
    }
    $conn->close();
    exit();

?>