<?php include('partials/menu.php'); ?>

      <!-- main content section starts -->
      <div class="main-content">
        <div class="wrapper">
           <h1>Manage Admin</h1><br><br>
            
           <?php 
             if(isset($_SESSION['add'])){
              echo $_SESSION['add'];    //display the session if message is set
              unset($_SESSION['add']);    //remove session message
              }

              if(isset($_SESSION['delete'])){
               echo $_SESSION['delete'];    //display the dlete if message is set
               unset($_SESSION['delete']);    //remove session message
               }

               if(isset($_SESSION['update'])){
                  echo $_SESSION['update'];    
                  unset($_SESSION['update']);    
                  }

               if(isset($_SESSION['user-not-found'])){
                     echo $_SESSION['user-not-found'];    
                     unset($_SESSION['user-not-found']);    
                  }

               if(isset($_SESSION['pwd-not-match'])){
                     echo $_SESSION['pwd-not-match'];    
                     unset($_SESSION['pwd-not-match']);    
                  }

                if(isset($_SESSION['change-pwd'])){
                     echo $_SESSION['change-pwd'];    
                     unset($_SESSION['change-pwd']);    
                  }
                  
           ?>
           <br><br><br> 

           <!-- button to add admin -->
           <a href="add-admin.php" class="btn-primary">Add Admin</a><br><br><br>

           <table class="tbl-full">
              <tr>
                <th>S No.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
              </tr>
               

              <?php    
              // query to get the data from the add admin section 
                $sql= "SELECT * FROM tbl_admin";
                //execute the query
                $res=mysqli_query($conn, $sql);
                //check whter the query is excueted or not
             if($res==TRUE){

                //count rows to check whter we have data in DB or not
                $count= mysqli_num_rows($res);   //give the no. of rows
                 
                 $sn=1;  //create a varible and assign it 1

                 //check the no. of rows
                  if($count> 0){
                      //we have data in DB
                        while($rows=mysqli_fetch_assoc($res)){   //get all the data from the DB and will run as long as we have data 
                              //get individual data
                            $id= $rows['id'];
                            $full_name= $rows['full_name'];
                            $username= $rows['username'];

                            //display the values in our table
                            ?>
                               <tr>
                                  <td><?php echo $sn++; ?></td>
                                  <td><?php echo $full_name; ?></td>
                                  <td><?php echo $username; ?></td>
                                  <td>
                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-secondary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a> 
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Delete Admin</a>
                               </td>
                           </tr>

                      <?php

                       }
                    }

                  else{
                      //we don't have data in DB
                     }
             }

              ?>

           </table>
         </div>  
      </div>
      <!-- main content section ends -->

<?php include('partials/footer.php'); ?>   
