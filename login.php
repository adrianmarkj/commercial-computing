<?php
  include("connect.php");
  if (isset($_SESSION['loggedIn'])) {
    $loggedIn=true;
    header("Location:index.php");
  }
  else {
    $loggedIn = false;
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
            <meta name="viewport" content= "width=device-width, initial=scale=1.0">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="styles-login.css">
            <link rel="stylesheet" href="menu.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    <div class="header">

<nav class="navigation">

 <!-- Logo -->
 <div class="logo">
 <a href="Index.php">
                <img src="images/logo1.png" class="logo">
            </a>
 </div>
 
 <!-- Navigation -->
 <ul class="menu-list">
           <li><a href="search.php" class="active-ham">Search</a></li>
           <li><a href="#" class="active-ham">About</a></li>
           <li><a href="#" class="active-ham">Contact</a></li>
           <?php
               if ($loggedIn==true) {
                   if ($userType=='T') {
                       echo "<li><a href='#' class='active-ham'>Profile</a></li>";
                       echo "<li><a href='logout.php' class='active-ham'>Logout</a></li>";
                   }
                   else{
                       echo "<li><a href='dashboard.php' class='active-ham'>Dashboard</a></li>";
                       echo "<li><a href='logout.php' class='active-ham'>Logout</a></li>";
                   }
               }
               else{
                   echo '<li><a href="login.php" class="active-ham">Login</a></li>';
                   echo '<li><a href="registerTourist.php" class="active-ham">Register</a></li>';
               }
           ?>
 </ul>

 <div class="humbarger">
   <div class="bar"></div>
   <div class="bar2 bar"></div>
   <div class="bar"></div>
 </div>
</nav>
    </div>
      <div class="container">
      <form action="connect.php" method="post">
      <div class="form-content"> 
            <div class="login-form">
            <div class="title"><h1>Login</h1></div>
                <div class="input-boxes">
                   <div class="input-box">
                    <i class="icon fas fa-envelope"></i>
                    <input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email" required>
                    <span></span>
                      <label for="email">Email</label>
                   </div>
                   <?php
                        if (isset($_SESSION['email_err']))
                        {
                            echo '<p id="thisError">'. $_SESSION['email_err'] . '</p>';
                            unset($_SESSION['email_err']);
                            echo '<script> setTimeout(function (){document.getElementById("thisError").style.display = "none";}, 2000) </script>';
                        }
                      ?>
                   <div class="input-box">
                    <i class="icon fas fa-lock"></i>
                    <input type="password" name="pwd" id="pwd"  pattern="/^[a-zA-Z0-9!@#\$%\^\&*_=+-]{8,12}$/g" 
                       title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                       <span></span>
                      <label for="pwd">Password</label>
                   </div>
                   <?php
                        if (isset($_SESSION['password_err']))
                        {
                            echo '<p id="thisError">'. $_SESSION['password_err'] . '</p>';
                            unset($_SESSION['password_err']);
                            echo '<script> setTimeout(function (){document.getElementById("thisError").style.display = "none";}, 2000) </script>';
                        }
                      ?>
               <!-- <div class="pass"><a href="forgotPassword.php">Forgot password?</a></div> -->
               <br>
                   <div class="input box">
                     <input type="submit" value="Login" name="login">
                   </div>
                   <br>
               <div class="text">Don't have an account? 
                <br>
                <a href="registerTourist.php">Register Now - Tourist</a>
                <br>
                <a href="registerHotel.php">Register Now - Hotel</a></div>
     
               </div>
        </div>
   
      </form>

  </div>
  </div>
  <script src="script.js"></script>           
</body>
</html>