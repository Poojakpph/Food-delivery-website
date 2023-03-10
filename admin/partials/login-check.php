<?php
  
  //Autherization- Access control
  //check whter the user is logged in or not

  if(!isset($_SESSION['user'])){   //if user is not loged in
    //redirect to login page with message
    $_SESSION['no-login-message']="<div class='text-center'> Please Login to Acess Admin Panel</div>";
    header('location:'.SITEURL.'admin/login.php');

  }
?>
