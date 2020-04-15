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

		// session start, include User.php and declare error session var
		require_once("init.php");
		require_once("classes/Hobby.php");
		$conn = Database::connect();

		if (isset($_GET[User::USERNAME])) {
			$username = $_GET[User::USERNAME];
			$profile = Profile::constuct_with_username($conn, $username);
			if (!$profile->user_has_permission_to_edit()) {
				unset($profile);
				$conn->close();
				header("Location: " . Database::INDEX);
				exit();
			}

			$redirect_on_successful_edit = Database::VIEW_PROFILE . "?" . User::USERNAME . "=" . $username;
		} else {
			$profile = Profile::constuct_with_session_variables($conn);
			$redirect_on_successful_edit = Database::VIEW_PROFILE;
		}

		if (isset($_POST["submit"])) {
			$success = 1;

			// set variables to be insterted
			$profile->fname = htmlspecialchars($_POST["fname"]);
			$profile->lname = htmlspecialchars($_POST["lname"]);
			$profile->dob = $_POST["dob"];
			$profile->genderID = $_POST["gender"];
			$profile->seekingID = $_POST["seeking"];
			$profile->description = htmlspecialchars($_POST["description"]);
			$profile->locationID = $_POST["location"];


			// update or insert new profile data - dependent on value of $newUser
			if (!$profile->store_profile_attributes()) {
				$success = 0;
			}

			// upload image if one use submitted
			if (isset($_FILES['userImage']['tmp_name']) && $_FILES['userImage']['name'] != "") {
				User::upload_user_image($conn, $profile->userID, 'userImage');
			}

            if(!empty($_POST['selected_hobbies'])){
				$selected_hobbies = $_POST['selected_hobbies'];

				$success = Hobby::set_user_hobbies($conn, $profile->userID, $profile->hobbies, $selected_hobbies);

				if ($success) {
					$profile->hobbies = $selected_hobbies;
					if ($profile->user_owns_profile()) {
						$_SESSION[User::HOBBIES] = $selected_hobbies;
					}
					
				}
            }		

			if ($success) {
				header("Location: " . $redirect_on_successful_edit);
			} else {
				$_SESSION[User::ERROR][] = UserError::GENERAL_ERROR;
				header("Location: " . Database::EDIT_PROFILE .  " ?edit_error");
			}
			$conn->close();
			exit();
		}

		// set time variables - used for html date input
		$date_current = date("Y-m-d");
		$date_max = date("Y-m-d", strtotime("-18 year", time()));
		$date_min = date("Y-m-d", strtotime("-120 year", time()));
		$all_hobbies = Hobby::get_all_hobbies($conn);

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
			<a class="nav-link js-scroll-trigger" href="<?php echo Database::ABOUT_US; ?>">Find Matches</a>
			</li>

			<li class="nav-item">
			<a class="nav-link js-scroll-trigger" href="<?php echo Database::VIEW_PROFILE; ?>">My Profile</a>
			</li>

			<li class="nav-item">
			<a class="nav-link js-scroll-trigger" href="<?php echo Database::LOGOUT; ?>">Logout</a>
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
					<h2 class="section-heading">Edit Your Profile<br> <h3><font color="white"></font></h3></h2>
					
					<div class="badges">
						<img src="img/logo.png" alt="">
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<div class="container-fluid main w-100">
		<form id="edit-info" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]);?>" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-3">
					<h3 class="pb-4">Profile Picture</h3>
					<!--JavaScript upload system to show an image preview-->
					<img id="output" class="picture py-auto img-fluid" width="350" src="<?php echo $profile->imageFilePath; ?>"/>
					<script>
					var loadFile = function(event) {
						var output = document.getElementById('output');
						output.src = URL.createObjectURL(event.target.files[0]);
						output.onload = function() {
						URL.revokeObjectURL(output.src) // free memory
						}
					};
					</script>
					<input type="file" style="border-radius: 4px;" accept="image/*" onchange="loadFile(event)">
				</div>
				<div class="col-lg-7">
					<h3>Personal Details</h3>
					<div class="form-row">
						<div class="col text-left font-weight-bold">
							<label for="fname">First Name</label>
							<input type="text" class="form-control" id="fname" name="fname" <?php echo User::populate_form_input($profile->fname, "First Name"); ?>>
						</div>
						<div class="col text-left font-weight-bold">
							<label for="lname">Last Name</label>
							<input type="text" class="form-control" name="lname" <?php echo User::populate_form_input($profile->lname, "Last Name"); ?>>
						</div>
					</div>
					<div class="form-row">
						<div class="col text-left font-weight-bold">
							<label for="dob">Date of Birth</label>
								<input type="date" class="form-control" name="dob" id="dob" <?php echo (isset($profile->dob)) ? ("value=\"" . $profile->dob . "\"") : ""; ?> min="<?php echo $date_min;?>" max="<?php echo $date_max; ?>">
						</div>
						<div class="col text-left font-weight-bold">
							<label for="location">Location</label>
							<select class="form-control" id="location" name="location"><?php
							// output dynamically generated dropdown list of all the available genders to choose from
							$locations = User::get_all_locations($conn);
							$id = 0;
							while($row = $locations->fetch_assoc()) {
								// populate option with information pulled from database
								echo "<option id=\"" . $id .  "\" value=\"" . $row['locationID'] . "\"" . (($row['locationID'] == $profile->locationID) ? "selected" : "") . ">" . $row['location'] . "</option>";
								$id++;
							}?>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col text-left font-weight-bold">
							<label for="gender">Gender</label>
							<select class="form-control" id="gender" name="gender">
								<?php
								// output dynamically generated dropdown list of all the available genders to choose from
								$genders = User::get_all_genders($conn);
								$id = 0;
								while($row = $genders->fetch_assoc()) {
									// populate option with information pulled from database
									echo "<option id=\"" . $id .  "\" value=\"" . $row['genderID'] . "\"" . (($row['genderID'] == $profile->genderID) ? "selected" : "") . ">" . $row['gender'] . "</option>";
									$id++;
								}?>
							</select>
							
						</div>
						<div class="col text-left font-weight-bold bottom-div">
							<label for="seeking">Seeking</label>
							<select class="form-control" id="seeking" name="seeking"><?php
								// output dynamically generated dropdown list of all the available genders to choose from
								$genders = User::get_all_genders($conn);
								$id = 0;
								while($row = $genders->fetch_assoc()) {
									// populate option with information pulled from database
									echo "<option id=\"" . $id .  "\" value=\"" . $row['genderID'] . "\"" . (($row['genderID'] == $profile->seekingID) ? "selected" : "") . ">" . $row['gender'] . "</option>";
									$id++;
								}?>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col text-left font-weight-bold bottom-div">
							<label for="description">Description</label>
							<textarea class="form-control" rows="4" cols="50" name="description" id="description" <?php echo (isset($profile->description)) ? (">" . $profile->description) : "placeholder=\"About you...\">"; ?></textarea>
						</div>
					</div>
				</div>
				<div class="col-lg-2 text-left">
					<h3 class="pb-1">Hobbies</h3>
					<?php
						$checkboxID = 0;
						foreach ($all_hobbies as $hobby) { ?>
							<input type="checkbox" <?php echo "id=\"" . $checkboxID . "\" name=\"selected_hobbies[]\" value=\"" . $hobby[0] . "\""; echo (in_array($hobby[0], $profile->hobbies)) ? "checked" : "";?>><?php
							echo "<label for=\"" . $checkboxID . "\">" .  $hobby[1] . "</label><br>";
							
							$checkboxID++;
						}        
					?>
				</div>
			</div>
			<div class="row">
					<div class="col-lg-6 submit">
					<input class="w-100" style="padding-top: 14px;" type="submit" name="submit" value="Submit">
				</div>
				<div class="col-lg-6">
					<a onClick="goBack()" style="cursor: pointer;" class=" butn button w-100">Cancel</a>
					<script>
						function goBack() {
							window.history.back();
						}
					</script>
					</div>
			</div>
		</form>
	</div>
</div>
		
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