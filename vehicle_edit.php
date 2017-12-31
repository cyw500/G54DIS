<?php
   include('session.php');

   // prevent user type in direct site
   if (!isset($_SESSION["Vehicle_ID"])) {
     header("Location: home.php");
   }

   include('vehicle_add.php');
?>
