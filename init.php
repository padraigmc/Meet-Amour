<?php
    session_start();
    require_once("classes/User.php");
    $_SESSION[User::ERROR] = array();
?>