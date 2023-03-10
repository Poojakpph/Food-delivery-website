<?php include('partials/menu.php'); ?>

  <?php
    //check whter id is set or not
    if(isset($_GET['id'])){
        $id= $_GET['id'];   //get all the details of the id
        
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        $res2 =mysqli_query($conn, $sql2); 
        //get the value based on query executed
        $row2 =mysqli_fetch_assoc($res2);

        //get the individual values of selected food
        $title= $row2['title'];
        $description= $row2['description'];
        $price= $row2['price'];
        $current_img= $row2['img_name'];
        $current_category= $row2['category_id'];
        $featured= $row2['featured'];
        $active= $row2['active'];
    }
    
    else{
        //redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }

  ?>

 <div class="main-content">
     <div class="wrapper">
          <h1>Update Food</h1>
          <br><br>
          <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5" value="<?php echo $description; ?>"></textarea></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_img ==""){   //img not available
                                echo "<div>Image Not Available</div>";
                            }
                            else{
                                ?>
                                 <img src="<?php echo SITEURL; ?>images/food/<?php  echo $current_img; ?>" width="90px">
                                <?php       
                            }
                          
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 
                                //create sql to get all the active categories from DB
                                $sql="SELECT * FROM tbl_category WHERE active='Yes' ";
                                $res= mysqli_query($conn, $sql);   //executing query
                                //count rows to check whter we've categories or not
                                $count= mysqli_num_rows($res); 

                                if($count>0){
                                    while($row=mysqli_fetch_assoc($res)){
                                        $category_id= $row['id'];
                                        $category_title= $row['title'];
                                       // echo "<option value='$category_id'>$category_title</option>";
                                       ?>
                                        <option <?php if($current_category== $category_id) {echo "selected"; } ?> 
                                            value="<?php echo $category_id; ?>"><?php  echo $category_title; ?></option>
                                      <?php
                                    
                                    }
                                }

                                else{  //we don't ve categories
                                  echo "<option value='0'>No Category Found</option>";
                                }
                                
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td><input <?php if($featured=="Yes") {echo "checked"; } ?> type="radio" name="featured" value="Yes">Yes
                         <input <?php if($featured=="No") {echo "checked"; } ?> type="radio" name="featured" value="No">No
                  </td>
                </tr>


                <tr>
                    <td>Active: </td>
                    <td><input <?php if($active=="Yes") {echo "checked"; } ?> type="radio" name="active" value="Yes">Yes
                         <input <?php if($active=="No") {echo "checked"; } ?> type="radio" name="active" value="No">No
                  </td>
                </tr>

                <tr>
                    <td>
                      <input type="hidden" name="id" value="<?php echo $id; ?>"> 
                      <input type="hidden" name="current_img" value="<?php echo $current_img; ?>">  
                      <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
         </form>
        
   <?php
    if(isset($_POST['submit'])){
        //1. get all the details from the form
        $id=$_POST['id'];
        $title=$_POST['title'];
        $description=$_POST['description'];
        $price=$_POST['price'];
        $current_img=$_POST['current_img'];
        $category=$_POST['category'];
        $featured=$_POST['featured'];
        $active=$_POST['active'];

        //2- upload the img if selected
        //check whter butn is clicked or not
        if(isset($_FILES['image']['name'])){
            //upload btn is clicked
            $img_name =$_FILES['image']['name']; //new img name
            //check whter file is available or not
            if($img_name!=""){
                //A- uploading new img
                $ext= end(explode('.', $img_name));
                $img_name="Food-Name-".rand(0000, 9999). "." .$ext;    
                $source_path= $_FILES['image']['tmp_name'];
                $destination_path= "../images/food/".$img_name;

                $upload= move_uploaded_file( $source_path, $destination_path);

                //check whter img uploaded or not
                if($upload==false){  
                    $_SESSION['upload']= "<div class='text-center'> Failed to Upload New Image </div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    die();
                }

                //3- remove the img if new img is uploaded and current img exists
                //B- remove the current img if available
                if($current_img!=""){
                    $remove_path= "../images/food/".$current_img;
    
                    $remove= unlink($remove_path);
    
                    //check whter img is removed or not
                    if($remove==false){  
                        $_SESSION['remove-failed']= "<div class='text-center'> Failed to Remove Current Image </div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                     }
                 }
             }

        }

        else{
            $img_name= $current_img;
        }

       
    //4- update the food in DB
     $sql3= "UPDATE tbl_food SET
        title='$title',
        description='$description',
        price= $price,
        img_name='$img_name',
        category_id= $category,
        featured='$featured',
        active='$active'
        WHERE id=$id   
       ";

        //execute the query
        $res3= mysqli_query($conn, $sql3);  
      
       if($res3==true){
           $_SESSION['update']= "<div class='text-center'> Food Updated Successfully.</div>";
           header('location:'.SITEURL.'admin/manage-food.php');
       }
       else{
           $_SESSION['update']= "<div class='text-center'> Failed to Update Food. </div>";
           header('location:'.SITEURL.'admin/manage-food.php');
         }
         
     }
          
   ?>
  </div>  
 </div>

<?php include('partials/footer.php'); ?> 
