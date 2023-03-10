<?php 
  include('../config/constants.php');
  // check whter the id and img_name value is set or not
  if(isset($_GET['id']) AND isset($_GET['img_name'])){
     //get the value and delete
     $id= $_GET['id'];
     $img_name= $_GET['img_name'];

     //removing the physical image file is available
     if($img_name !=""){
           //image is available , so remove it
           $path= "../images/category/".$img_name;
           //remove the img
           $remove= unlink($path);

           //if failed to remove img then add an error message and stop the process
           if($remove==false){
             //set the session message then redirect to manage category page then stop the process
             $_SESSION['remove']="<div class='text-center'>Failed to Remove Category Image. Try Again Later</div>";
             header('location:'. SITEURL. 'admin/manage-category.php');
              die();
              }

       }
       //delete data from DB
       // sql query to delete data from DB
       $sql= "DELETE FROM tbl_category WHERE id=$id";

       $res= mysqli_query($conn, $sql);

       if($res==true){
           //set success message and redirect
           $_SESSION['delete']="<div class='text-center'>Category Deleted Successfully</div>";
           header('location:'. SITEURL. 'admin/manage-category.php');
         }

        else{
            $_SESSION['delete']="<div class='text-center'>Failed to Delete Category</div>";
            header('location:'. SITEURL. 'admin/manage-category.php');
          }

    }

  else{
      //redirect to manage category page
      header('location:'. SITEURL. 'admin/manage-category.php');
  }


?>
