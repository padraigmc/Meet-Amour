<?php

    session_start();

    echo "User session var: <br><br>";
    
    
    var_dump($_SESSION);

    echo "<br><br>Accessing individual session vars: <br><br>";
    echo $_SESSION['username'] . "<br>";
    echo $_SESSION['email'] . "<br>";
    echo $_SESSION['loggedIn'] . "<br>";

?>