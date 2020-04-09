<?php


    require_once("init.php");
    require_once("classes/Hobby.php");

    $conn = Database::connect();

    $vars = User::get_all_profile_attributes($conn, "mary");

    foreach ($vars as $key => $value) {
        var_dump($value); echo "<br>";
    }
    
?>
