<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign Up</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


	<?php

		/*
		*	Query User table for username where username is equal to supplied username
		*	Checks if a username already exists in the database
		*
		*	$dbConnection 	-	database connection object used to prepare an SQL statement
		*	$username	 	-	username to test
		*/
		function doesUsernameExist($dbConnection, $username) {

			$selectUsername = $dbConnection->prepare("SELECT `username` FROM `User` WHERE `username` = ?;");
			$selectUsername->bind_param("s", $username);

			// execute prepared statement
			$selectUsername->execute();

			// get results
			$result = $selectUsername->get_result();
			
			// if the query returned a result i.e. if the username is taken
			if ($result->fetch_assoc()) {
				return 1;
			} else {
				return 0;
			}
		}


		/*
		*	Query User table for email where email is equal to supplied email
		*	Checks if a email already exists in the database
		*
		*	$dbConnection 	-	database connection object used to prepare an SQL statement
		*	$email	 		-	email to test
		*/
		function doesEmailExist($dbConnection, $email) {

			$selectEmail = $dbConnection->prepare("SELECT `email` FROM `User` WHERE `email` = ?;");
			$selectEmail->bind_param("s", $email);

			// execute prepared statement
			$selectEmail->execute();

			// get results
			$result = $selectEmail->get_result();
			
			// if the query returned a result i.e. if the username is taken
			if ($result->fetch_assoc()) {
				return 1;
			} else {
				return 0;
			}
		}
	
		if (isset($_POST["submit_user"])) {

			session_start();

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

			$error = array();
			$email = $username = $password = $passwordConfirm = $password_hash = $date = "";

			// regex variables
			$username_regex = "/^[a-zA-Z0-9_\-]{8,30}$/"; // a-z, A-Z, 0-9, '-', '_' (8-30 chars)
			$password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"; // one upper and lowercase letter, one num, one special char

			$email = $_POST["email"];
			$username = $_POST["username"];
			$password = $_POST["password"];
			$passwordConfirm = $_POST["passwordConfirm"];
			$date = date("Y-m-d H:i:s");


			// validate user inputted email
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$error[] = "Invalid email.";
			}

			if (doesEmailExist($conn, $email)) {
				$error[] = "Email already taken";
			}

			// validate user inputted username
			if (!preg_match($username_regex, $username)) {
				$error[] = "Invalid username.";
			}

			if (doesUsernameExist($conn, $username)) {
				$error[] = "Username already taken";
			}

			// validate user inputted password
			if (!preg_match($password_regex, $password)) {
				// if the password doesn't match the regex, add error to error array
				$error[] = "Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.";
			} elseif ($password != $passwordConfirm) {
				// if the password doesn't match the confirm password, add error to error array
				$error[] = "Passwords do not match.";
			} else {
				// if password entered is valid and matches confirm password, hash and store it
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
			}

			var_dump($error);

			if (!$error) {
			
				// prepare and bind
				$insertUser = $conn->prepare("INSERT INTO User (`email`, `username`, `password`, `dateCreated`, `lastLogin` ) VALUES (?, ?, ?, ?, ?);");
				$insertUser->bind_param("sssss", $email, $username, $password_hash, $date, $date);
			
				// execute prepared statement
				$insertUser->execute();

				// set session variables
				$_SESSION["username"] = $username;
				$_SESSION["email"] = $email;
				$_SESSION["loggedIn"] = 1;

				echo "output from part 1";
				echo "<br>";
				var_dump($_SESSION["username"]);
				echo "<br>";
				var_dump($_SESSION["email"]);
				echo "<br>";
				var_dump($_SESSION["loggedIn"]);
				echo "<br>";
			}


			if (isset($_POST["submit_profile"])) {
				# code...
			} else {

				
				/*
				*	Front end for profile set up goes here!
				*/

				echo "This is the profile set up part";


			}


		} else { ?>

			<div class="limiter">
				<div class="container-login100">
					<div class="wrap-login100">
						<div class="login100-pic js-tilt" data-tilt style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
							<img src="images/img-01.png" alt="IMG">
						</div>

						<form class="login100-form validate-form" method="POST" action="reg.php">
							<span class="login100-form-title">
								Sign Up
							</span>
							
							<div class="wrap-input100 validate-input" data-validate = "Username is required">
								<input class="input100" type="text" name="username" placeholder="Username">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-user" aria-hidden="true"></i>
								</span>
							</div>

							<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
								<input class="input100" type="text" name="email" placeholder="Email">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</span>
							</div>

							<div class="wrap-input100 validate-input" data-validate = "Password is required">
								<input class="input100" type="password" name="password" placeholder="Password">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</span>
							</div>
							
							<div class="wrap-input100 validate-input" data-validate = "Password is required">
								<input class="input100" type="password" name="passwordConfirm" placeholder="Re-enter Password">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</span>
							</div>
							
							<div class="container-login100-form-btn">
								<input class="login100-form-btn" type="submit" name="submit_user" value="Register">
							</div>

							<div class="text-center p-t-136">
								<a class="txt2" href="#">
									<a href="index.php">Login</a>
									<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
								</a>
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
