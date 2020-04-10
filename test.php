<?php


    require_once("init.php");
    require_once("classes/Admin.php");

    $conn = Database::connect();

    echo Like::like_user($conn, $_SESSION[User::USER_ID], 44);

    

    
?>
