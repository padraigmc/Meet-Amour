<?php
    session_start();
    require_once("classes/Verify.php");
    require_once("classes/User.php");

    Verify::redirect_not_logged_in();
   
    User::logout();
?>