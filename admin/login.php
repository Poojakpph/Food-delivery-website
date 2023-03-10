 <?php  include('../config/constants.php'); ?>

 <html>
    <head>
        <title>Login- Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
      <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php 
           if(isset($_SESSION['login'])){
               echo $_SESSION['login'];
               unset($_SESSION['login']);
            }

           if(isset($_SESSION['no-login-message'])){
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
           }

        ?> 
        <br><br>

        <!-- login form starts -->
        <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter your username"><br><br>
             Password: <br>
            <input type="password" name="password" placeholder="Enter your password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary"><br><br>
        </form>
         <!-- login form ends -->
        <p class="text-center">© 2022 www.WowFood- the heaven. All rights reserved.</p>
      </div>
        
    </body>
 </html>

 <?php 
   //check whter submit button clicked or not
   if(isset($_POST['submit'])){
      //1. get the data from the login form
     $username= $_POST['username'];
     $password= md5($_POST['password']);

      //2. sql to check whter the user with username and password exists or not
     $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password' ";
     
     //3. execute the query
     $res= mysqli_query($conn, $sql);
     
     //4. count the rows to check whter the user exists or not
     $count= mysqli_num_rows($res);

     if($count==1){
        //user available and redirect to home page
        $_SESSION['login']= "<div class='text-center'> Login Successful </div>";
        $_SESSION['user']= $username;  //to check whter the user is logged in or not and logout will unset it

        header('location:'.SITEURL.'admin/');
       }

     else{
        //user doesn't available and redirect to same page with message
        $_SESSION['login']= "<div class='text-center'> Username or Password didn't match </div>";
        header('location:'.SITEURL.'admin/login.php');
       }

   }
 ?>
