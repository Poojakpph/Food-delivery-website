<?php 
  //session starts
  session_start();


   //creating constants to store non repeating values
   define('SITEURL' , 'http://localhost/order-git/');
   define('LOCALHOST', 'localhost');    //constants in php are in uppercase letters
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_NAME', 'alph-village');
   $conn= mysqli_connect(LOCALHOST ,DB_USERNAME, DB_PASSWORD) or die(mysqli_error());  //database connection
   $db_select= mysqli_select_db($conn, DB_NAME) or die(mysqli_error());   //selecting database

?>
