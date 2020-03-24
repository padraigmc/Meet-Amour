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
        <form id="info">
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" id="email" placeholder="First Name" name="fname">
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Last Name" name="lname">
              </div>
            </div>
        </br>
            <div class="form-row">
                <div class="col text-left font-weight-bold">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob">
                </div>
                <div class="col text-left font-weight-bold">
                    <label for="location">Location</label>
                    <select class="form-control" id="location" name="location">
                        <option value="limerick">Limerick</option>
                        <option value="cork">Cork</option>
                        <option value="dublin">Dublin</option>
                        <option value="galway">Galway</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                
            <div class="col text-left font-weight-bold">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
            </div>
            <div class="col text-left font-weight-bold bottom-div">
                <label for="seeking">Seeking</label>
                <select class="form-control" id="seeking" name="seeking">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <textarea class="form-control" rows="4" cols="50" name="bio" placeholder="About You"></textarea>
            </div>
          </div>
            <div class="row">
              <div class="col">
                  <input type="submit" value="Save">
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
    <input type="submit" value="Upload">
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