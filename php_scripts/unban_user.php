<?php

    session_start();
    require_once("../classes/User.php");
    require_once("../classes/Admin.php");

    if (isset($_SESSION[User::LOGGED_IN]) && $_SESSION[User::IS_ADMIN]) {

        $conn = Database::connect();

        if (isset($_GET[User::USER_ID]) && $_GET[User::USER_ID] != $_SESSION[User::USER_ID]) {
            $userID = $_GET[User::USER_ID];
            Admin::unban_user($conn, $userID);
        }

        $redirectPage = Database::ADMIN_DASHBOARD;
        $conn->close();
    } else {
        $redirectPage = Database::INDEX;
    }

    header("Location: ../" . $redirectPage);
    exit();

?>