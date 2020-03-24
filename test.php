<?php
   
   session_start();
   $_SESSION["error"] = array();

   require_once("classes/User.php");


   $test = null;

   function test($var) {
       echo (!isset($var)) ? "1" : "0";
   }

   test($test);
 
?>