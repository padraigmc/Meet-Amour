<?php


    require_once("init.php");
    require_once("classes/Hobby.php");

    $conn = Database::connect();

    $hobbies = Hobby::get_user_hobbies($conn, "20");
    
    if (!$hobbies) echo "0";


    foreach ($hobbies as $key=>$value) {
        echo $key . " - " . $value . "<br>";
    }  
    
    
    
    ?>
