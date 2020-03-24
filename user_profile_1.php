<?php

    session_start();

    include_once("classes/User.php");

    echo "Get profile attributes: <br><br>";

    $arr = User::get_all_profile_attributes($_SESSION[User::USER_ID]);

    foreach ($arr as $key => $value) {
        echo $key . ": " . $value . "<BR>";
    }
    
    
    

?>