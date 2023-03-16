<!-- header included -->
   <?php include('partials-front/menu.php'); ?>  
    
    <!-- Categories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
               //display all the category that are active
               $sql="SELECT * FROM tbl_category WHERE active='Yes'";

               //execute the query
               $res= mysqli_query($conn, $sql);  

               //count rows to check whter we've categories or not
               $count= mysqli_num_rows($res); 

               if($count>0){
                       while($row=mysqli_fetch_assoc($res)){
                           $id= $row['id'];
                           $title= $row['title'];
                           $img_name= $row['img_name'];
                           ?>
                             <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                               <div class="box-3 float-container">
                                  <?php
                                    //check whter img is available or not
                                    if($img_name==""){
                                        echo "Image Not Found";
                                    }
                                    else{ //img available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $img_name; ?>" 
                                                  alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                      }
                                  ?>
                                <h3 class="float-text text-white" ><div class="this"><?php echo $title; ?></div></h3>
                              </div>
                          </a>
                        
                        <?php
                       }
                    }

               else{  //we don't ve categories
                   echo "No Category Found";
                 }
             ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->
  
    <?php include('partials-front/footer.php'); ?>
