<?php include('partials/menu.php'); ?>

<div class="main-content">
     <div class="wrapper">
          <h1>Add Food</h1>
          <br><br>
          <?php
           if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
            }
          
          ?>
          
          <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Title of the food"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price"></td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                          <?php 
                              //create PHP code to display categories from DB
                              //create sql to get all the active categories from DB
                              $sql="SELECT * FROM tbl_category WHERE active='Yes' ";
                              $res= mysqli_query($conn, $sql);   //executing query
                              //count rows to check whter we've categories or not
                              $count= mysqli_num_rows($res); 

                              if($count>0){
                                   while($row=mysqli_fetch_assoc($res)){
                                    //get the details of categories
                                    $id= $row['id'];
                                    $title= $row['title'];
                                    ?>
                                     <option value="<?php echo $id; ?>"><?php  echo $title; ?></option>
                                    <?php
                                }
                              }

                              else{  //we don't ve categories
                                ?>
                                 <option value="0">No Category Found</option>
                                <?php
                              }

                            //2- display on dropdown
                             
                           ?>

                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Featured: </td>
                    <td><input type="radio" name="featured" value="Yes">Yes
                         <input type="radio" name="featured" value="No">No
                  </td>
                </tr>


                <tr>
                    <td>Active: </td>
                    <td><input type="radio" name="active" value="Yes">Yes
                         <input type="radio" name="active" value="No">No
                  </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

         </form>
      
     <?php

          //check whter submit button is clicked or not

            if(isset($_POST['submit'])){
             //1- get the data from the form
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $category=$_POST['category'];

                //check whter radio btn for featured and active are checked or not
               if(isset($_POST['featured'])){
                    $featured =$_POST['featured'];
                }
                else{
                    $featured = "No";
                }
                if(isset($_POST['active'])){
                    $active =$_POST['active'];
                }
                else{
                    $active = "No";
                }

                //2- upload the img if selected
                //check whter the select img is clicked or not and upload the img only if img is selected
                if(isset($_FILES['image']['name'])){  
                    //get the details of selected img 
                    $img_name =$_FILES['image']['name'];

                    if($img_name!=""){
                        //img is selected, now rename the img and then upload the img
                        $ext= end(explode('.', $img_name));

                        //create new img for img
                        $img_name="Food-Name-".rand(0000, 9999). "." .$ext;    //now it becomes Food_Category_823.jpg

                        //get the src path (src path is the current location of the img)
                        $source_path= $_FILES['image']['tmp_name'];

                        //destination path for the img to be uploaded 
                        $destination_path= "../images/food/".$img_name;

                        //file will gets uploaded from destn path to src path
                        $upload= move_uploaded_file( $source_path, $destination_path);

                        //check whter img uploaded or not
                        if($upload==false){  
                            $_SESSION['upload']= "<div class='text-center'> Failed to Upload Image </div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            die();
                        }
                     } 

                }

                else{
                    $img_name="";   //setting default value as blank

                }

             //3- insert into DB
             //create sql query to save or add food
             $sql2= "INSERT INTO tbl_food SET
              title='$title',
              description='$description',
              price= $price,
              img_name='$img_name',
              category_id= $category,
              featured='$featured',
              active='$active'   
             ";

             //execute the query
             $res2= mysqli_query($conn, $sql2);  
             //check whter data inserted or not
            //4- redirect with message to manage food page
            if($res2==true){
                $_SESSION['add']= "<div class='text-center'> Food Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else{
                $_SESSION['add']= "<div class='text-center'> Failed to Add Food. </div>";
                header('location:'.SITEURL.'admin/manage-food.php');
              }

            }
         ?>

      </div>  
   </div>

<?php include('partials/footer.php'); ?>  
