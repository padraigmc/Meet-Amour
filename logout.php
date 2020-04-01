<?php
    session_start();
    require_once("classes/User.php");

    User::logout();
?>