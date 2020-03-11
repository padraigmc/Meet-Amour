<?php

    // set db connection variables
    $dbServerName = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "meetamour";

    // Create connection
    $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = "padraiga";

    $selectUsername = $conn->prepare("SELECT `username` FROM `User` WHERE `username` = ?;");
    $selectUsername->bind_param("s", $username);

    // execute prepared statement
    $selectUsername->execute();

    // get results
    $result = $selectUsername->get_result();

    if ($result->fetch_assoc()) {
        echo "1";
    } else {
        echo "0";
    }


?>