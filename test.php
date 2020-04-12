<?php


    require_once("init.php");
    require_once("classes/Profile.php");

    $conn = Database::connect();


    echo $_SERVER["REQUEST_URI"];



    $conn->close();

    
?>
