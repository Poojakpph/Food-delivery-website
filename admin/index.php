   <!-- line 2 is to include the removed code from this i.e. we can break code into small files(stored in other files) -->
  <?php include('partials/menu.php'); ?>


      <!-- main content section starts -->
      <div class="main-content">
        <div class="wrapper">
           <h1>DASHBOARD</h1><br><br>

           <?php 
           if(isset($_SESSION['login'])){
               echo $_SESSION['login'];
               unset($_SESSION['login']);
           }
        ?>      
             <br><br>

             <div class="col-4 text-center">
               <h1>5</h1><br>
               categories
             </div>

             <div class="col-4 text-center">
               <h1>5</h1><br>
               categories
             </div>

             <div class="col-4 text-center">
               <h1>5</h1><br>
               categories
             </div>

             <div class="col-4 text-center">
               <h1>5</h1><br>
               categories
             </div>
             
             <div class="clearfix"></div>
         </div>  
      </div>
      <!-- main content section ends -->


<!-- calling footer file -->
<?php include('partials/footer.php'); ?>  
