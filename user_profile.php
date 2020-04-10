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

	<!-- Plugin CSS -->
	<link rel="stylesheet" href="vendor/device-mockups/device-mockups.min.css">

	<!-- Custom styles for this template -->
	<link href="css/new-age.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">

	</head>

	<body id="page-top">
		<?php

			require_once("init.php");
			require_once("classes/Hobby.php");
			$conn = Database::connect();

			// if username supplied by get variable (in url), query db for userID
			if (isset($_GET[User::USERNAME])) {
				$owner = 0;
				$username = $_GET[User::USERNAME];
				$profileAttributes = User::get_all_profile_attributes($conn, $username);

				$userID = $profileAttributes[User::USER_ID];
				$fname = $profileAttributes[User::FIRST_NAME];
				$lname = $profileAttributes[User::LAST_NAME];
				$age = User::calc_age($profileAttributes[User::DATE_OF_BIRTH]);
				$gender = $profileAttributes[User::GENDER];
				$seeking = $profileAttributes[User::SEEKING];
				$description = $profileAttributes[User::DESCRIPTION];
				$location = $profileAttributes[User::LOCATION];

				if (isset($_POST["like"])) {
					$isLiked = Like::like_user($conn, $userID);
				} elseif (isset($_POST["unlike"])) {
					if (Like::unlike_user($conn, $userID))
						$isLiked = 0;
				} else {
					$isLiked = Like::check_like_status($conn, $userID);
				}
			} else {
				// if user owns the page
				$userID = $_SESSION[User::USER_ID];
				$owner = 1;

				$fname = $_SESSION[User::FIRST_NAME];
				$lname = $_SESSION[User::LAST_NAME];
				$age = User::calc_age($_SESSION[User::DATE_OF_BIRTH]);
				$gender = $_SESSION[User::GENDER];
				$seeking = $_SESSION[User::SEEKING];
				$description = $_SESSION[User::DESCRIPTION];
				$location = $_SESSION[User::LOCATION];
			}

			if ($userID > 0 && isset($_SESSION[User::FIRST_NAME])) {

				if ($profile_image_path = User::get_user_image_filename($conn, $userID)) {
					$profile_image_path = User::USER_IMAGES . $profile_image_path;
				}

				$hobbies = Hobby::get_user_hobbies($conn, $userID);
			} else {
				// if the profile does not have a row in the table
				if ($owner) {
					$conn->close();
					header("Location: profile-edit.php");
					exit();
				} else {
					$_SESSION[User::ERROR][] = UserError::PROFILE_UNAVAILABLE;
				}

			}

			if ($notifications = Notification::get_unseen_user_notifications($conn, 3)) {
				$numUnseenNotifications = sizeof($notifications);
			} else {
				$numUnseenNotifications = 0;
			}

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
				<li class="nav-item dropdown">
					<a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-bell"><?php echo ($notifications) ? $numUnseenNotifications : ""; ?></i>
					</a>
					<ul class="dropdown-menu" id="notification">
						<li class="head text-light bg-primary">
							<div class="row">
								<div class="col-lg-12">
									<span>Notifications (<?php echo $numUnseenNotifications; ?>)</span>
								</div>
							</div>
						</li>
						<?php
							if ($notifications) {
								foreach ($notifications as $key => $value) {
									$mark_as_seen_path = Database::MARK_NOTIFICATION_AS_SEEN;
									$mark_as_seen_path .=  "?" . Notification::FROM_USER_ID . "=" . $value[Notification::FROM_USER_ID];
									$mark_as_seen_path .=  "&" . Notification::REDIRECT_PAGE . "=" . $_SERVER['PHP_SELF'];
						?>
									<li class="notification-box <?php echo ($key % 2 == 1) ? "bg-gray" : ""; ?>">
										<div class="row"> 
											<div class="offset-lg-1"></div>
											<div class="col-lg-8">
												<strong class="text-primary">
													<a href="<?php echo Database::VIEW_PROFILE . "?username=" . $value[Notification::FROM_USERNAME] ; ?>"><?php echo $value[User::NAME]; ?></a>
												</strong>
												<div>
													<?php echo $value[Notification::MESSAGE]; ?>
												</div>
												<small class="text-info"><?php echo $value[Notification::DATE_SENT]; ?></small>
											</div>
											<div class="col-lg-3">
												<a href="<?php echo $mark_as_seen_path; ?>">Mark as read</a>
											</div>     
										</div>
									</li>
						<?php
								}
							} else {
								?>
								<li class="notification-box">
									<div class="row"> 
										<h6 class="mx-auto">Nothing to see here...</h6>
									</div>
								</li>
								<?php
							}
						?>
						<li class="footer bg-primary text-center">
							<a href="<?php echo Database::NOTIFICATIONS; ?>" class="text-light">View All</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		</div>
	</nav>

	</br>
	</br>
	</br>
	
	<section class="download bg-primary text-center" id="download">
		<div class="container">
		<div class="row">
			<div class="col-md-8 mx-auto">
			<h2 class="section-heading">Your Profile<br> <h3><font color="white"></font></h3></h2>
			
			<div class="badges">
				<img src="img/logo.png" alt="">
				
			</div>
			</div>
		</div>
		</div>
	</section>

	<div class="container main">

	<?php
		// if an error was found, display it and nothing else
		if (!empty($_SESSION[User::ERROR])) {
			echo "<h1>" . $_SESSION[User::ERROR][0] . "</h1></div>";
			$conn->close();
			exit();
		} else {
	?>

	<div class="form-row">
		<div class="col-lg-3">
			<img id="picture" src="<?php echo ($profile_image_path) ? $profile_image_path : "img/blank-profile.png"; ?>" alt="" class="img-fluid" height="300" width="300">
		</div>	
		<div class="col-lg-4">
			<div class="profile-head text-left font-weight-bold">
				<h4 class="font-weight-bold"><?php echo $fname . " " . $lname . ","; ?> <span class="text-weight-bold text-primary"><?php echo $age; ?></span></h4>
				</br>
				</br>

				<div class="tab-content profile">
					<table class="table table-sm w-75 table-borderless text-left" id="interests-table mx-auto">
						<tbody>
							<tr>
								<th scope="row"></th>
								<td class="text-primary">Location</td>
								<td><?php echo $location; ?></td>
							</tr>
							<tr>
								<th scope="row"></th>
								<td class="text-primary">Gender</td>
								<td><?php echo $gender; ?></td>
							</tr>
							<tr>
								<th scope="row"></th>
								<td class="text-primary">Seeking</td>
								<td><?php echo $seeking; ?></td>
							</tr>
							<tr>
								<th scope="row"></th>
								<td colspan="2"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="vl d-none d-sm-block"> </div>
		<div class="col-lg-3 justify-content-center" id="interests">
			<h5 class="font-weight-bold mx-auto mt-0">Hobbies</h5>
			<table class="table table-sm w-75 table-borderless" id="interests-table">
				<?php
					if ($hobbies) {
						foreach ($hobbies as $key => $hobby) {
							?>
							<tr>
								<th scope="row"></th>
								<td><?php echo $key; ?></td>
							</tr>
							<?php
						}   
					} else {
						?>
						<tr>
							<th scope="row"></th>
							<td>Nothing to show!</td>
						</tr>
						<?php
					}
				?>
			</table>
			
		</div>
		<div class="col-lg-1 d-flex align-items-end flex-column">
			<div class="row">
				<?php if ($owner || $_SESSION[User::IS_ADMIN]) { ?>
					<div class="btn-group dropright">
						<button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
						<div class="dropdown-menu">
							<a class="dropdown-item button w-100" href="<?php echo Database::EDIT_PROFILE; ?>">Edit Profile</a>
							<?php if ($_SESSION[User::IS_ADMIN]) { ?>
								<a class="button w-100" href="<?php echo Database::BAN_USER . "?" . User::USER_ID . "=" . $userID; ?>">Ban User</a>
								<a class="button w-100" href="<?php echo Database::DELETE_USER . "?" . User::USER_ID . "=" . $userID; ?>">Delete User</a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="row mt-auto">
				<?php 
					if ($owner == 0) {
						echo "<form id=\"like_dislike_form\" action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?username=" . $username . "\" method=\"POST\">";
						if ($isLiked) {
							echo "<button type=\"submit\" class=\"p-2\" form=\"like_dislike_form\" name=\"unlike\">Unlike</button>";
						} else {
							echo "<button type=\"submit\" class=\"p-2\" form=\"like_dislike_form\" name=\"like\">Like</button>";
						}
						echo "</form>";
					}
				?>
			</div>
		</div>
	</div>

		
	<div class="row">
		<div class="col-lg-2 text-left" id="about">
		<h4 class="font-weight-bold">About Me</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-7">
			<p class="text-left" id="bio"><?php echo (!empty($description) ? $description : "This user doesn't have a description...mysterious"); ?></p>
		</div>
	</div>
	</div>
	</div>

	<?php
		}
	?>
		
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