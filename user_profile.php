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
	// presume the user does NOT own the profile
	$owner = 0;
	// if username supplied by get variable (in url), query db for userID
	if (isset($_GET[User::USERNAME])) {
		$username = $_GET[User::USERNAME];
		$userID = User::get_user_attribute($username, User::USER_ID);
	} else {
		// if user owns the page
		$userID = $_SESSION[User::USER_ID];
		$owner = 1;
	}

	if ($userID > 0 && $profileAttr = User::get_all_profile_attributes($userID)) {
		// set user variables
		$fname = $profileAttr[User::FIRST_NAME];
		$lname = $profileAttr[User::LAST_NAME];
		$age = User::calc_age($profileAttr[User::DATE_OF_BIRTH]); // get users age
		$gender = $profileAttr[User::GENDER];
		$seeking = $profileAttr[User::SEEKING];
		$description = $profileAttr[User::DESCRIPTION];
		$location = $profileAttr[User::LOCATION];

		if ($profile_image_path = User::get_user_image_filename($userID)) {
			$profile_image_path = User::USER_IMAGES . $profile_image_path;
		}
	} else {
		// if the profile does not have a row in the table
		if ($owner) {
			header("Location: profile-edit.php");
			exit();
		} else {
			$_SESSION[User::ERROR][] = UserError::PROFILE_UNAVAILABLE;
		}

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
            <a class="nav-link js-scroll-trigger" href="#">Profile</a>
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
  
<div class="container-fluid w-75 main">

<?php
	// if an error was found, display it and nothing else
	if (!empty($_SESSION[User::ERROR])) {
		echo "<h1>" . $_SESSION[User::ERROR][0] . "</h1></div>";
		exit();
	} else {
?>

<div class="row">
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
                      <td class="text-primary">Profession</td>
                      <td>Web Developer & Designer</td>
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
<div class="col-lg-2 justify-content-center" id="interests">
	<h5 class="font-weight-bold mx-auto">Interests</h5>
  <table class="table table-sm w-75 table-borderless" id="interests-table">
		<tbody>
		<tr>
			<th scope="row"></th>
			<td>Pop Music</td>
		</tr>
		<tr>
			<th scope="row"></th>
			<td>Cycling</td>
		</tr>
		<tr>
			<th scope="row"></th>
			<td>Baking</td>
		</tr>
      <tr>
			<th scope="row"></th>
			<td>Thriller Movies</td>
    </tr>
    <tr>
			<th scope="row"></th>
			<td>JavaScript</td>
    </tr>
    <tr>
			<th scope="row"></th>
			<td>Running</td>
		</tr>
		</tbody>
	</table>
	
</div>
  <div class="col-lg-2 button align-self-start text-right">
		<a href="profile-edit.php">Edit Profile</a>
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
  
 </body>
 
 </html>