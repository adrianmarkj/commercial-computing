<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisiting</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4d254bfadd.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<!-- Search page -->
<body>
    <nav id="navBar" class="navbar-white">
        <a href="Index.php">
        <img src="images/logo-purple.png" class="logo">
        </a>
        <ul class="nav-links">
            <li class="item"><a href="#"class="active">Search </a></li>
            <li class="item"><a href="house.php" class="active" >About Us</a></li>
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
    
    <div class="container">

        <div class="list-container">
            <div class="left-col">
                <p>200+ Options</p>
                <h1>Recommended Places In San Francisco</h1>
                <div class="house">
                    <div class="house-img">
                        <img src="images/image-s1.png">
                    </div>
                    <div class="house-info">
                        <p>Private Villa in San Francisco</p>
                        <h3>Deluxe Queen Room With Street View</h3>
                        <p>1 Bedroom / 1 Bathroom / Wifi / Kitchen</p>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-regular fa-star"></i>

                        <div class="house-price">
                            <p>Guest</p>
                            <h4>$ 100 <span>/ day</span></h4>
                        </div>
                    </div>
                </div>
                <div class="house">
                    <div class="house-img">
                        <img src="images/image-s2.png">
                    </div>
                    <div class="house-info">
                        <p>Private Villa in San Francisco</p>
                        <h3>Deluxe Queen Room With Street View</h3>
                        <p>1 Bedroom / 1 Bathroom / Wifi / Kitchen</p>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-regular fa-star"></i>

                        <div class="house-price">
                            <p>Guest</p>
                            <h4>$ 100 <span>/ day</span></h4>
                        </div>
                    </div>
                </div>
                <div class="house">
                    <div class="house-img">
                        <img src="images/image-s3.png">
                    </div>
                    <div class="house-info">
                        <p>Private Villa in San Francisco</p>
                        <h3>Deluxe Queen Room With Street View</h3>
                        <p>1 Bedroom / 1 Bathroom / Wifi / Kitchen</p>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-regular fa-star"></i>

                        <div class="house-price">
                            <p>Guest</p>
                            <h4>$ 100 <span>/ day</span></h4>
                        </div>
                    </div>
                </div>
                <div class="house">
                    <div class="house-img">
                        <img src="images/image-s4.png">
                    </div>
                    <div class="house-info">
                        <p>Private Villa in San Francisco</p>
                        <h3>Deluxe Queen Room With Street View</h3>
                        <p>1 Bedroom / 1 Bathroom / Wifi / Kitchen</p>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-regular fa-star"></i>

                        <div class="house-price">
                            <p>Guest</p>
                            <h4>$ 100 <span>/ day</span></h4>
                        </div>
                    </div>
                </div>
                <div class="house">
                    <div class="house-img">
                        <img src="images/image-s5.png">
                    </div>
                    <div class="house-info">
                        <p>Private Villa in San Francisco</p>
                        <h3>Deluxe Queen Room With Street View</h3>
                        <p>1 Bedroom / 1 Bathroom / Wifi / Kitchen</p>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-regular fa-star"></i>

                        <div class="house-price">
                            <p>Guest</p>
                            <h4>$ 100 <span>/ day</span></h4>
                        </div>
                    </div>
                </div>
                <div class="house">
                    <div class="house-img">
                        <img src="images/image-s6.png">
                    </div>
                    <div class="house-info">
                        <p>Private Villa in San Francisco</p>
                        <h3>Deluxe Queen Room With Street View</h3>
                        <p>1 Bedroom / 1 Bathroom / Wifi / Kitchen</p>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                        <i class="fa-regular fa-star"></i>

                        <div class="house-price">
                            <p>Guest</p>
                            <h4>$ 100 <span>/ day</span></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-col">
                <div class="sidebar">
                    <h2>Select Filters</h2>
                    <h3>Property Type</h3>
                    <div class="filter">
                        <input type="checkbox"> <p>House</p> <span>(0)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox"> <p>Hostel</p> <span>(0)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox"> <p>Flat</p> <span>(0)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox"> <p>Villa</p> <span>(0)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox"> <p>Guest Suite</p> <span>(0)</span>
                    </div>
                    <h3>Amenities</h3>
                    <div class="filter">
                        <input type="checkbox"> <p>Air Conditioning</p> <span>(0)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox"> <p>Wifi</p> <span>(0)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox"> <p>Gym</p> <span>(0)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox"> <p>Pool</p> <span>(0)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox"> <p>Kitchen</p> <span>(0)</span>
                    </div>

                    <div class="sidebar-link">
                        <a href="#">View More</a>
                    </div>

                </div>
            </div>

        </div>

        <div class="pagination">
            <img src="images/arrow.png">
            <span class="current">1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
            <span>&middot; &middot; &middot; &middot;</span>
            <span>20</span>
            <img src="images/arrow.png" class="right-arrow">
        </div>



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