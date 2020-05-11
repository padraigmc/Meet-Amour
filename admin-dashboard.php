<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
?>
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

  <style>
    .button {
      color: white;
      background-color: #ff70db;
      font-family: Poppins-Regular, sans-serif;
    }

  </style>

</head>
<?php

  require_once("init.php");
  require_once("classes/Admin.php");

  Verify::redirect_not_admin();
  
  $databaseConnection = Database::connect();

  $bannedUsers = Admin::get_banned_users($databaseConnection);


?>

<body id="page-top">
<?php
  include_once("snippets/navbar.php");
?>

<section class="admin-top bg-primary" id="admin-top">
    <div class="container-fluid main">
      <div class="row">
        <div class="col-lg-12">
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
        </div>
      </div>
    </div>
</section>


<footer>
    <div class="container">
      <p>&copy; MeetAmour 2020. All Rights Reserved.</p>
      <ul class="list-inline">
      <li class="list-inline-item">
                <a href="<?php echo Database::FAQ ?>">FAQ</a>
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
  
 </body>
 
 </html>