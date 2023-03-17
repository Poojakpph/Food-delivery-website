<?php include('partials/menu.php'); ?>

<div class="main-content">
   <div class="wrapper">
           <h1>Change Password</h1>
            <br><br>

              <?php 
                if(isset($_GET['id']))
                   $id=$_GET['id'];
              ?>
             <form action="" method="POST">
                  <table class="tbl-30">

                    <tr>
                        <td>Current Password:</td>
                        <td>
                            <input type="password" name="current_password" placeholder="Current Password">
                        </td>
                    </tr>

                    <tr>
                        <td>New Password:</td>
                        <td>
                            <input type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password:</td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                       <input type="hidden" name="id" value="<?php echo $id; ?>" >
                       <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                       </td>
                   </tr>

               </table>
           </form>
        </div>
  </div>

  <?php 
      //checked whter submit button is clicked or not
     
  if(isset($_POST['submit'])){

     //1- get the data from the form
       $id= $_POST['id'];
       $current_password= md5($_POST['current_password']);
       $new_password= md5($_POST['new_password']);
       $confirm_password= md5($_POST['confirm_password']);

     //2- check whter the user with current ID and current password exists or not
       $sql= "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";    // here '' is there in current_password bcz it's a string

    //    //exceute the query
       $res= mysqli_query($conn, $sql);

    if($res==true){
           //check whter data is available or not
           $count=mysqli_num_rows($res);
           if($count==1){
               // user exists and password can't be changed
               // echo "User Found";
          //3- check whter the new password and confirm password matches or not
                if($new_password==$confirm_password){
                    //update the password
                     $sql2= "UPDATE tbl_admin SET
                     password='$new_password'
                     WHERE id=$id ";

                     //excute the query
                     $res2= mysqli_query($conn, $sql2);
                       
                     //check whter the query executed or not
                       if($res2==true){
                          //display success message and redirect to manage admin page with success message
                          $_SESSION['change-pwd']="Password Changed Successfully";
                          //redirect to manage admin page
                           header('location:'.SITEURL.'admin/manage-admin.php');
                         }
                         else{
                              //display error message and redirect to manage admin page with error message
                             $_SESSION['change-pwd']="Failed to Change Password";
                             //redirect to user
                             header('location:'.SITEURL.'admin/manage-admin.php');
                          } 
                       }

                 else{
                       //redirect to manage admin page with error message
                     $_SESSION['pwd-not-match']="Password Did Not Match";
                       //redirect to manage admin page
                     header('location:'.SITEURL.'admin/manage-admin.php');

                     }
                }

            else{
                //user doesn't exists set message and redirect
                $_SESSION['user-not-found']="User Not Found";
                 //redirect to manage admin page
              header('location:'.SITEURL.'admin/manage-admin.php');

            }
        }
    }

  ?>
   
<?php  include('partials/footer.php'); ?>

