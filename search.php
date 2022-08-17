<?php
include("connect.php");
if (isset($_SESSION['loggedIn'])) {
    $loggedIn=true;
  }
  else {
    $loggedIn = false;
  }
if (isset($_SESSION['hotelName'])) {
    $hotelName = $_SESSION['hotelName'];
  }
  if (isset($_SESSION['type'])) {
    $userType = $_SESSION['type'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4d254bfadd.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>
<!-- Search page -->
<body>
<div class="header">

<nav class="navigation">

 <!-- Logo -->
 <div class="logo">
 <a href="Index.php"><img src="images/logo1.png" class="logo"></a>
 </div>
 
 <!-- Navigation -->
 <ul class="menu-list">
           <li><a href="#" class="active-ham">Search</a></li>
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

        <div class="list-container">
            <div class="left-col">
                <form action="search.php" method="POST">
                    <input type="text" name="search" id="searchBar">
                    <input type="submit" value="Search" id="searchButton" name="searchButton">             
                </form>
                <br>
                <?php
                $output = '';

                if(isset($_POST['search'])) {
                  echo '<h1>Search Results</h1>';
                  $search = $_POST['search'];
                  $search = preg_replace("#[^0-9a-z]i#","", $search);
              
                  $query = mysqli_query($conn, "SELECT * FROM Hotels WHERE hotelName LIKE '%$search%'") or die ("Could not search");
                  $count = mysqli_num_rows($query);
                  if($count == 0){
                    $output = "There were matching results.";
                  }
                  else{
                    while ($row = mysqli_fetch_array($query)) {
                        $hotelName = $row['hotelName'];
                        $standard = $row['standard'];
                        $deluxe = $row['deluxe'];
                        $suite = $row['suite'];
                        $adultPrice = $row['adultPrice'];
                        $childPrice = $row['childPrice'];
                        $description = $row['description'];
                        echo '<div class="house">';
                        echo '<div class="house-img">';
                        $imageQuery = "SELECT * FROM MainImages WHERE hotelName='$hotelName'";
                        $result1= mysqli_query($conn, $imageQuery);
                        $rows1= mysqli_fetch_assoc($result1);
                        $image = $rows1['mainImages'];
                        echo '<a href="hotelView.php?hotelName='. $hotelName .'"><img src=uploads/'. $image .'></a>';
                        echo '</div>';
                        echo '<div class="house-info">';
                        echo '<h3>'. $hotelName .'</h3>';
                        if ($standard==1 && $deluxe==1 && $suite==1) {
                            echo '<p>Standard / Deluxe / Suite</p>';
                        }
                        elseif($standard==1 && $deluxe==0 && $suite==1){
                            echo '<p>Standard / Suite</p>';
                        }
                        elseif($standard==1 && $deluxe==1 && $suite==0){
                            echo '<p>Standard / Deluxe</p>';
                        }
                        elseif($standard==0 && $deluxe==1 && $suite==1){
                            echo '<p>Deluxe / Suite</p>';
                        }
                        elseif($standard==0 && $deluxe==0 && $suite==1){
                            echo '<p>Suite</p>';
                        }
                        elseif($standard==0 && $deluxe==1 && $suite==0){
                            echo '<p>Deluxe</p>';
                        }
                        elseif($standard==1 && $deluxe==0 && $suite==0){
                            echo '<p>Standard</p>';
                        }
                        echo '<p style="font-size: 90%;">'. $description .'</p>';
                        echo '<div class="house-price">';
                        echo '<p>Adult/Child</p>';
                        echo '<h4>$ '. $adultPrice .' / '. $childPrice .'</h4>';
                        echo '</div></div></div>';
                    }
                  }
                }
                else{
                    echo '<h1>Recommendations</h1>';
                    $query = mysqli_query($conn, "SELECT * FROM Hotels");
                    $count = mysqli_num_rows($query);
                    if($count == 0){
                        $output = "There were matching results.";
                    }
                    else{
                        while ($row = mysqli_fetch_array($query)) {
                            $hotelName = $row['hotelName'];
                            $standard = $row['standard'];
                            $deluxe = $row['deluxe'];
                            $suite = $row['suite'];
                            $adultPrice = $row['adultPrice'];
                            $childPrice = $row['childPrice'];
                            $description = $row['description'];
                            echo '<div class="house">';
                            echo '<div class="house-img">';
                            $imageQuery = "SELECT * FROM MainImages WHERE hotelName='$hotelName'";
                            $result1= mysqli_query($conn, $imageQuery);
                            $rows1= mysqli_fetch_assoc($result1);
                            $image = $rows1['mainImages'];
                            echo '<a href="hotelView.php?hotelName='. $hotelName .'"><img src=uploads/'. $image .'></a>';
                            echo '</div>';
                            echo '<div class="house-info">';
                            echo '<h3>'. $hotelName .'</h3>';
                            if ($standard==1 && $deluxe==1 && $suite==1) {
                                echo '<p>Standard / Deluxe / Suite</p>';
                            }
                            elseif($standard==1 && $deluxe==0 && $suite==1){
                                echo '<p>Standard / Suite</p>';
                            }
                            elseif($standard==1 && $deluxe==1 && $suite==0){
                                echo '<p>Standard / Deluxe</p>';
                            }
                            elseif($standard==0 && $deluxe==1 && $suite==1){
                                echo '<p>Deluxe / Suite</p>';
                            }
                            elseif($standard==0 && $deluxe==0 && $suite==1){
                                echo '<p>Suite</p>';
                            }
                            elseif($standard==0 && $deluxe==1 && $suite==0){
                                echo '<p>Deluxe</p>';
                            }
                            elseif($standard==1 && $deluxe==0 && $suite==0){
                                echo '<p>Standard</p>';
                            }
                            echo '<p style="font-size: 90%;">'. $description .'</p>';
                            echo '<div class="house-price">';
                            echo '<p>Adult/Child</p>';
                            echo '<h4>$ '. $adultPrice .' / '. $childPrice .'</h4>';
                            echo '</div></div></div>';
                        }
                    }
                }
                 ?>
                <!-- <p>200+ Options</p> -->
                <!-- <br>
                <h1>Recommended Places In San Francisco</h1> -->
                <!-- <div class="house">
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
                </div> -->
                <!-- <div class="house">
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
                </div> -->
            </div>
        </div>

        <!-- <div class="pagination">
            <img src="images/arrow.png">
            <span class="current">1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
            <span>&middot; &middot; &middot; &middot;</span>
            <span>20</span>
            <img src="images/arrow.png" class="right-arrow">
        </div> -->



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

        function togglebtn(){
            navBar.classList.toggle("hidemenu");
        }
    </script>
    <script src="script.js"></script>

</body>

</html>