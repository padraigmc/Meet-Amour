<?php


    require_once("init.php");
    require_once("classes/Profile.php");
    require_once("classes/Admin.php");

    $conn = Database::connect();

    include("snippets/navbar.php");


    $conn->close();

    
?>
