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
        <title>Register</title>
            <meta name="viewport" content= "width=device-width, initial=scale=1.0">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
            <link rel="stylesheet" href="script-tourist.css">
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
           <li><a href="about.php" class="active-ham">About</a></li>
           <li><a href="contact.php" class="active-ham">Contact</a></li>
           <?php
               if ($loggedIn==true) {
                   if ($userType=='T') {
                       echo "<li><a href='dashboard.php' class='active-ham'>Profile</a></li>";
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
                    <div class="registerT-form">
                    <div class="title"><h1>Register - Tourist</h1></div>
               <div class="input-boxes">
               <?php
                        if (isset($_SESSION['register_err']))
                        {
                            echo '<p id="thisError">'. $_SESSION['register_err'] . '</p>';
                            unset($_SESSION['register_err']);
                            echo '<script> setTimeout(function (){document.getElementById("thisError").style.display = "none";}, 2000) </script>';
                        }
                      ?>
                   <div class="input-box">
                    <input type="text" name="firstName" id="firstName" pattern="[a-zA-Z]+" title="Please enter a valid name" required>
                       <label for="firstName">First Name</label>
                   </div>
                    <div class="input-box">
                       <input type="text" name="lastName" id="lastName" pattern="[a-zA-Z]+" title="Please enter a valid name" required>
                       <label for="lastName">Last Name</label>
                      
                   </div>
                   <div class="wrapper">
                    <div class="select-btn">
                    <span id="selector">Select Country</span>
                    <i class="uil uil-angle-down"></i>
                    </div>
                    <div class="content">
                    <div class="search">
                    <i class="uil uil-search"></i>
                    <input spellcheck="false" type="text" placeholder="Search">
                    </div>
                <ul class="options"></ul>
                    </div>
                    </div>
                    <input type="text" id="country" name="country" style="display: none;">
                    <!-- <p id="checkplease"> -->
                    <!-- <script> document.getElementById("country").value = document.getElementById("selector").textContent
                    </script> -->
                    <!-- </p> -->
                   <div class="input-box">
                    <input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email in example@mail.com format" required>
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
                    <input type="password" name="pwd" id="pwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                       <label for="pwd">Password</label>
                       
                   </div>
                   <div class="input-box">
                    <input type="password" name="cpwd" id="cpwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" onkeyup="checkPassword()"  required>
                       <label for="cpwd">Confirm Password</label>
                       
                   </div>
                   <?php
                        if (isset($_SESSION['password_err']))
                        {
                            echo '<p id="thisError">'. $_SESSION['password_err'] . '</p>';
                            unset($_SESSION['password_err']);
                            echo '<script> setTimeout(function (){document.getElementById("thisError").style.display = "none";}, 2000) </script>';
                        }
                      ?>
                   <p id="message"></p>
                    <div class="input box">
                        <input type="submit" value="Register" name="regTourist">
                    </div>
                    <br>
                    <div class="text">Already have an account? <a href="login.php">Login now</a></div>
               </div>
           </div>
   </form>

</div>
</div>
<script src="script.js"></script>                 
</body>
</html>