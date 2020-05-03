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
<?php

  require_once("init.php");
  require_once("classes/Admin.php");
  
  $databaseConnection = Database::connect();

  $bannedUsers = Admin::get_banned_users($databaseConnection);
  $adminUsers = Admin::get_admin_users($databaseConnection);


?>

<body id="page-top">

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

  

</br>
</br>
</br>

<section class="admin-top bg-primary" id="admin-top">
    <div class="container-fluid w-100 main">
    <div class="row">
      <div class="col-lg-1" id="button-col">
        <a type="button" class="dropdown-toggle" data-toggle="dropdown">Manage Users</a>
        <div class="dropdown-menu mx-auto text-center">
          <a href="#" class="button w-100">View All Users</a>
          <a href="#" class="button w-100">Banned Users</a>
          <a href="#" class="button w-100">Reported Users</a>
      </div>
        <a href="#" class="button w-100">Search Users</a>
        <a href="#" class="button w-100">Ban Appeals</a>
        <a href="#" class="button w-100">Manage Users</a>
      </div>
      <div class="col-lg-11">
        <div class="form-row" id="top-1">
          <h3 class="text-primary table-striped font-weight-bold">Banned Users</h3>
          <table class="table" id="user-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Email</th>
                    <th scope="col">Location</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
              <?php
              if (empty($bannedUsers)) {
                echo "<tr><td colspan=\"5\">No banned users</td></tr>";
              } else {
                foreach ($bannedUsers as $bannedUser) { ?>
                  <tr>
                    <td><?php echo $bannedUser[User::USER_ID]; ?></td>
                    <td><?php echo $bannedUser[User::NAME]; ?></td>
                    <td><?php echo $bannedUser[User::DATE_OF_BIRTH]; ?></td>
                    <td><?php echo $bannedUser[User::EMAIL]; ?></td>
                    <td><?php echo $bannedUser[User::LOCATION]; ?></td>
                    <td class="text-center"><a class="dropdown-item button w-100" href="<?php echo Database::UNBAN_USER . "?" . User::USER_ID . "=" . $bannedUser[User::USER_ID]; ?>">Unban User</a></td>
                  </tr>
                <?php 
                }
              }
              ?>
            </tbody>
          </table>
        </div>
        <div class="form-row" id="top-1">
          <h3 class="text-primary table-striped font-weight-bold">Admin Users</h3>
          <table class="table" id="user-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Location</th>
                </tr>
            </thead>
            <tbody>
              <?php
                  foreach ($adminUsers as $adminUser) { ?>
                    <tr>
                      <td><?php echo $adminUser[User::USER_ID]; ?></td>
                      <td><?php echo $adminUser[User::NAME]; ?></td>
                      <td><?php echo $adminUser[User::DATE_OF_BIRTH]; ?></td>
                      <td><?php echo $adminUser[User::LOCATION]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
          <div class="form-row">
            <div class="col-lg-5 mx-auto" id="top-1">
                <h3 class="text-primary font-weight-bold">Active Users</h3>
                <table class="table" id="user-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Location</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Damian </td>
                        <td>Larkin</td>
                        <td>Kerry</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Padraig</td>
                        <td>McCarthy</td>
                        <td>Limerick</td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="col-lg-5 mx-auto" id="top-1">
              <h1>Side 2</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>


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