<?php
   
   session_start();

   $_SESSION["error"] = array();

   $_SESSION["error"][] = "1";
   $_SESSION["error"][] = "2";
   $_SESSION["error"][] = "3";
   $_SESSION["error"][] = "4";
   $_SESSION["error"][] = "5";

   var_dump($_SESSION["error"]);

?>