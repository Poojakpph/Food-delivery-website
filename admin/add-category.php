<?php include('partials/menu.php'); ?>

     <div class="main-content">
       <div class="wrapper">
          <h1>Add Category</h1>
          <br><br>
         
          <?php 
           if(isset($_SESSION['add'])){
               echo $_SESSION['add'];
               unset($_SESSION['add']);
           }

           if(isset($_SESSION['upload'])){
             echo $_SESSION['upload'];
             unset($_SESSION['upload']);
          }
        ?>
        <br><br>

          <!-- add category starts -->
          
        <form action="" method="POST" enctype="multipart/form-data">
           <table class="tbl-30">

             <tr>
                <td>Title: </td>
                <td><input type="text" name="title" placeholder="Category Title"></td>
            </tr>

            <tr>
                <td>Select Image:</td>
                <td><input type="file" name="image"></td>
            </tr>

             <tr>
                <td>Featured:</td>
                <td>
                  <input type="radio" name="featured" value="Yes">Yes
                  <input type="radio" name="featured" value="No">No
                 </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                  <input type="radio" name="active" value="Yes">Yes
                  <input type="radio" name="active" value="No">No
                 </td>
            </tr>

            <tr>
                <td colspan="2">
                  <input type="submit" name="submit" value="Add-Category" class="btn-secondary">
                 </td>
            </tr>

          </table>
       </form>
   <!-- add category ends -->

    <?php 
      //check whter submit button clicked or not
      if(isset($_POST['submit'])){

         //get the value from category form
          $title=$_POST['title'];

          //for radio input, we need to check whter the button is selected or not
          if(isset($_POST['featured'])){
            //get the value from form
             $featured=$_POST['featured'];
          }

          else{
            //set the default value i.e no
              $featured="No";
           }

          if(isset($_POST['active'])){
             //get the value from form
             $active=$_POST['active'];
          }

          else{
            //set the default value i.e no
            $active="No";
           }

        // check whter the image is selected or not and set the value for img accordingly
        // print_r($_FILES['image']);
        // die();   //break the code here


        //upload the img
        if(isset($_FILES['image']['name'])){
            //to upload the img we need source path, destination path and img name
            $img_name= $_FILES['image']['name'];

            // upload the img only if image is selected
            if($img_name!= ""){

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
                   header('location:'.SITEURL.'admin/add-category.php');
                   die();
                  }
                }
            }


            else{
                //don't upload the img and set the image_name as blank
                $img_name="";

            }
        

        //2. create Sql query to insert category into DB
         $sql="INSERT INTO tbl_category SET
           title='$title',
           img_name='$img_name',
           featured='$featured',
           active='$active'
          ";

        //3. Execute the query and save in DB
        $res= mysqli_query($conn, $sql);

        //4. eheck whter query executed or not and data added or not
        if($res==true){
            $_SESSION['add']= "<div class='text-center'> Category Added Successfully </div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        else{
            $_SESSION['add']= "<div class='text-center'> Failed to Add Category.</div>";
            header('location:'.SITEURL.'admin/add-category.php');
          }
        
        }    
 ?>
           
  </div>
</div>

<?php include('partials/footer.php');?>
 
