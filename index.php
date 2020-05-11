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

</head>

<body id="page-top">
  <?php
    require_once("init.php");

    if (isset($_SESSION[User::LOGGED_IN]) && $_SESSION[User::LOGGED_IN] == 1) {
      if ($_SESSION[User::IS_ADMIN] == 1) {
        header("Location: " . Database::ADMIN_DASHBOARD);
      } else {
        header("Location: " . Database::VIEW_PROFILE);
      }
      exit();
    }

  // Navigation 
  include("snippets/navbar.php");
  ?>

  
  

  <header class="masthead">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-lg-7 my-auto">
          <div class="header-content">
            <h1 class="mb-5"><span style="background-color: #ffb7ed; border-radius: 4px;"><font color="white">&nbsp&nbspWelcome to MeetAmour&nbsp&nbsp</font></span></h1>
            <h2 class="mb-5"><span style="background-color: #ff70db; border-radius: 4px;"><font color="white"> &nbsp&nbspFind.&nbsp </span>
                                &nbsp<span style="background-color: #ffb7ed; border-radius: 4px;">&nbsp Match. &nbsp</span> <span style="background-color: #ff70db; border-radius: 4px;">
                                  &nbsp&nbspDate.&nbsp&nbsp </span></font></h2>
            <div class="form-row">
              <div class="col-lg-4">
            <a href="<?php echo Database::REGISTER; ?>" class="btn btn-outline btn-xl js-scroll-trigger w-100">Sign up today!</a>
            </div>
            <div class="col-lg-4">
              <a href="<?php echo Database::LOGIN; ?>" class="btn btn-outline btn-xl js-scroll-trigger w-100">Login</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 my-auto">
          <div class="device-container">
            <div class="device-mockup iphone6_plus portrait white">
              <div class="device">
                <div class="screen">
                  
                  <img src="img/demo-screen-1.jpg" class="img-fluid" alt="">
                </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section class="download bg-primary text-center" id="download">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <h2 class="section-heading">Meet your perfect partner now! <br> <h3><font color="white"> (No strings attached! ☺)</font></h3></h2>
          
          <div class="badges">
            <a class="badge-link" href="#"><img src="img/logo.png" alt=""></a>
            
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="features" id="features">
    <div class="container">
      <div class="section-heading text-center">
        <h2>Why MeetAmour?</b></h2>
        
        <hr>
      </div>
      
        <div class="col-lg-11.1 my-auto">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-screen-smartphone text-primary"></i>
                  <h3>Mobile friendly</h3>
                  <p class="text-muted">Our website is mobile friendly! App coming soon!</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-camera text-primary"></i>
                  <h3>Picture Gallery</h3>
                  <p class="text-muted">Place up to 5 photos or videos of yourself out there!</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-present text-primary"></i>
                  <h3>Surprises</h3>
                  <p class="text-muted">Everybody likes surprises, each time you login, you will be met with matches to suit you!</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-lock-open text-primary"></i>
                  <h3>Free to use</h3>
                  <p class="text-muted">No pay walls, no worries, no credit cards. Simply free and will always remain that way.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </section>

  <section class="cta" id="cta">
    <div class="cta-content">
      <div class="container">
        <h2>Find.<br>Match.<br>Date.</h2>
        <a href="<?php echo Database::REGISTER; ?>" class="btn btn-outline btn-xl js-scroll-trigger">Sign up now!</a>
      </div>
    </div>
    <div class="overlay"></div>
  </section>

  <section class="contact bg-primary" id="contact">
    <div class="container">
      <h2>We'd
        <i class="fas fa-heart"></i>
        to hear from you!</h2>
      <ul class="list-inline list-social">
        <li class="list-inline-item social-twitter">
          <a href="#">
            <i class="fab fa-twitter"></i>
          </a>
        </li>
        <li class="list-inline-item social-facebook">
          <a href="#">
            <i class="fab fa-facebook-f"></i>
          </a>
        </li>
        <li class="list-inline-item social-google-plus">
          <a href="#">
            <i class="fab fa-google-plus-g"></i>
          </a>
        </li>
      </ul>
    </div>
  </section>

  <footer>
    <div class="container">
      <p>&copy; MeetAmour 2020. All Rights Reserved.</p>
      <ul class="list-inline">
        <li class="list-inline-item">
          <a href="<?php echo Database::FAQ ?>">FAQ</a>
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
