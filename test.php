<?php
   
   session_start();
   $_SESSION = array();


   if (isset($_SESSION["test"]) && $_SESSION["test"] == 1) {
      echo "1";
  } else {
      echo "0";
  }

?>