<?php


    require_once("init.php");
    require_once("classes/Profile.php");
    require_once("classes/Admin.php");

    $conn = Database::connect();


    $profile = Profile::constuct_with_userid($conn, 16);
    echo $profile->exists_in_database();


    $conn->close();

    
?>
