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

		// if the user isn't logged in, redirect to homepage
		if (!User::isLoggedIn()) {
			header("Location: login.php");
		}

		// set time variables - used for html date input
		$date_current = date("Y-m-d");
		$date_min = date("Y-m-d", strtotime("-120 year", time()));

		if (isset($_POST["submit"])) {
			// check if row is to be inserted or updated
			$newUser = $_POST["newUser"];

			// set variables to be insterted
			$userID = $_SESSION['userID'];
			$fname = htmlspecialchars($_POST["fname"]);
			$lname = htmlspecialchars($_POST["lname"]);
			$dob = $_POST["dob"];
			$genderID = $_POST["gender"];
			$seekingID = $_POST["seeking"];
			$description = htmlspecialchars($_POST["description"]);
			$locationID = $_POST["location"];


			// update or insert new profile data - dependent on value of $newUser
			if (User::set_profile_attributes($userID, $fname, $lname, $dob, $genderID, $seekingID, $description, $locationID, $newUser)) {
				header("Location: user_profile.php");
				exit();
			} else {
				$_SESSION[User::ERROR][] = UserError::GENERAL_ERROR;
			}

		}

		$profileAttr = array();
		$userID = $fname = $lname = $dob = $gender = $seeking = $description = $location = null;

		// try get profile data
		if ($profileAttr = User::get_all_profile_attributes($_SESSION[User::USER_ID])) {
			$newUser = false;

			$userID = $profileAttr[User::USER_ID];
			$fname = $profileAttr[User::FIRST_NAME];
			$lname = $profileAttr[User::LAST_NAME];
			$dob = substr($profileAttr[User::DATE_OF_BIRTH], 0, 10); // etract date (original: yyyy-mm-dd hh:mm:ss)
			$gender = $profileAttr[User::GENDER];
			$seeking = $profileAttr[User::SEEKING];
			$description = $profileAttr[User::DESCRIPTION];
			$location = $profileAttr[User::LOCATION];
		} else {
			// if no rows were returned, a row must be inserted
			$newUser = true;
		}
	?>

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	<div class="container">
		<a class="navbar-brand js-scroll-trigger" href="index.html"><img src="img/logo.png" alt="">  </a>
		<a class="navbar-brand js-scroll-trigger" href="index.html">MeetAmour</a> 
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		Menu
		<i class="fas fa-bars"></i>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">

			<li class="nav-item">
			<a class="nav-link js-scroll-trigger" href="user.html">Matches</a>
			</li>

			<li class="nav-item">
			<a class="nav-link js-scroll-trigger" href="about-us.html">About us</a>
			</li>
			<li class="nav-item">
			<a class="nav-link js-scroll-trigger" href="user-profile.html">Profile</a>
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
	
	<div class="container-fluid w-75 main">
		<div class="row">
		<div class="col-lg-6">
			<form id="info" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="form-row">
					<div class="col text-left font-weight-bold">
						<label for="fname">First Name</label>
						<input type="text" class="form-control" id="fname" name="fname" <?php echo User::populate_form_input($fname, "First Name"); ?>>
					</div>
					<div class="col text-left font-weight-bold">
						<label for="lname">Last Name</label>
						<input type="text" class="form-control" name="lname" <?php echo User::populate_form_input($lname, "Last Name"); ?>>
					</div>
				</div>
				<div class="form-row">
					<div class="col text-left font-weight-bold">
						<label for="dob">Date of Birth</label>
						<input type="date" class="form-control" name="dob" id="dob" <?php echo (isset($dob)) ? ("value=\"" . $dob . "\"") : ""; ?> min="<?php echo $date_min;?>" max="<?php echo $date_current; ?>">
					</div>
					<div class="col text-left font-weight-bold">
						<label for="location">Location</label>
						<select class="form-control" id="location" name="location"><?php
						// output dynamically generated dropdown list of all the available genders to choose from
						$genders = User::get_all_locations();
						$id = 0;
						while($row = $genders->fetch_assoc()) {
							// populate option with information pulled from database
							?><option id="<?php echo $id;?>" value="<?php echo $row['locationID'];?>"><?php echo $row['location'];?></option><?php
							$id++;
						}?>
						</select>
					</div>
				</div>
				<div class="form-row">
					
				<div class="col text-left font-weight-bold">
					<label for="gender">Gender</label>
					<select class="form-control" id="gender" name="gender"><?php
						// output dynamically generated dropdown list of all the available genders to choose from
						$genders = User::get_all_genders();
						$id = 0;
						while($row = $genders->fetch_assoc()) {
							// populate option with information pulled from database
							?><option id="<?php echo $id;?>" value="<?php echo $row['genderID'];?>"><?php echo $row['gender'];?></option><?php
							$id++;
						}?>
					</select>
				</div>
				<div class="col text-left font-weight-bold bottom-div">
					<label for="seeking">Seeking</label>
					<select class="form-control" id="seeking" name="seeking"><?php
						// output dynamically generated dropdown list of all the available genders to choose from
						$genders = User::get_all_genders();
						$id = 0;
						while($row = $genders->fetch_assoc()) {
							// populate option with information pulled from database
							?><option id="<?php echo $id;?>" value="<?php echo $row['genderID'];?>"><?php echo $row['gender'];?></option><?php
							$id++;
						}?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col text-left font-weight-bold bottom-div">
					<label for="description">Description</label>
					<textarea class="form-control" rows="4" cols="50" name="description" id="description" <?php echo (isset($description)) ? (">" . $description) : "placeholder=\"About you...\">"; ?></textarea>
				</div>
			</div>
				<div class="row">
				<div class="col submit">
					<input type="hidden" name="newUser" value="<?php echo $newUser ?>">
					<input type="submit" name="submit" value="Submit">
					<!--Link using JavaScript to act as submit button-->
					<a href="javascript:{}" onclick="document.getElementById('info').submit(); return false;">Save</a>
					<!--end-->
				</div>
				</div>
				</form>
			</div>

	<div class="col-lg-6">
		<!--JavaScript upload system to show an image preview-->
		<form id="upload"></form>
		<img id="image" alt="" width="300" height="300" />
		<input type="file" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])">
		<!--end-->
		<!--Link using JS for submit button-->
		<a href="javascript:{}" onclick="document.getElementById('upload').submit(); return false;">Upload</a>
		<!--end-->
	</form>
	</div>
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
		</ul>
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
          				<a href="admin.php">Admin</a>
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
  
 </body>
 
 </html>