<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign Up</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<link rel="icon" type="image/png" href="img/logoalt.png"/>
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
			
			// session start, include User.php and declare error session var
			require_once("init.php");
			$conn = Database::connect();
			
			$email = $username = $password = $passwordConfirm = $password_hash = "";

			$email = htmlspecialchars($_POST["email"]);
			$username = htmlspecialchars($_POST["username"]);
			$password = htmlspecialchars($_POST["password"]);
			$passwordConfirm = htmlspecialchars($_POST["passwordConfirm"]);
			
			// Try to register user, if successful redirect to profile set up page
			if (User::register($conn, $email, $username, $password, $passwordConfirm)) {
				$conn->close();
				header("Location: profile-edit.php");
				exit();
			} else {
				$conn->close();
				var_dump($_SESSION);
			}
		} ?>

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
							<input class="input100" type="text" name="username" <?php echo (isset($username)) ? ("value=\"" . $username . "\"") : "placeholder=\"Username\""; ?>>
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-user" aria-hidden="true"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
							<input class="input100" type="text" name="email" <?php echo (isset($email)) ? ("value=\"" . $email . "\"") : "placeholder=\"Email\""; ?>>
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
								<a href="login.php" class="txt1">Login</a>
								<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
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
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
