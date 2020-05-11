<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

  <style>
    .accordion {
      background-color: #eee;
      color: #444;
      cursor: pointer;
      padding: 18px;
      width: 100%;
      border: none;
      text-align: left;
      outline: none;
      font-size: 15px;
      transition: 0.4s;
    }

    .active, .accordion:hover {
      background-color: #ffb7ee;
    }

    .accordion:after {
      content: '\002B';
      color: #ffc3f1;
      font-weight: bold;
      float: right;
      margin-left: 5px;
    }

    .active:after {
      content: "\2212";
    }

    .panel {
      padding: 0 18px;
      background-color: white;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.2s ease-out;
    }
  </style>
</head>

<body id="page-top">
  <?php
    include("snippets/navbar.php");
  ?>

  </br>

    <section class="download bg-primary text-center" id="download">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <h2 class="section-heading">Frequently Asked Questions <br> <h3><font color="white"></font></h3></h2>
          
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
        <h2>FAQ Section</h2>
        <hr>
    </div>

    <button class="accordion">How do I create an account?</button>
    <div class="panel">
      <p>You can create an account by going to the following link to <a href="register.php">register now</a></p>
    </div>

    <button class="accordion">Who is this dating site for?</button>
    <div class="panel">
      <p>This dating site is for people in the Munster region of Ireland who have an interest in computer science and want to find like minded individuals.</p>
    </div>

    <button class="accordion">How do I change my password?</button>
    <div class="panel">
      <p>You can change your password by following the steps on our <a href="login.php">login page</a> and selecting <b>forgot password.</b></p>
    </div>

    <button class="accordion">Who developed this site?</button>
    <div class="panel">
      <p>This website was developed by Padraig McCarthy, Damian Larkin, Wasim Ghazal and Ashutosh Yadav. You can learn more <a href="about-us.html">here</a></p>
    </div>

    <button class="accordion">How old do you have to be to register?</button>
    <div class="panel">
      <p>You have to be over 18 to register on our site.</p>
    </div>

    <button class="accordion">Will I definitely get a match?</button>
    <div class="panel">
      <p>Our super duper secret matching algorithm will do it's very best to find a match for you!</p>
    </div>

    <script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        } 
      });
    }
    </script>          
  </section>

  <section class="cta" id="cta">
    <div class="cta-content">
      <div class="container">
        <h2>Find.<br>Match.<br>Date.</h2>
        <a href="register.php" class="btn btn-outline btn-xl js-scroll-trigger">Sign up now!</a>
      </div>
    </div>
    <div class="overlay"></div>
  </section>

  <section class="contact bg-primary" id="contact">
    <div class="container">
      <h2>We'd
        <i class="fas fa-heart"></i>
        to connect with you!</h2>
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
