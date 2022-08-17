<?php
include("connect.php");
if (isset($_SESSION['type'])) {
    $userType = $_SESSION['type'];
  }
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
  }
if (isset($_GET['bookingSuccess'])) {
    $bookingSuccess = $_GET['bookingSuccess'];
    if ($bookingSuccess==1) {
        $hotelName = $_SESSION['hotelName'];
        $adultNo = $_SESSION['adultNo'];
        $childNo = $_SESSION['childNo'];
        $roomNo = $_SESSION['roomNo'];
        $inDate = $_SESSION['inDate'];
        $outDate = $_SESSION['outDate'];
        $roomType = $_SESSION['roomType'];
        $query = "INSERT INTO Bookings email, hotelName, adultNo, childNo, roomNo, inDate, outDate, roomType VALUES '$email', '$hotelName', '$adultNo', '$childNo', '$roomNo', '$inDate', '$outDate', '$roomType'";
        $result = mysqli_query($conn, $query);
}
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helaview</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4d254bfadd.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Helaview</title>
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
        <div class="container">
            <h1>Your Home Away from Home</h1>
        </div>

    </div>
    <div class="container">
        <br>
        <br>
        <div align="left">
            <br>
            <br>
            <h2 class="sub-title">Fancy a flight?</h2>
        </div>
        <div class="stories">
            <br>
            <div  id="kayakSearchWidgetContainer">
            </div>
            <div id="search-banner">
                <a href="search.php">
                <img src="images/banner-sell.png">
                <p>Take a Peak<br> Into Where You Could Be<p>
                </a>
            </div>
        </div>
            
            <script type="text/javaScript" src="https://www.kayak.com/affiliate/widget-v2.js"></script>
            <script type="text/javaScript">
                KAYAK.embed({
                container: document.getElementById("kayakSearchWidgetContainer"),
                hostname: "www.kayak.com",
                autoPosition: true,
                defaultProduct: "flights",
                enabledProducts: ["flights"],
                destination: "Colombo, MA",
                ssl: true,
                affiliateId: "acme_corp",
                isInternalLoad: false,
                lc: "en",
                cc: "us",
                mc: "EUR"
                });
                </script>
            <!-- <div class="stories" style="width:100%; float:right;">
                <img src="images/article-3.png">
            </div> -->
        <!-- <h2 id="trending" class="sub-title">Trending places</h2>
        <div class="trending">
            <div>
                <img src="images/dubai.png">
                <h3>Dubai</h3>
            </div>
            <div>
                <img src="images/new-york.png">
                <h3>New York</h3>
            </div>
            <div>
                <img src="images/paris.png">
                <h3>Paris</h3>
            </div>
            <div>
                <img src="images/new-delhi.png">
                <h3>New Delhi</h3>
            </div>
        </div> -->

        <div class="cta">
            <h3>A Home<br> for Every Hotel</h3>
            <p>Get the global exposure you need<br> by sharing your spaces here</p>
            <a href="registerHotel.php" class="cta-btn">Register Now</a>
        </div>

        <h2 class="sub-title">Some Incentive</h2>
        <div class="stories">
            <div>
                <a href="https://theculturetrip.com/asia/sri-lanka/articles/11-reasons-why-you-should-visit-sri-lanka/">
                    <img src="images/article-1.png">
                </a>
                <p>Why you should visit Sri Lankan</p>
            </div>
            <div>
                <a href="https://traveltriangle.com/blog/things-to-do-in-sri-lanka/">
                    <img src="images/article-2.png">
                </a>
                <p>44 things to do in Sri Lanka</p>
            </div>
            <div>
                <a href="https://www.srilanka-botschaft.de/sri-lanka/culture-and-history">
                    <img src="images/article-3.png">
                </a>
                <p>Culture and history in the teardrop of the Indian Ocean</p>
            </div>
        </div>

        <!-- <a href="registerHotel.php" class="start-btn">Start making money</a> -->

        <div class="about-msg">
            <h2>About Helaview</h2>
            <br>
            <p>We are a one-stop-shop for all your tourist accommodation needs in Sri Lanka!
                Planning your journey from start to finish happens right here.
            </p>
        </div>

        <div class="footer">
            <a href="https://facebook.com/"><i class="fa-brands fa-facebook-square"></i></a>
            <a href="https://youtube.com/"><i class="fa-brands fa-youtube"></i></a>
            <a href="https://twitter.com/"><i class="fa-brands fa-twitter-square"></i></a>
            <a href="https://linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
            <a href="https://instagram.com/"><i class="fa-brands fa-instagram-square"></i></a>
            <hr>
            <p>Copyright 2022, Helaview</p>

        </div>

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