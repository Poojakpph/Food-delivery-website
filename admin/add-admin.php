<?php include('partials/menu.php'); ?>

<div class="main-content">
     <div class="wrapper">
          <h1>Add Admin</h1>
          
          <br><br>
          <?php 
             if(isset($_SESSION['add'])){    //checking whther the session is set or not
              echo $_SESSION['add'];   //display the session if message is set
              unset($_SESSION['add']);  //remove session message
             }
           ?>
          
          <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>

                <tr>
                    <td>UserName: </td>
                    <td><input type="text" name="username" placeholder="Enter Your Username"></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter Your Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

          </form>


         </div>  
      </div>

<?php include('partials/footer.php'); ?>   


<?php 
    
    
// process the value from form then save it in the database
// check whether the submit btn is clicked or not
    if(isset($_POST['submit'])){
        
  // 1- get the data from the form
        $full_name=$_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);  //password encrypted with MD5

  //2- SQL query to save the data into database
        $sql="INSERT INTO tbl_admin SET
       full_name='$full_name',   
       username= '$username',
       password= '$password'
      ";

    //3- excueting query and saving data into database
    $res= mysqli_query($conn, $sql) or die(mysqli_error());

    if($res==TRUE){
        // data is inserted
        //create a session variable to display message
        $_SESSION['add']="Admin Added Successfully!";
       
        //redirect page to manage admin page
         header("Location: ".SITEURL.'admin/manage-admin.php');
    
      }
    
      else{
        //failed to insert data
    
        $_SESSION['add']="Failed to add successfully";
    
        //redirect page to add admin page
        header("Location: ".SITEURL.'admin/add-admin.php');     

       } 
  
  }

 ?>   
     
