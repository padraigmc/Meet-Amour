<?php


    require_once("init.php");
    require_once("classes/Hobby.php");

    $conn = Database::connect();

    $dob = "1999-06-14 00:00:00";

    echo User::calc_age($dob);



    /*
    $matches = User::suggest_matches($conn, "21");
    
    if (!$matches) echo "0";


    foreach ($matches as $key=>$value) {
        var_dump($value); echo "<br>";
    }  
    */
    
    
    ?>
