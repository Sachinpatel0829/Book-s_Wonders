<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <p> new <a href="login.php">login</a> | <a href="register.php">register</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Book's Wonders</a>

         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="shop.php">shop</a>
            <a href="contact.php">contact</a>
            <a href="orders.php">orders</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p>username : <span><?php 
           if (isset($_SESSION['user_id'])) {
            // User is logged in
            $user_id = $_SESSION['user_id'];
            echo "Welcome, user with ID: $user_id";
            // Add more logged-in user functionality here
        } else {
            // User is not logged in
            echo "You are not logged in. Please <a href='login.php'>login</a>";
        }
        ?>
            <p>email : 
             <?php if (isset($_SESSION['user_email'])) {
            // User is logged in
            $user_email = $_SESSION['user_email'];
            echo "Welcome, user with ID: $user_email";
            // Add more logged-in user functionality here
        } else {
            // User is not logged in
            echo "You are not logged in. Please <a href='login.php'>login</a>";
        }
        ?>
       <?php if ($user_id): ?>
    <a href="logout.php" class="delete-btn">Logout</a>
<?php else: ?>
    <p>Please login</p>
<?php endif; ?>

         
         </div>
      </div>
   </div>

</header>