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
		require_once("init.php");
		$nameOfErrorGETVariable = "loginError";

		if (isset($_POST["submit_user"])) {
			$email = $username = $password = $passwordConfirm = $password_hash = "";			
			$conn = Database::connect();
			
			$email = htmlspecialchars($_POST["email"]);
			$username = htmlspecialchars($_POST["username"]);
			$password = htmlspecialchars($_POST["password"]);
			$passwordConfirm = htmlspecialchars($_POST["passwordConfirm"]);

			$_SESSION[User::EMAIL] = $email;
			$_SESSION[User::USERNAME] = $username;
			
			if (User::register($conn, $email, $username, $password, $passwordConfirm)) {
				header("Location: " . Database::EDIT_PROFILE);
			} else {
				header("Location: " . Database::REGISTER . "?" . $nameOfErrorGETVariable);
			}

			$conn->close();
			exit();
		} ?>

		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100 py-auto">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<div class="login100-pic js-tilt" data-tilt style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
									<img src="img/img-01.png" alt="IMG">
								</div>
							</div>
							<div class="col-md-6">
								<form class="login100-form validate-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

									<span class="login100-form-title">
										Sign Up
									</span>
									
									<div class="wrap-input100 validate-input" data-validate = "Username is required">
										<input class="input100" type="text" name="username" <?php echo (isset($_SESSION[User::USERNAME])) ? ("value=\"" . $_SESSION[User::USERNAME] . "\"") : "placeholder=\"Username\""; ?>>
										<span class="focus-input100"></span>
										<span class="symbol-input100">
											<i class="fa fa-user" aria-hidden="true"></i>
										</span>
									</div>

									<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
										<input class="input100" type="text" name="email" <?php echo (isset($_SESSION[User::EMAIL])) ? ("value=\"" . $_SESSION[User::EMAIL] . "\"") : "placeholder=\"Email\""; ?>>
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
						<?php
							if (isset($_GET[$nameOfErrorGETVariable]) && sizeof($_SESSION[User::ERROR]) > 0) {
								echo "<br>";
								foreach ($_SESSION[User::ERROR] as $key => $value) {
									echo "<div class=\"row\">";
										echo "<p class=\"text-danger\">" . $value . "</p>";
									echo "</div>";
								}
								
							}

						?>
					</div>
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
