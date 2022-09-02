<?php
include("connect.php");
if (isset($_SESSION['type'])) {
    $userType = $_SESSION['type'];
  }
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
  }

if (isset($_SESSION['loggedIn'])) {
    $loggedIn=true;
}
else {
    $loggedIn=false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="about-styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4d254bfadd.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>About us</title>
</head>
<body>
<div class="header" id="main">

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
    <section class="about">
        <div class="content">
            <img src="images/about.jpeg">
            <div class="text">
                <h5>About Us</h5>
                <p>Helaview.LK is a young Sri Lankan startup that was established in Colombo in 2022 with the lofty goal of dominating the global tourism market. Our goal is to make traveling the world simpler for everyone. Helaview.LK connects millions of travelers with unforgettable experiences, flight booking alternatives, and amazing places to stay, including houses, hotels, and more by investing in the technology that reduces travel's friction. We also help businesses expand nationwide by enabling them to connect with a worldwide clientele.
                </p>
                <button type="button">More</button>
            </div>
            
        </div>
    </section>
    <div class="footer">
            <a href="https://facebook.com/"><i class="fa-brands fa-facebook-square"></i></a>
            <a href="https://youtube.com/"><i class="fa-brands fa-youtube"></i></a>
            <a href="https://twitter.com/"><i class="fa-brands fa-twitter-square"></i></a>
            <a href="https://linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
            <a href="https://instagram.com/"><i class="fa-brands fa-instagram-square"></i></a>
            <hr>
            <p>Copyright 2022, Helaview</p>

        </div>
    <script>
        var navBar = document.getElementById("navBar");

        function togglebtn() {
            navBar.classList.toggle("hidemenu");
        }

    </script>
    <script src="script.js"></script>
</body>
</html>