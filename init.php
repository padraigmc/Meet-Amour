<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once("classes/User.php");
    require_once("classes/Profile.php");
    require_once("classes/Database.php");
    require_once("classes/Like.php");
    require_once("classes/Notification.php");
?>