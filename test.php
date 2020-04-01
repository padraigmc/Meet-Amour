<?php


    require_once("init.php");
    require_once("classes/Hobby.php");

    $conn = Database::connect();

    echo User::like_user($conn, 21);


    /*
    $matches = User::suggest_matches($conn, "21");
    
    if (!$matches) echo "0";


    foreach ($matches as $key=>$value) {
        var_dump($value); echo "<br>";
    }  
    */
    
    
    ?>
