<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="img/logoalt.png">
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
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css'>

	<!-- Custom styles for this template -->
	<link href="css/new-age.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/cardstyle.css">

	<!--Script-->

	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="./js/script.js"></script>

</head>

<body id="page-top">
	<?php
		require_once("init.php");
		$conn = Database::connect();

		if (isset($_POST["username"])) {
			if (isset($_POST["like"])) {
				Like::like_user($conn, $_POST["like"], $_POST["username"]);
			} elseif (isset($_POST["unlike"])) {
				Like::unlike_user($conn, $_SESSION[User::USER_ID], $_POST["unlike"]);
			}
			header("Location: suggest_matches.php");
			$conn->close();
			exit();
		}

		$profles = User::suggest_matches($conn, $_SESSION[User::USER_ID]);
?>

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
		<div class="container">
		<a class="navbar-brand js-scroll-trigger" href="<?php echo Database::INDEX; ?>"><img src="img/logo.png" alt="">  </a>
		<a class="navbar-brand js-scroll-trigger" href="<?php echo Database::INDEX; ?>">MeetAmour</a> 
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			Menu
			<i class="fas fa-bars"></i>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">

			<li class="nav-item">
				<a class="nav-link js-scroll-trigger" href="<?php echo Database::SEARCH_PROFILE; ?>">Search</a>
			</li>

			<li class="nav-item">
				<a class="nav-link js-scroll-trigger" href="<?php echo Database::SUGGEST_MATCH; ?>">Find Matches</a>
			</li>
			<li class="nav-item">
				<a class="nav-link js-scroll-trigger" href="<?php echo Database::VIEW_PROFILE; ?>">My Profile</a>
			</li>
			<li class="nav-item">
				<a class="nav-link js-scroll-trigger" href="<?php echo Database::LOGOUT; ?>">Log Out</a>
			</li>
			</ul>
		</div>
		</div>
	</nav>
	<section class="matches py-5" id="matches">
		<div class="container">
			<div class="section-heading text-center">
				<h2 id="match-heading">Here are today's matches</h2>
				<hr>
			</div>

			<?php

			$col_count = 0;
			$row_open = 0;
			
			echo "<div class=\"container\">";
				foreach ($profles as $value) {
					$userID = $value[User::USER_ID];
					$username = $value[User::USERNAME];
					$name = $value["name"];
					$age = Profile::calculate_age($value[User::DATE_OF_BIRTH]);
					$gender = $value[User::GENDER];
					$description = $value[User::DESCRIPTION];
					$location = $value[User::LOCATION];
					$image_filepath = User::USER_IMAGES . $value["filename"];
					$isLiked = Like::check_like_status($conn, $_SESSION[User::USER_ID], $userID);

					// test if the file exists, if not set it to a defualt image
					if (!is_file($image_filepath)) {
						$image_filepath = User::DEFAULT_USER_IMAGE;
					}

					if ($col_count == 0 && $row_open == 0) {
						echo "<div class=\"row active-with-click pb-5\">";
						$row_open = 1;
					}
			?>
					<div id="<?php echo $username ?>" class="col-md-4 col-sm-6 col-xs-12">
							<article class="material-card Red">
								<h2>
									<span><?php echo $name; ?></span>
									<strong>
										<i class="fa fa-fw fa-heart"></i>
										<?php echo $age; ?> Years Old
									</strong>
								</h2>
								<div class="mc-content">
									<div class="img-container">
										<a href="<?php echo Database::VIEW_PROFILE . "?username=" . $username ?>">
											<img class="img-fluid" src="<?php echo $image_filepath; ?>" width="300" height="300">
										</a>
									</div>
									<div class="mc-description">
									<ul>
										<li><?php echo $gender; ?></li> 
									</ul>
									<ul>
										<li><?php echo $location; ?></li> 
									</ul>
									<p><?php echo $description; ?></p>
									</div>
								</div>
								<a class="mc-btn-action">
									<i class="fa fa-bars"></i>
								</a>
								<div class="mc-footer">
									<h4>
										Match?
									</h4>
									<a class="fa fa-fw fa-heart"></a> 
									<a class="fa fa-fw fa-times"></a>
									<?php
										echo "<form id=\"like_dislike_form\" action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) . "\" method=\"POST\">";
											if ($isLiked) {
												echo "<button type=\"submit\" class=\"p-2 fa-heart\" form=\"like_dislike_form\" name=\"unlike\" value=\"" . $userID . "\">Unlike</button>";
											} else {
												echo "<button type=\"submit\" class=\"p-2\" form=\"like_dislike_form\" name=\"like\" value=\"" . $userID . "\">Like</button>";
											}
										echo "<input type=\"hidden\" name=\"username\" value=\"" . $username . "\">";
									?>
								</div>
							</article>
						</div>
				<?php
					$col_count++;
					if ($col_count == 3 && $row_open) {
						echo "</div>";
						$row_open = 0;
						$col_count = 0;
					}
				}

				if ($row_open) {
					echo "</div>";
				}
				?>
			</div>
		</div>
	</section>

		<br>
		<br>
		<br>
		<br>
		<br>

	<footer>
		<div class="container">
		<p>&copy; MeetAmour 2020. All Rights Reserved.</p>
		<ul class="list-inline">
			<li class="list-inline-item">
			<a href="#">Privacy</a>
			</li>
			<li class="list-inline-item">
			<a href="#">Terms</a>
			</li>
			<li class="list-inline-item">
			<a href="#">FAQ</a>
			</li>
			<li class="list-inline-item">
			<a href="<?php echo Database::ABOUT_US; ?>">About us</a>
			</li>
		</ul>
		</div>
	</footer>

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
