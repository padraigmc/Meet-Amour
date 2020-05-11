<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MeetAmour - Revolutionary Dating Website</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="vendor/device-mockups/device-mockups.min.css">

    <!-- Custom styles for this template -->
    <link href="css/new-age.min.css" rel="stylesheet">

    <style>
        .slidecontainerage {
            width: 15%;
        }

        .togglegender {
            width: 15%;
        }

        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 25px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 5px;
            height: 25px;
            background: #4CAF50;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            background: #4CAF50;
            cursor: pointer;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider2 {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider2:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider2 {
            background-color: #2196F3;
        }

        input:focus + .slider2 {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider2:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider2.round {
            border-radius: 34px;
        }

        .slider2.round:before {
            border-radius: 50%;
        }

        .active-pink-4 input[type=text]:focus:not([readonly]) {
            border: 1px solid #f48fb1;
            box-shadow: 0 0 0 1px #f48fb1;
        }

        #page-container {
            position: relative;
            min-height: 100vh;
        }

        #footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding-top: .5rem;
            padding-bottom: .5rem;
        }

        .fit-image {
            width: 100%;
            object-fit: cover;
        }

    </style>

</head>

<body id="page-top">
    <?php
        require_once("init.php");
        require_once("classes/Search.php");
        $conn = Database::connect();
        $results = array();
            
        if (isset($_GET[Search::SEARCH_TEXT])) {

            if (isset($_GET[Search::RESULTS_PAGE_NUMBER])) {
                $pageNumber = $_GET[Search::RESULTS_PAGE_NUMBER];
            } else {
                $pageNumber = 1;
            }

            $name_search = $_GET[Search::SEARCH_TEXT];
            
            $gender = $_GET[Search::GENDER_ID];
            $location = $_GET[Search::LOCATION_ID];

            $min_age = $_GET[Search::MIN_AGE];
            $max_age = $_GET[Search::MAX_AGE];

            $search = new Search($conn, $pageNumber);
            
            $results = $search->profile_search($name_search, $gender, $location, $min_age, $max_age);
            $nextPageURL = $search->get_next_page_url();
            $previousPageURL = $search->get_previous_page_url();
        }

        include("snippets/navbar.php");
    ?>

    <div id="page-container">
        <section class="features" id="features">
            <div class="container-fluid">
                <div class="row">

                    <!-- filter section -->
                    <div class="col-md-2 bprder-dark">
                        <h3>Filter</h3>
                        <form action="#" method="get">
                            <fieldset>
                                <div class="search_row">
                                    <div class="search_column_2 mb-4">
                                        <select class="form-control" id="gender" name="<?php echo Search::GENDER_ID; ?>">
                                            <option id="all" value="%" selected>Gender (Any)</option>
                                            <?php // output dynamically generated dropdown list of all the available genders to choose from
                                            $genders = User::get_all_genders($conn);
                                            $id = 0;
                                            while($row = $genders->fetch_assoc()) {
                                                // populate option with information pulled from database
                                                echo "<option id=\"" . $id .  "\" value=\"" . $row['genderID'] . "\"" . (($row['genderID'] == $_GET[Search::GENDER_ID]) ? "selected" : "") . ">" . $row['gender'] . "</option>";
                                                $id++;
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="search_row mb-4">
                                    <div class="search_column_2 mb-4">
                                        <select class="form-control" id="location" name="<?php echo Search::LOCATION_ID; ?>">
                                            <option id="all" value="%" selected>Location (Any)</option>
                                            <?php // output dynamically generated dropdown list of all the available genders to choose from
                                            $loactions = User::get_all_locations($conn);
                                            $id = 0;
                                            while($row = $loactions->fetch_assoc()) {
                                                // populate option with information pulled from database
                                                echo "<option id=\"" . $id .  "\" value=\"" . $row['locationID'] . "\"" . (($row['locationID'] == $_GET[Search::LOCATION_ID]) ? "selected" : "") . ">" . $row['location'] . "</option>";
                                                $id++;
                                            }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p style="text-align:center;">Min age</p>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="<?php echo Search::MIN_AGE; ?>" id="min_age" min="18" max="120" size="3" value="<?php echo (isset($min_age)) ? $min_age : "18"; ?>" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p style="text-align:center;">Max age</p>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="<?php echo Search::MAX_AGE; ?>" id="max_age" min="18" max="120" size="3" value="<?php echo (isset($max_age)) ? $max_age : "120"; ?>"" class="form-control">
                                    </div>
                                </div>
                            </fieldset>
                    </div>

                    <!-- Search box & results -->
                    <div class="col-md-8 border-dark">
                        <!-- Search box -->
                        <h3>Partner Search</h3>
                            <div class="d-flex align-items-start mb-4">
                                <input class="active-pink-4 form-control" type="text" name="<?php echo Search::SEARCH_TEXT; ?>" placeholder="Search" aria-label="Search" <?php echo (isset($name_search)) ? "value=\"" . $name_search . "\"" : ""; ?>>
                                <input class="submit" type="submit" value="Submit">
                            </div>
                        </form>

                        <!-- Search results -->
                        <div class="container-fluid">
                            <?php
                                if (!empty($results)) {
                                    foreach ($results as $profile) { 
                                        $userID = $profile["userID"];
                                        $username = $profile["username"];
                                        $name = $profile["name"];
                                        $age = Profile::calculate_age($profile["dob"]);
                                        $gender = $profile["gender"];
                                        $description = $profile["description"];
                                        $location = $profile["location"];
                                        $fileName = $profile["filename"];
                            ?>

                                        <div class="row bg-primary border border-dark mb-4 p-3">
                                            <!-- user image -->
                                            <div class="col-md-3">
                                                <a href="<?php echo "user_profile.php?" . User::USER_ID . "=" . $userID; ?>">
                                                    <img class="fit-image img-thumbnail border-dark" src="<?php echo ($fileName) ? User::USER_IMAGES . $fileName : User::DEFAULT_USER_IMAGE ?>" alt="profile picture">
                                                </a>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <h2 class="m-0 mt-2"><?php echo $name . ", " . $age; ?></h2>
                                                        <div class="pl-3">
                                                            <p class="m-0"><?php echo $location; ?></p>
                                                            <p class="m-0"><?php echo $gender; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 m-auto text-center">
                                                        like button
                                                    </div>
                                                </div>
                                                <hr class="border-dark my-3">
                                                <p><?php echo $description; ?></p>
                                            </div>
                                        </div>
                            <?php
                                    }
                                } else if ($results == null && isset($_GET[Search::SEARCH_TEXT])) {
                                    ?>

                                    <div class="row mb-4 p-3">
                                        <h3 class="mx-auto">No results found, don't be so specific!</h3>
                                    </div>

                                    <?php
                                }
                            if (isset($previousPageURL)) { ?>
                                    <a href="<?php echo $previousPageURL; ?>">Previous</a>
                            <?php }
                            if (isset($nextPageURL)) { ?>
                                    <a class="float-right" href="<?php echo $nextPageURL; ?>">Next</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="offset-md-2"></div> <!-- Col offset for symmetry -->
                </div>
            </div>      
        </section>

        <footer id="footer">
            
            <p>&copy; MeetAmour 2020. All Rights Reserved.</p>
            <ul class="list-inline">
                <li class="list-inline-item">
                <a href="#">FAQ</a>
                </li>
                <li class="list-inline-item">
                <a href="<?php echo Database::ABOUT_US; ?>">About us</a>
                </li>
            </ul>
            </div>
        </footer>
    </div>

    <!-- js for age slider -->
    <script>
        var slider_min = document.getElementById("age_min");
        var output_min = document.getElementById("value_min");
        output_min.innerHTML = slider_min.value;

        slider_min.oninput = function() {
            output_min.innerHTML = this.value;
        }
        
        var slider_max = document.getElementById("age_max");
        var output_max = document.getElementById("value_max");
        output_max.innerHTML = slider_max.value;
        
        slider_max.oninput = function() {
            output_max.innerHTML = this.value;
        }
    </script>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>

    <?php
        $conn->close();
    ?>

</body>
</html>