<?php


    require_once("init.php");
    require_once("classes/Profile.php");
    require_once("classes/Image.php");

    $conn = Database::connect();


    echo strlen("this is a test");


    $conn->close();

    
?>
