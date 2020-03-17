<!DOCTYPE html>
<html lang="en">
<head>
	<title>Set Up Profile</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="img/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


    <?php
        
        require_once('functions/getter.php');
        $date_current = date("Y-m-d");
        $date_min = date("Y-m-d", strtotime("-120 year", time()));


		// handle form data of register user
		if (isset($_POST["submit_profile"])) {

			session_start();

			require_once('functions/verify.php');

		
			// Check connection
			if (!$conn = db_connect()) {
				die("Connection failed: " . $conn->connect_error);
			}

            // declare variables
			$error = array();
			$userID = $fname = $lname = $dob = $genderID = $seekingID = $description = "";
			
            // prepare and bind
            try {
                $insert = $conn->prepare("INSERT INTO `Profile` (`userID`, `fname`, `lname`, `dob`, `genderID`, `seekingID`, `description`, `locationID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
                if ($insert->bind_param("ssssssss", $userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID));
            } catch (\Throwable $th) {
                die($th);
            }
            

            // set variables to be insterted
            $userID = $_SESSION['userID'];
			$fname = htmlspecialchars($_POST["fname"]);
			$lname = htmlspecialchars($_POST["lname"]);
			$dob = $_POST["dob"];
			$genderID = $_POST["gender"];
			$seekingID = $_POST["seeking"];
            $description = htmlspecialchars($_POST["description"]);
            $locationID = "1";

            echo $userID;echo "<BR>";
			echo $fname;echo "<BR>";
			echo $lname;echo "<BR>";
			echo $dob;echo "<BR>";
			echo $genderID;echo "<BR>";
			echo $seekingID;echo "<BR>";
            echo $description;echo "<BR>";
            echo $locationID;echo "<BR>";

            echo "<BR>";

            try {
                // execute prepared statement
                if (!($res = $insert->execute()))
                    throw new Exception($insert->error);
                    var_dump($res);
                    die("Failed to save profile details.");
            } catch (\Throwable $th) {
                die($th);
            }
        
            

            // set session variables
			$_SESSION['fname'] = $fname;
			$_SESSION['lname'] = $lname;
			$_SESSION['dob'] = $dob;
			$_SESSION['gender'] = $gender;
			$_SESSION['seeking'] = $seeking;
			$_SESSION['description'] = $description;

            echo "session vars after profile set up";
            echo "<br>";
            var_dump($_SESSION);
            echo "<br>";
			
        } else { // setup profile form ?>

            <div class="limiter">
				<div class="container-login100">
					<div class="wrap-login100">
						<div class="login100-pic js-tilt" data-tilt style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
							<img src="img/img-01.png" alt="IMG">
						</div>

						<form class="login100-form validate-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<span class="login100-form-title">Create Profile</span>

							<!-- fname -->
							<div class="wrap-input100">
								<input class="input100" type="text" name="fname" placeholder="First Name">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</span>
							</div>

							<!-- lname -->
							<div class="wrap-input100">
								<input class="input100" type="text" name="lname" placeholder="Last Name">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</span>
							</div>

							<!-- dob -->
							<div class="wrap-input100">
								<input class="input100" type="date" name="dob" min="<?php echo $date_min;?>" max="<?php echo $date_current; ?>">
							</div>

							<!-- gender -->
							<div class="wrap-input100">
								<select name="gender" id="gender"><?php
									// output dynamically generated dropdown list of all the available genders to choose from
                                    $genders = get_all_genders();
                                    $id = 0;
									while($row = $genders->fetch_assoc()) {
										// populate option with information pulled from database
										?><option id="<?php echo $id;?>" value="<?php echo $row['genderID'];?>"><?php echo $row['gender'];?></option><?php
										$id++;
									}?>									
								</select>
							</div>

							<!-- seeking -->
							<div class="wrap-input100">
								<select name="seeking" id="seeking"><?php
									// output dynamically generated dropdown list of all the available genders to choose from
                                    $genders = get_all_genders();
                                    $id = 0;
									while($row = $genders->fetch_assoc()) {
										// populate option with information pulled from database
										?><option id="<?php echo $id;?>" value="<?php echo $row['genderID'];?>"><?php echo $row['gender'];?></option><?php
										$id++;
									}?>									
								</select>
							</div>

							<!-- description -->
							<div class="wrap-input100">
								<textarea class="input100" name="description" placeholder="Description" rows="4" cols="50"></textarea>
							</div>
							
							<div class="container-login100-form-btn">
								<input class="login100-form-btn" type="submit" name="submit_profile" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>

		<?php

		}


		?>

	
<!--===============================================================================================-->	
<script src="vendor/jquery/jquery.slim.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/bootstrap.bundle.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
