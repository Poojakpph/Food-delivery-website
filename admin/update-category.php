<?php include('partials/menu.php'); ?>

<div class="main-content">
     <div class="wrapper">
          <h1>Update Category</h1>
          <br><br>
          
          <?php 
             //check whter id is set or not
             if(isset($_GET['id'])){
                //get the id and all other details
               // echo "getting data";
                $id= $_GET['id'];

                //create sql query to get all the other details
                $sql= "SELECT * FROM tbl_category WHERE id=$id";

                $res=mysqli_query($conn, $sql);

                //count the rows to check whter the id is valid or not
                $count= mysqli_num_rows($res);

                 if($count==1){
                    //get all the data
                    $row= mysqli_fetch_assoc($res);
                    $title= $row['title'];
                    $current_image= $row['img_name'];
                    $featured= $row['featured'];
                    $active= $row['active'];
                   }

                 else{
                    $_SESSION['no-category-found']="<div class='text-center'>Category Not Found</div>";                   
                    header('location:'. SITEURL. 'admin/manage-category.php');
                  }

             }

             else{
                //redirect to manage category
                header('location:'. SITEURL. 'admin/manage-category.php');
             }

           ?>
          <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                     <td>Current Image:</td>
                     <td>
                        <?php
                           if($current_image!=""){
                            //display the img
                              ?>
                              <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px">
                              <?php
                           }

                           else{
                              //display the message
                               echo "Image Not Added";
                            }
                        ?>
                     </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td><input <?php if($featured=="Yes"){echo "checked"; }?> type="radio" name="featured" value="Yes">Yes
                         <input <?php if($featured=="No"){echo "checked"; }?> type="radio" name="featured" value="No">No
                  </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td><input <?php if($active=="Yes"){echo "checked"; }?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked"; }?> type="radio" name="active" value="No">No
                  </td>
                </tr>


                <tr>
                   <td>
                    <input type="submit" name="submit" value="Update Category" class="btn-primary">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  </td>
                </tr>

            </table>

         </form>

<?php 
 if(isset($_POST['submit'])){
            // echo "clicked";
           // get all the values from the form
            $id= $_POST['id'];
            $title= $_POST['title'];
            $current_image= $_POST['current_image'];
            $featured= $_POST['featured'];
            $active= $_POST['active'];
            
            
            //2- updating the new img if selected
            //check wther img is selected or not
      if(isset($_FILES['image']['name'])){
           //get the img details
           $img_name= $_FILES['image']['name'];
           if($img_name!= ""){
                  //img available
                  //1- upload the new img
                    //auto rename our image


                   //get the extension of our image(jpg, png, gif etc.) for eg.- burger.jpg
                $ext= end(explode('.', $img_name));
                $img_name="Food_Category_".rand(000, 999). '.' .$ext;    //now it becomes Food_Category_823.jpg


                $source_path= $_FILES['image']['tmp_name'];
                $destination_path= "../images/category/".$img_name;
        

               //finally upload the img
                $upload= move_uploaded_file( $source_path, $destination_path);

                //checking whter the img uploaded or not
                //if not uploaded then we'll stop the process and redirect with error message
                if($upload==false){
                   //set message and then redirect to category page then stop the process
                   $_SESSION['upload']= "<div class='text-center'> Failed to Upload Image </div>";
                   header('location:'.SITEURL.'admin/manage-category.php');
                   die();
                  }

                  //2- remove the current img if available
                  if($current_image!=""){
                     $remove_path= "../images/category/".$current_image;
                     $remove= unlink($remove_path);
   
                     //check whter the img is removed or not
                     //if failed to remove then display message and stop the process
                     if($remove==false){
                        //failed to remove img
                        $_SESSION['failed-remove']= "<div class='text-center'> Failed to Remove Current Image </div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                        die();
                       }
                    }
                 }

                else{
                   $img_name= $current_image;
                  }

             }


        else{
           $img_name= $current_image;

            }

             $sql2 = "UPDATE tbl_category SET 
                title='$title',
                img_name='$img_name',
                featured='$featured',
                active='$active'
                WHERE id=$id  
                ";
          
            // excute the query
             $res2= mysqli_query($conn, $sql2);

             //redirect to manage category with message and check whter executed or not
             if($res2==true){
                //category updated
                $_SESSION['update']= "<div class='text-center'> Category Updated Successfully </div>";
                header('location:'.SITEURL.'admin/manage-category.php');
              }
            else{
                //failed to update category
                $_SESSION['update']= "<div class='text-center'> Failed to Updated Category </div>";
                header('location:'.SITEURL.'admin/manage-category.php');
                }

          }
        ?>
      </div>  
  </div>

<?php include('partials/footer.php'); ?>   


