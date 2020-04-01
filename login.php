<!DOCTYPE html>
<html lang="en">
<head>
	<title>MeetAmour - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="img/logoalt.png">
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
  
<body><?php

		if (isset($_POST["submit"])) {

			// session start, include User.php and declare error session var
			require_once("init.php");
			$conn = Database::connect();
			
			$username = $_POST["username"];
			$password = $_POST["password"];

			// if error array is empty i.e. no errors
			if (User::login($conn, $username, $password)) {
				$conn->close();
				header('Location: user_profile.php');
				exit();
			}
		} else {
	  	?>
		
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
						<img src="img/img-01.png" alt="IMG">
					</div>

					<form class="login100-form validate-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>

						<span class="login100-form-title">
							Member Login
						</span>

						<div class="wrap-input100 validate-input" data-validate = "Valid email is required.">
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
								<a href="register.php" class="txt1">Create Your Account</a>
								<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
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