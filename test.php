<?php


    require_once("init.php");
    require_once("classes/Hobby.php");

    $conn = Database::connect();

    $hobbies = Hobby::get_user_hobbies($conn, "16");
    
    if (!$hobbies) echo "0";


    foreach ($hobbies as $value) {
        echo $value[1] . "<br>";
    }   
    
    
    
    
    ?>
