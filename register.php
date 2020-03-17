<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign Up</title>
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

		// handle form data of register user
		if (isset($_POST["submit_user"])) {

			session_start();
      
			include_once('functions/verify.php');
			include_once('functions/getter.php');

			// Check connection
			if (!$conn = db_connect()) {
				die("Connection failed: " . $conn->connect_error);
			}

			$error = array();
			$email = $username = $password = $passwordConfirm = $password_hash = $date = "";

			$email = htmlspecialchars($_POST["email"]);
			$username = htmlspecialchars($_POST["username"]);

			$password = $_POST["password"];
			$passwordConfirm = $_POST["passwordConfirm"];
			$date = date("Y-m-d H:i:s");


			// verify user inputted email
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				$error[] = "Invalid email.";

			// check if email exists i db
			if (get_user_attributes_equal_to("email", $email))
				$error[] = "This email already exists! Click forgot password to reset your password.";

			// verify user inputted username
			if (!verify_username($username))
				$error[] = "Invalid username.";


			if (get_user_attributes_equal_to("username", $username)) {
				$error[] = "Username already taken";
			}

			// verify user inputted password
			if (!verify_password_form($password)) // if the password doesn't match the regex, add error to error array
				$error[] = "Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.";
			
			if ($password != $passwordConfirm) // if the password doesn't match the confirm password, add error to error array
				$error[] = "Passwords do not match.";
      
			// if no errors were found
			if (!$error) {

				// hash password
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
			
				// prepare and bind
				$insertUser = $conn->prepare("INSERT INTO `User` (`email`, `username`, `passwordHash`, `dateCreated`, `lastLogin` ) VALUES (?, ?, ?, ?, ?);");
				$insertUser->bind_param("sssss", $email, $username, $password_hash, $date, $date);
			
				// execute prepared statement
				$insertUser->execute();

				// set session variables
				if (!get_all_user_attribute($username))
					die("Error: User attributes could not be retireved at this time");

				$_SESSION["loggedIn"] = 1;

				header("Location: setup_profile.php");
				exit();

			} else {
				var_dump($error);
			}
		} else { // register user form ?>


			<div class="limiter">
				<div class="container-login100">
					<div class="wrap-login100">
						<div class="login100-pic js-tilt" data-tilt style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
							<img src="img/img-01.png" alt="IMG">
						</div>

						<form class="login100-form validate-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

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
									<a href="login.php">Login</a>
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
