<?php


    require_once("init.php");
    require_once("classes/Profile.php");
    require_once("classes/Image.php");

    $conn = Database::connect();
    
    $supported_formats = array("jpg", "png", "jpeg", "gif");
    $img = "png";

    echo in_array($img, $supported_formats);


    $conn->close();

    
?>
