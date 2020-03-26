<?php
   
   require_once("init.php");

   $img = User::get_image_path(4);

   echo "<BR><BR>";
   echo $img;

   echo User::delete_image(4);

   /*
   $dateUploaded = date("Y-m-d H:i:s");
   $milliseconds = round(microtime(true) * 1000);
   $folderpath = User::USER_IMAGES;

   $conn = Database::connect();

   $sql = "SELECT photoID, userID, filePath, dateUploaded FROM photo";
   $result = $conn->query($sql);
   
   if ($result->num_rows > 0) {
       // output data of each row
       while($row = $result->fetch_assoc()) {
                  
           $photoID = $row["photoID"];
           $userId = $row["userID"];
           $filePath = $row["filePath"];
           $dateUploaded = $row["dateUploaded"];
   
   
       }
   } else {
       echo "0 results";
   }

   // get full filename incl. extension
   $ext = pathinfo($_FILES["userImage"]["name"], PATHINFO_EXTENSION);
   $fileName = $_SESSION[User::USER_ID] . "_" . $milliseconds . "." . $ext;
   
   // Check if image file is a actual image or fake image
   if(isset($_POST["submit"])) {
       $check = getimagesize($_FILES["userImage"]["tmp_name"]);
       if($check !== false) {
           echo "File is an image - " . $check["mime"] . ".";
           
           // change file name
   
   move_uploaded_file($_FILES["userImage"]["tmp_name"], "user_images/" . $newfilename);
          
          $uploadOk = 1;
       } else {
           echo "File is not an image.";
           $uploadOk = 0;
       }
   }
   
   
   
   
   // Check if file already exists
   if (file_exists($newfilename)) {
       echo "Sorry, file already exists.";
       $uploadOk = 0;
   }
   
   
   
   // Check file size 2MB from https://www.gbmb.org/mb-to-bytes
   if ($_FILES["userImage"]["size"] > 2097152) {
       echo "Sorry, your file is too large.";
       $uploadOk = 0;
   }
   // Allow certain file formats
   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
   && $imageFileType != "gif" ) {
       echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
       $uploadOk = 0;
   }
   // Check if $uploadOk is set to 0 by an error
   if ($uploadOk == 0) {
       echo "Sorry, your file was not uploaded.";
   // if everything is ok, try to upload file
   } else {
     //  if (move_uploaded_file($_FILES["userImage"]["name"], $target_file)) {
           echo "The file ". basename( $_FILES["UserImage"]["name"]). " has been uploaded.";
           
           
           $dateUploaded = $day . " " . $time;
           
           $path = $folderpath . $newfilename;
           // update the filepath
           $query = "UPDATE photo SET filePath = ? WHERE userID = ?";
                   $stmt = $conn->prepare($query);
                   $stmt -> bind_param ("si" , $path , $userId);
                   $stmt->execute();
                   
                   
                   // update the day and the time
                   $query = "UPDATE photo SET dateUploaded = ? WHERE userID = ?";
                   $stmt = $conn->prepare($query);
                   $stmt -> bind_param ("si" , $dateUploaded , $userId);
                   $stmt->execute();
           }
   
   $conn->close();
   
   header( "refresh:5;url=img_upload.html" );
 */
?>