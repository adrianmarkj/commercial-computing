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
  $query = "SELECT * FROM Hotels WHERE profileVerified=1";
  $result = mysqli_query($conn, $query);
  if (!$result) {
      echo "Database error: " . mysqli_error($conn); 
      die();
  }
  $data = mysqli_fetch_assoc($result);
  $query = "SELECT * FROM Facilities";
  $result = mysqli_query($conn, $query);
  if (!$result) {
      echo "Database error: " . mysqli_error($conn); 
      die();
  }
  $data1 = mysqli_fetch_assoc($result);
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
        <br>
        <br>
    <form action="search.php" method="POST" id="searchSubmit()">
                    <input type="text" name="search" id="searchBar">
                    <input type="submit" value="Search" id="searchButton" name="searchButton"> 
        <div class="list-container">
            <div class="left-col">            
                <br>
                <?php
                $output = '';

                if(isset($_POST['search'])) {
                  echo '<h1>Search Results</h1>';
                  $search = $_POST['search'];
                  $search = preg_replace("#[^0-9a-z]i#","", $search);
                  if(!empty($_POST['filters'])) {
                    $filters = " WHERE ";
                    $num = count($_POST['filters']);
                    $i=1;
                    foreach($_POST['filters'] as $value){
                        if ($i!=$num) {
                            $filters = $filters . $value. "=1 ". " AND ";
                        }
                        else {
                            $filters = $filters . $value. "=1";
                        }
                    }
                    if ($search=="") {
                        $statement = "SELECT * FROM Hotels WHERE profileVerified=1 AND hotelName IN (SELECT hotelName FROM Facilities" . $filters . " )";
                    }
                    else{
                        $statement = "SELECT * FROM Hotels WHERE profileVerified=1 AND hotelName IN (SELECT hotelName FROM Facilities" . $filters . " AND hotelName LIKE '%$search%')";
                    }
                  }
                  else{
                    $statement = "SELECT * FROM Hotels WHERE profileVerified=1 AND hotelName LIKE '%$search%'";
                  }
                  $query = mysqli_query($conn, $statement) or die ("Could not search");
                  $count = mysqli_num_rows($query);
                  if($count == 0){
                    $output = "There were no matching results.";
                  }
                  else{
                    $i =1;
                    while ($row = mysqli_fetch_array($query)) {
                        $hotelName = $row['hotelName'];
                        $standard = $row['standard'];
                        $deluxe = $row['deluxe'];
                        $suite = $row['suite'];
                        $adultPrice = $row['adultPrice'];
                        $childPrice = $row['childPrice'];
                        $description = $row['description'];
                        echo '<div class="house" id="'. $hotelName .'">';
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
                        $i = $i + 1;
                    }
                  }
                }
                else{
                        echo '<h1>Recommendations</h1>';
                        $query = mysqli_query($conn, "SELECT * FROM Hotels WHERE profileVerified=1");
                        $count = mysqli_num_rows($query);
                        if($count == 0){
                            $output = "There were no matching results.";
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
                                echo '<div class="house" id="'. $hotelName . '">';
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
                    // else{
                    //     $query = mysqli_query($conn, "SELECT * FROM Hotels");
                    //     $count = mysqli_num_rows($query);
                    //     if($count == 0){
                    //         $output = "There were matching results.";
                    //     }
                    //     else{
                    //         while ($row = mysqli_fetch_array($query)) {
                    //             $hotelName = $row['hotelName'];
                    //             $standard = $row['standard'];
                    //             $deluxe = $row['deluxe'];
                    //             $suite = $row['suite'];
                    //             $adultPrice = $row['adultPrice'];
                    //             $childPrice = $row['childPrice'];
                    //             $description = $row['description'];
                    //             echo '<div class="house" id="'. $hotelName . '">';
                    //             echo '<div class="house-img">';
                    //             $imageQuery = "SELECT * FROM MainImages WHERE hotelName='$hotelName'";
                    //             $result1= mysqli_query($conn, $imageQuery);
                    //             $rows1= mysqli_fetch_assoc($result1);
                    //             $image = $rows1['mainImages'];
                    //             echo '<a href="hotelView.php?hotelName='. $hotelName .'"><img src=uploads/'. $image .'></a>';
                    //             echo '</div>';
                    //             echo '<div class="house-info">';
                    //             echo '<h3>'. $hotelName .'</h3>';
                    //             if ($standard==1 && $deluxe==1 && $suite==1) {
                    //                 echo '<p>Standard / Deluxe / Suite</p>';
                    //             }
                    //             elseif($standard==1 && $deluxe==0 && $suite==1){
                    //                 echo '<p>Standard / Suite</p>';
                    //             }
                    //             elseif($standard==1 && $deluxe==1 && $suite==0){
                    //                 echo '<p>Standard / Deluxe</p>';
                    //             }
                    //             elseif($standard==0 && $deluxe==1 && $suite==1){
                    //                 echo '<p>Deluxe / Suite</p>';
                    //             }
                    //             elseif($standard==0 && $deluxe==0 && $suite==1){
                    //                 echo '<p>Suite</p>';
                    //             }
                    //             elseif($standard==0 && $deluxe==1 && $suite==0){
                    //                 echo '<p>Deluxe</p>';
                    //             }
                    //             elseif($standard==1 && $deluxe==0 && $suite==0){
                    //                 echo '<p>Standard</p>';
                    //             }
                    //             echo '<p style="font-size: 90%;">'. $description .'</p>';
                    //             echo '<div class="house-price">';
                    //             echo '<p>Adult/Child</p>';
                    //             echo '<h4>$ '. $adultPrice .' / '. $childPrice .'</h4>';
                    //             echo '</div></div></div>';
                    //         }
                        // }
                    // }
                }
                 ?>
            </div>
            <div class="right-col">
                <div class="sidebar">
                    <h2>Select Filters</h2>
                    <h3>View</h3>
                    <div class="filter">
                        <input type="checkbox" id="cityView" value="cityView" name="filters[]"> <p>City View</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE cityView=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="oceanView" value="oceanView" name="filters[]"> <p>Ocean View</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE oceanView=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="lakeView" value="lakeView" name="filters[]"> <p>Lake View</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE lakeView=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="gardenView" value="gardenView" name="filters[]"> <p>Garden View</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE gardenView=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <h3>Amenities</h3>
                    <div class="filter">
                        <input type="checkbox" id="swimmingPool" value="swimmingPool" name="filters[]"> <p>Swimming Pool</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE swimmingPool=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="freeWiFi" value="freeWiFi" name="filters[]"> <p>Free WiFi</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE freeWiFi=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="gym" value="gym" name="filters[]"> <p>Gym</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE gym=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="airportShuttle" value="airportShuttle" name="filters[]"> <p>Airport Shuttle</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE airportShuttle=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="nonSmokingRooms" value="nonSmokingRooms" name="filters[]"> <p>Non-Smoking Rooms</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE nonSmokingRooms=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="roomService" value="roomService" name="filters[]"> <p>Room Service</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE roomService=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="differentlyAbled" value="differentlyAbled" name="filters[]"> <p>Differently-Abled Friendly</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE differentlyAbled=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="teaCoffee" value="teaCoffee" name="filters[]"> <p>Tea/Coffee-Maker</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE teaCoffee=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="bar" value="bar" name="filters[]"> <p>Bar</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE bar=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>
                    <div class="filter">
                        <input type="checkbox" id="freeParking" value="freeParking" name="filters[]"> <p>Free Parking</p> <span>(<?php $query = mysqli_query($conn, "SELECT * FROM Facilities WHERE freeParking=1"); $count = mysqli_num_rows($query); echo $count; ?>)</span>
                    </div>

                    <!-- <div class="sidebar-link">
                        <a href="#" onclick="filterSubmit()">Filter</a>
                    </div> -->

                </div>
            </div>
            </form>
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

        function filterSubmit(){
            document.getElementById("searchSubmit").submit();
        }
    </script>
    <script src="script.js"></script>

</body>

</html>