<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    
        require_once("init.php");
        require_once("classes/Hobby.php");
        $_SESSION[User::USER_ID] = 20;
        $conn = Database::connect();


        if(isset($_POST['submit'])){
            $selected_hobbies = array();
            if(!empty($_POST['selected_hobbies'])){
                // Loop to store and display values of individual checked checkbox.
                foreach($_POST['selected_hobbies'] as $selected){
                    $selected_hobbies[] = (int) $selected;
                }

                $current_user_hobbies = array_map(null, ...Hobby::get_user_hobbies($conn, $_SESSION[User::USER_ID]))[0];

                echo Hobby::set_user_hobbies($conn, $_SESSION[User::USER_ID], $current_user_hobbies, $selected_hobbies);
            }
        } else {
            $_SESSION["all_hobbies"] = Hobby::get_all_hobbies($conn);
            $_SESSION["current_user_hobbies"] = array_map(null, ...Hobby::get_user_hobbies($conn, $_SESSION[User::USER_ID]))[0];

    ?>


    <form action="test.php" method="POST">
        <?php
            $checkboxID = 0;
            foreach ($_SESSION["all_hobbies"] as $value) { ?>
                <input type="checkbox" <?php echo "id=\"" . $checkboxID . "\" name=\"selected_hobbies[]\" value=\"" . $value[0] . "\""; echo (in_array($value[0], $_SESSION["current_user_hobbies"])) ? "checked>" : ">";
                echo "<label for=\"" . $checkboxID . "\">" .  $value[1] . "</label><br>";
                
                $checkboxID++;
            }        
        ?>

        <input type="submit" name="submit" value="Submit">
    </form>
    
    <?php
    }
    $conn->close();
    ?>
</body>
</html>