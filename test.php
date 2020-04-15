<?php


    require_once("init.php");
    require_once("classes/Profile.php");

    $conn = Database::connect();


    $profile = Profile::constuct_with_session_variables($conn);
    var_dump($profile);



    $conn->close();

    
?>
