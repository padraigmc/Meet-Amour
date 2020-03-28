<?php
    session_start();
    require_once("classes/User.php");
    require_once("classes/Database.php");
    $_SESSION[User::ERROR] = array();
?>