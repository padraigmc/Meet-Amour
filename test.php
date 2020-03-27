<?php
   
    require_once("init.php");
    $conn = Database::connect();

    $curs = User::profile_search(" ");
    var_dump($curs);
    foreach ($curs as $key => $value) {
        echo $key . "<br>";
            foreach ($value as $key1 => $value1) {
            echo $value1 . "<br>";
        }
        echo "<br><br>";
    }
?>