<?php 
    session_start();
    if ($_SESSION['loggedIn']==true) {
        header("Location:index.php");
    }
    include("connect.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
            <meta name="viewport" content= "width=device-width, initial=scale=1.0">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="script-tourist.css">
    </head>
    <body>
        <nav id="navBar" class="navbar-white">
            <a href="Index.php">
            <img src="images/logo1.png" class="logo">
            </a>
            <ul class="nav-links">
                <li class="item"><a href="house.php" class="active" >Search</a></li>
                <li class="item"><a href="listing.php"class="active">About Us</a></li>
                <li class="item"><a href="#" class="active">Contact Us</a></li>
            </ul>
            <div class="animation start-home"></div>
            <a href="login.php" class="login-btn">Login</a>
            <i class="fa-solid fa-bars" onclick="togglebtn()"></i>
        </nav>
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