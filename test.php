<?php


    require_once("init.php");
    require_once("classes/Profile.php");
    require_once("classes/Image.php");

    $conn = Database::connect();
    
    $supported_formats = array("jpg", "png", "jpeg", "gif");
    $img = "png";


    $profile = Profile::constuct_with_session_variables($conn);
    var_dump($profile);



    $conn->close();

    
?>
