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

		session_start();

		if (isset($_POST["submit"])) {

			require_once('functions/setter.php');
			require_once('functions/getter.php');
			require_once('functions/verify.php');

			$error = array();
			$username = $password = "";

			
			$username = $_POST["username"];
			$password = $_POST["password"];

			if (get_user_attribute($username, "isBanned"))
				$error[] = "Account banned! If you think this was a mistake, contact us on admin@meetamour.ie!";

			// verify username form
			if (!verify_username($username)) {
            	$error[] = "Invalid username: alphanumeric characters, underscores (_) and hyphens (-) only.";
			}

			// check if username exists in db
			if (!get_user_attributes_equal_to("username", $username))
				$error[] = "Username does not exist!";

			// validate password, and get all user attributes as session variables
			if (!verify_password_form($password))
				$error[] = "Invalid password: alphanumeric characters, underscores (_) and hyphens (-) only.";

			if (!verify_password_hash($username, $password))
				$error[] = "Incorrect password!";

			// if error array is empty i.e. no errors
			if (!$error) {
				// set user attributes as session variables and set loggedIn session flag, update lastLogin user attribute
				get_all_user_attribute($username);
				update_user_attribute($username, "lastLogin", date("Y-m-d H:i:s"));
				$_SESSION["loggedIn"] = 1;

			}

			// if the user previously deactivated their account, activate on login
			if (get_user_attribute($username, "isDeactivated") == 1)
				update_user_attribute($username, "isDeactivated", 0);
			
		} else {

	?>
		
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
						<img src="img/img-01.png" alt="IMG">
					</div>

					<form class="login100-form validate-form" method="POST" action="index.php">
						<span class="login100-form-title">
							Member Login
						</span>

						<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
							<!-- email form field -->
							<input class="input100" type="text" name="username" placeholder="Username">
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
							<div class="container-login100-form-btn">
									<input class="login100-form-btn" type="submit" name="submit" value="Login">
								</div>
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

</body>
</html>