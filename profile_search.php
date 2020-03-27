<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Profiles</title>
</head>
<body>
    <?php
        require_once("init.php");
        $results = array();
            
        if (isset($_GET["submit"])) {
            $name_search = $_GET["search"];
            
            $results = User::profile_search($name_search);
        }




    ?>

    <form action="profile_search.php" method="GET">
        <input type="text" name="search" placeholder="Search...">
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php

        if (!empty($results)) {
            foreach ($results as $profile) {
                echo $profile["name"];echo "<br>";
                echo User::calc_age($profile["dob"]);echo "<br>";
                echo $profile["gender"];echo "<br>";
                echo $profile["seeking"];echo "<br>";
                echo $profile["description"];echo "<br>";
                echo $profile["location"];echo "<br>";
                echo "<br>";
            }
        }

    ?>


</body>
</html>