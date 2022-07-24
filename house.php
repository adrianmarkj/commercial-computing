<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House details page</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4d254bfadd.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <nav id="navBar" class="navbar-white">
        <a href="Index.php">
        <img src="images/logo-purple.png" class="logo">
        </a>
        <ul class="nav-links">
            <li class="item"><a href="listing.php"class="active">Search</a></li>
            <li class="item"><a href="#trending" class="active" >About Us</a></li>    
            <li class="item"><a href="#" class="active">Contact Us</a></li>
        </ul>
        <div class="animation start-home"></div>
        <?php
            if ($_SESSION['loggedIn']==true) {
                echo "<a href='logout.php' class='login-btn'>Logout</a>";
                echo '<i class="fa-solid fa-bars" onclick="togglebtn()"></i>';
            }
            else{
                echo '<a href="login.php" class="login-btn">Login</a>';
                echo '<i class="fa-solid fa-bars" onclick="togglebtn()"></i>';
                echo '<a href="registerTourist.php" class="register-btn">Register Now</a>';
                echo '<i class="fa-solid fa-bars" onclick="togglebtn()"></i>';
            }
        ?>
        
    </nav>
    <div class="house-details">
        <div class="house-title">
            <h1>Wenge House</h1>
            <div class="row">
                <div>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <span>245 Reviews</span>
                </div>
                <div>
                    <p>Location: San Francisco, Califonia, United States</p>
                </div>
            </div>
        </div>

        <div class="gallery">
            <div class="gallery-img-1"><img src="images/house-1.png"></div>
            <div><img src="images/house-2.png"></div>
            <div><img src="images/house-3.png"></div>
            <div><img src="images/house-4.png"></div>
            <div><img src="images/house-5.png"></div>
        </div>
        <div class="small-details">
            <h2>Entire rental unit hosted by Brandon</h2>
            <p>2 guest &nbsp; 2 beds &nbsp; &nbsp; 1 bathroom</p>
            <h4>$ 100 / day</h4>
        </div>
        <hr class="line">
        <form class="check-form">
            <div>
                <label>Check-in</label>
                <input type="text" placeholder="Add Date">
            </div>
            <div>
                <label>Check-out</label>
                <input type="text" placeholder="Add Date">
            </div>
            <div class="guest-field">
                <label>Guest</label>
                <input type="text" placeholder="2 guest">
            </div>
            <button type="submit">Check Availability</button>

        </form>

        <ul class="details-list">
            <li>
                <i class="fa-solid fa-house-chimney"></i>Entier Home 
                <span>You will have the entire flat for you.</span>
            </li>
            <li>
                <i class="fa-solid fa-paintbrush"></i>Enhanced Clean 
                <span>This host has committed to staybnb's cleaning process.</span>
            </li>
            <li>
                <i class="fa-solid fa-location-dot"></i>Great Location
                <span>90% of recent guests gave the location a 5 star rating.</span>
            </li>
            <li>
                <i class="fa-solid fa-heart"></i>Great Check-in Experience  
                <span>100% of recent guest gave the check-in process a 5 star rating.</span>
            </li>
            
        </ul>
        <hr class="line">
        <p class="home-desc">Guests will be allocated on the ground floor according to availability. You get a 
            comfortable Two bedroom apartment has a true city feeling. The price quoted is for 
            two guests, at the guest slot please mark the number of guests to get the exact price
            for groups. The guests will be allocated ground floor according to availability. You
            get the comfortable two bedroom apartment that has a true city feeling.
        </p>
        <hr class="line">
        <div class="map">
            <h3>Location on map</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d100940.17073743168!2d-122.50764016446877!3d37.757679275525774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80859a6d00690021%3A0x4a501367f076adff!2sSan%20Francisco%2C%20CA%2C%20USA!5e0!3m2!1sen!2slk!4v1656400339520!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
       
            <b>San Francisco, Califonia, United States</b>
            <p>It's like a home away from home</p>
        </div>

        <hr class="line">

        <div class="host">
            <img src="images/host.png">
            <div>
                <h2>Hosted by Brandon</h2>
                <p>
                    <span>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </span>&nbsp; &nbsp; 245 reviews &nbsp; &nbsp; response rate 100% &nbsp; &nbsp;
                  Response time: 60 min</p>
            </div>
        </div>
        <a href="#" class="contact-host">Contact host</a>
    </div>
    <div class="container">
        <div class="footer">
            <a href="https://facebook.com/"><i class="fa-brands fa-facebook-square"></i></a>
            <a href="https://youtube.com/"><i class="fa-brands fa-youtube"></i></a>
            <a href="https://twitter.com/"><i class="fa-brands fa-twitter-square"></i></a>
            <a href="https://linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
            <a href="https://instagram.com/"><i class="fa-brands fa-instagram-square"></i></a>
            <hr>
            <p>Copyright 2021, Staybnb</p>
    
        </div>
    </div>

    <script>
        var navBar = document.getElementById("navBar");

        function togglebtn(){
            navBar.classList.toggle("hidemenu");
        }
    </script>
</body>

</html>