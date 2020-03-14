<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
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

		if (isset($_POST["submit"])) {
			
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

			$userCred = $_POST["userCred"];
			$inputPassword = $_POST["password"];

			// test if user entered email or username
			if (filter_var($userCred, FILTER_VALIDATE_EMAIL)) {

				// prepare and bind
				$selectPassword = $conn->prepare("SELECT `password` FROM User WHERE `username` = ?;");
				$selectPassword->bind_param("s", $username);
			
				// execute prepared statement
				$selectPassword->execute();

			} elseif (preg_match($username_regex, $userCred)) {
				// prepare and bind
				$insertUser = $conn->prepare("INSERT INTO User (`email`, `username`, `password`, `dateCreated`, `lastLogin` ) VALUES (?, ?, ?, ?, ?);");
				$insertUser->bind_param("sssss", $email, $username, $password_hash, $date, $date);
			
				// execute prepared statement
				$insertUser->execute();
			} else {
				$error[] = "Invalid username/email.";
			}

			// set session variables
			$_SESSION["username"] = $username;
			$_SESSION["email"] = $email;
			$_SESSION["loggedIn"] = 1;
			
		}

	?>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
					<img src="img/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form">
					<span class="login100-form-title">
						Member Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<!-- email form field -->
						<input class="input100" type="text" name="userCred" placeholder="Username / Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<!-- password form field -->
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<!-- login button -->
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							<a href="reg.php">Create Your Account</a>
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
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

</body>
</html>