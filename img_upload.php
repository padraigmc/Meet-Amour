<html lang="en">

  <head>
    <title>Photo upload</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

  </head>

  <body data-gr-c-s-loaded="true">
    <?php

      if (isset($_POST["submit"])) {
        
        // session start, include User.php and declare error session var
        include_once("init.php");
        $_SESSION[User::USER_ID] = 7;

        echo User::upload_user_image($_SESSION[User::USER_ID], "userImage");

        sleep(2);

        echo User::delete_user_image($_SESSION[User::USER_ID]);

      }
    ?>


    <div class="limiter">
      <div class="container-login100">
        <div class="wrap-login100">
          <div class="login100-pic js-tilt" data-tilt="" style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
            <img id="thumbnil" src="./user_images/no_avatar.png" alt="image" />
          </div>

          <form class="login100-form validate-form" action="img_upload.php" method="post" enctype="multipart/form-data">
            <span class="login100-form-title">
              Select image to upload:
            </span>

            <input type="file" name="userImage" class="form-control-file" id="fileToUpload" onchange="showMyImage(this)">




            <div class="container-login100-form-btn">

              <div class="container-login100-form-btn">
                <input class="login100-form-btn" type="submit" value="Upload Image" name="submit">
                <br>
              </div>
              <br>
            </div>

            <br> <br> <br>


          </form>
        </div>
      </div>
    </div>




<!-- to change the photo next to the form with the photo that the user need to upload -->
    <script src="js/js.js"></script>
  


  </body>

</html>
