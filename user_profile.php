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

			if (isset($_GET[User::USER_ID])) {
				$userID = $_GET[User::USER_ID];
				$profile = Profile::constuct_with_userid($conn, $userID);
				if ($profile && $profile->exists_in_database()) {
					
					if (isset($_POST["like"])) {
						$isLiked = Like::like_user($conn, $profile->userID);
					} elseif (isset($_POST["unlike"])) {
						if (Like::unlike_user($conn, $profile->userID))
							$isLiked = 0;
					} else {
						$isLiked = Like::check_like_status($conn, $profile->userID);
					}

				} else {
					$_SESSION[User::ERROR][] = UserError::PROFILE_UNAVAILABLE;
				}			
			} else {
				
				$profile = Profile::constuct_with_session_variables($conn);
				if (!$profile->exists_in_database()) {
					$conn->close();
					header("Location: " . Database::EDIT_PROFILE);
					exit();
				}
			}
			
			if ($notifications = Notification::get_unseen_user_notifications($conn, 3)) {
				$numUnseenNotifications = sizeof($notifications);
			} else {
				$numUnseenNotifications = 0;
			}

        	include("snippets/navbar.php");

		?>

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
			$_SESSION[User::ERROR] = array();
			$conn->close();
			exit();
		} else {
	?>

	<div class="form-row">
		<div class="col-lg-3">
			<img id="picture" src="<?php echo $profile->imageFilePath; ?>" alt="" class="img-fluid" height="300" width="300">
		</div>	
		<div class="col-lg-4">
			<div class="profile-head text-left font-weight-bold">
				<h4 class="font-weight-bold"><?php echo $profile->fname . " " . $profile->lname . ","; ?> <span class="text-weight-bold text-primary"><?php echo $profile->age; ?></span></h4>
				<?php if (isset($profile->lastLogin)) echo "<h6>Last login: " . $profile->lastLogin . "</h6>"; ?>
				</br>
				</br>

				<div class="tab-content profile">
					<table class="table table-sm w-75 table-borderless text-left" id="interests-table mx-auto">
						<tbody>
							<tr>
								<th scope="row"></th>
								<td class="text-primary">Location</td>
								<td><?php echo $profile->location; ?></td>
							</tr>
							<tr>
								<th scope="row"></th>
								<td class="text-primary">Gender</td>
								<td><?php echo $profile->gender; ?></td>
							</tr>
							<tr>
								<th scope="row"></th>
								<td class="text-primary">Seeking</td>
								<td><?php echo $profile->seeking; ?></td>
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
					if ($profile->hobbies) {
						foreach ($profile->hobbies as $key => $hobby) {
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
				<?php if ($profile->user_has_permission_to_edit()) { ?>
					<div class="btn-group dropright">
						<button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
						<div class="dropdown-menu text-center p-1">
							<?php if ($profile->user_owns_profile()) { ?>
								<a class="dropdown-item button butn w-100" href="<?php echo Database::EDIT_PROFILE; ?>">Edit Profile</a>
							<?php } else if ($_SESSION[User::IS_ADMIN]) { ?>
								<a class="dropdown-item button w-100" href="<?php echo Database::EDIT_PROFILE . "?" . User::USER_ID . "=" . $profile->userID; ?>">Edit Profile</a>
								<a class="dropdown-item button w-100" href="<?php echo Database::BAN_USER . "?" . User::USER_ID . "=" . $profile->userID; ?>">Ban User</a>
								<a class="dropdown-item button w-100" href="<?php echo Database::DELETE_USER . "?" . User::USER_ID . "=" . $profile->userID; ?>">Delete User</a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="row mt-auto">
				<?php 
					if (!$profile->user_owns_profile()) {
						echo "<form id=\"like_dislike_form\" action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?" . User::USER_ID . "=" . $profile->userID . "\" method=\"POST\">";
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
			<p class="text-left" id="bio"><?php echo (!empty($profile->description) ? $profile->description : "This user doesn't have a description...mysterious"); ?></p>
		</div>
	</div>
	</div>
	</div>

	<?php
		}
	?>
		
	<footer >
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