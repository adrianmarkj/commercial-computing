<?php
    include("connect.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="contact-styles.css">
    
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family-Material+Icons"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Contact us</title>
    <script>
        function onloaders() {
        <?php
        if (isset($_SESSION['emailSuccess'])) {
            if ($_SESSION['emailSuccess']==true) {
        ?>
                document.getElementById("success").style.display="";
                autovanish();
        <?php
            }
            else{
        ?>
                document.getElementById("fail").style.display = "";
                autovanish();
        <?php
            }
            unset($_SESSION['emailSuccess']);
        }
        ?>
        }
    </script>
</head>
<body onload="onloaders()">

<div class="header">

<nav class="navigation">

 <!-- Logo -->
 <div class="logo">
 <a href="Index.php"><img src="images/logo1.png" class="logo"></a>
 </div>
 
 <!-- Navigation -->
 <ul class="menu-list">
    <li><a href="search.php" class="active-ham">Search</a></li>
    <li><a href="about.php" class="active-ham">About</a></li>
    <li><a href="#" class="active-ham">Contact</a></li>
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


    <div class="wrapper">
        <header>Send us a Message</header>
        <form action="sendmail.php" method="POST">
            <div class="dbl-field">
                <div class="field">
                    <input type="text" name="name" placeholder="Enter your name" required>
                    <i class="fas fa-user"></i>
                </div>
                <div class="field">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
            <div class="message">
                <textarea placeholder="Write your message" name="message" required></textarea>
            </div>
            <div class="button-area">
               <button type="submit" name="sendThis">Send Message</button>
               <!-- <span>Sending your message....</span> -->
               <?php
                //    if (isset($_SESSION['emailSuccess'])) {
                //     if ($_SESSION['emailSuccess']==true) {
                //         echo '<script>document.getElementById("success").style.display = ""</script>';
                //         unset($_SESSION['emailSuccess']);
                //     }
                //     else{
                //         echo '<script>document.getElementById("fail").style.display = ""; autovanish();</script>';
                //         unset($_SESSION['emailSuccess']);
                //     }
                // }
                // if(isset($_SESSION['emailSuccess'])){
                //     if ($_SESSION['emailSuccess']==true) {
                //         echo 'yes yes';
                //     }
                //     else {
                //         echo 'yes no';
                //     }
                // }
                // else {
                //     echo 'no';
                // }
               ?>
               <p style="margin-left: 30px;color:#4BB543;display:none;" class="autovanish" id="success">Message Sent!</p>
               <p style="margin-left: 30px;color:#DB0F13;display:none;" class="autovanish" id="fail">Failed to Send Message</p>
            </div>
        </form>
    </div>
    <script>
        function autovanish(){
            const avDivs = document.getElementsByClassName('autovanish');
            if (avDivs.length){
                setTimeout(() => {
                    avDivs[0].remove();
                }, 3000); //removes the element after 3000ms
            }
            setTimeout(() => {autovanish();}, 500); //re-run every 500ms
        }
    </script>
    <!-- <script src="c-script.js"></script> -->
    <!-- <script src="script.js"></script> -->

</body>
</html>