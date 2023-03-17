<?php
  include('../config/constants.php'); 
   
   if(isset($_GET['id']) && isset($_GET['img_name']) ){
        //1- get id and img name 
        $id = $_GET['id'];
        $img_name = $_GET['img_name'];

        //2- remove the img only if it's available
        if($img_name!=""){
            //it's has img and need to remove from folder
            //get the img path
            $path= "../images/food/".$img_name;
            //remove the img file from folder
            $remove= unlink($path);
            
            //check whter img removed or not
            if($remove==false){
                //failed to remove the img
                $_SESSION['upload']="<div class='text-center'>Failed to Remove Image File.</div>";
                header('location:'. SITEURL. 'admin/manage-food.php');
                //stop process of dleting the food
                die();
                }
        }

        //3- delete food from DB
        $sql= "DELETE FROM tbl_food WHERE id= $id";

        //execute the query
        $res= mysqli_query($conn, $sql);

        //check whter query is executed or not
        //4- redirect to manage food with session message
        if($res==TRUE){
            $_SESSION['delete']="Food Deleted Successfully.";
            header('location:'. SITEURL. 'admin/manage-food.php');
        }

        else{
            $_SESSION['delete']="Failed to Delete Food. Try Again Later";
            header('location:'. SITEURL. 'admin/manage-food.php');
        }        
   }

   else{
    $_SESSION['unauthorized']="Unauthorized Access";
    header('location:'. SITEURL. 'admin/manage-food.php'); 
   }

?>
