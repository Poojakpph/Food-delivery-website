<?php
   include('../config/constants.php');      // by .. we can move out of the folder
   
//1- get the id of the admin to be deleted
  $id = $_GET['id'];

//2-create sql query to delete admin
  $sql= "DELETE FROM tbl_admin WHERE id= $id";

  //execute the query
  $res= mysqli_query($conn, $sql);

  //check whter query is executed or not
  if($res==TRUE){
   // echo "admin dleted";
   //create session variable to display message on the admin page
     $_SESSION['delete']="Admin Deleted";
     //now redirect to manage admin page
     header('location:'. SITEURL. 'admin/manage-admin.php');

  }
  else{
    //echo "admin not dleted";
    $_SESSION['delete']="Failed to Delete Admin. Try Again Later";
    //now redirect to manage admin page
    header('location:'. SITEURL. 'admin/manage-admin.php');

  }

?>
