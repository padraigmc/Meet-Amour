<?php

session_start();

$servername = "localhost";
$username = "username";
$password = "password";
$dbName = "meetamour";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    echo "Connection failed";
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$insertUser = $conn->prepare("INSERT INTO User (firstname, lastname, email) VALUES (?, ?, ?)");
$stmt->bind_param("ssssss", $email, $username, $password, $dateCreated, $lastLogin);

if (isset($_POST["submit"])) {

    $params = array("username", "email", "password", "passwordConfirm");

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordConfirm"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Invalid email";
        header("reg.html");
    }

    if ($password != $passwordConfirm) {
        $_SESSION["error"] = "Passwords do not match";
        header("reg.html");
    }


    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $date = date("Y-m-d H:i:s");

    $stmt->execute();

}


?>