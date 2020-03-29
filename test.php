<?php


    require_once("init.php");

    $conn = Database::connect();

    $min_age = 20;
    $max_age = 20;
    
    $date_min = date("Y-m-d", strtotime("-" . ($max_age+1) . " year +1 day", time())) . " 00:00:00";
    $date_max = date("Y-m-d", strtotime("-" . $min_age . " year", time())) . " 23:59:59";
    echo $date_min;
    echo "<br>";
    echo $date_max;
    
    
    
    
    ?>
