<?php
    session_start();
    require_once("classes/User.php");
    require_once("classes/Database.php");
    require_once("classes/Like.php");
    require_once("classes/Notification.php");

    $_SESSION[User::ERROR] = array();
?>