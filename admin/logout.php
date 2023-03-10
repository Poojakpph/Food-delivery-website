<?php 
   include('../config/constants.php');
  //this will destory all the session
   session_destroy();   //unsets $_SESSION['user']
   //redirect to login page
   header('location:'.SITEURL.'admin/login.php');

?>
