<?php
include("connect.php");
if (isset($_SESSION['loggedIn'])) {
    $loggedIn=true;
  }
  else {
    $loggedIn = false;
    header("Location:index.php");
  }
  if (isset($_SESSION['hotelName'])) {
    $hotelName = $_SESSION['hotelName'];
  }
  if (isset($_SESSION['updateProfile'])) {
    $updateProfile = $_SESSION['updateProfile'];
  }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hotel Profile</title>
    <meta name="viewport" content="width=device-width, initial=scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="h-profile.css">
    <link rel="stylesheet" href="menu.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body id="h-profile-body" style="padding-bottom: 10vh;">
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
    <div class="container-hotel">
       <form action="connect.php" method="POST" enctype="multipart/form-data" onsubmit="return checkCheckBoxes(this);">
        <h2><?php echo $hotelName ?></h2>
        <!-- <input id="hotelName" name="hotelName" value="" placeholder="Your Hotel Name" required> -->
        <br>
        <br>
        <h2>Main Images:</h2>
        <label for="mainImage1">Image 1 (Thumbnail)</label>
        <input type="file" name="mainImage[]" id="mainImage1" required><br>
        <label for="mainImage2">Image 2</label>
        <input type="file" name="mainImage[]" id="mainImage2" required><br>
        <label for="mainImage3">Image 3</label>
        <input type="file" name="mainImage[]" id="mainImage3" required><br>
        <label for="mainImage4">Image 4</label>
        <input type="file" name="mainImage[]" id="mainImage4" required><br>
        <label for="mainImage5">Image 5</label>
        <input type="file" name="mainImage[]" id="mainImage5" required>
        <br>
        <br>
        <label for="description">Description:</label>
        <br><br>
        <textarea rows="10" cols="100" name="description" required></textarea>
        <br>
        <br>
        <h2>Room Type:</h2>
        <div class="r-type">
        <input type="checkbox" id="standard" name="standardCheck" value="standard" onclick="standardEnable()" class="room">
        <label id="r-label" for="standard"> Standard</label><br>
        <input type="checkbox" id="deluxe" name="deluxeCheck" value="deluxe" onclick="deluxeEnable()" class="room">
        <label id="r-label" for="deluxe"> Deluxe</label><br>
        <input type="checkbox" id="suite" name="suiteCheck" value="suite" onclick="suiteEnable()" class="room">
        <label style="margin-right:80px" id="r-label" for="suite"> Suite</label>
        </div>
        <br><br>
        <h2>Room Images:</h2>
        <h4 style="text-align:left;">Standard</h4>
        <label for="standardImage1" >Image 1 </label>
        <input type="file" name="standardImage[]" id="standardImage1" class="standardImages" disabled required><br>
        <label for="standardImage2" >Image 2</label>
        <input type="file" name="standardImage[]" id="standardImage2" class="standardImages" disabled required><br>
        <label for="standardImage3" >Image 3</label>
        <input type="file" name="standardImage[]" id="standardImage3" class="standardImages" disabled required><br>
        <label for="standardImage4" >Image 4</label>
        <input type="file" name="standardImage[]" id="standardImage4" class="standardImages" disabled required><br>
        <label for="standardImage5" >Image 5</label>
        <input type="file" name="standardImage[]" id="standardImage5" class="standardImages" disabled required><br><br>
        <h4 style="text-align:left;">Deluxe</h4>
        <label for="deluxeImage1" >Image 1 </label>
        <input type="file" name="deluxeImage[]" id="deluxeImage1" class="deluxeImages" disabled required><br>
        <label for="deluxeImage2" >Image 2</label>
        <input type="file" name="deluxeImage[]" id="deluxeImage2" class="deluxeImages" disabled required><br>
        <label for="deluxeImage3" >Image 3</label>
        <input type="file" name="deluxeImage[]" id="deluxeImage3" class="deluxeImages" disabled required><br>
        <label for="deluxeImage4" >Image 4</label>
        <input type="file" name="deluxeImage[]" id="deluxeImage4" class="deluxeImages" disabled required><br>
        <label for="deluxeImage5" >Image 5</label>
        <input type="file" name="deluxeImage[]" id="deluxeImage5" class="deluxeImages" disabled required><br><br>
        <h4 style="text-align:left;">Suite</h4>
        <label for="suiteImage1" >Image 1 </label>
        <input type="file" name="suiteImage[]" id="suiteImage1" class="suiteImages" disabled required><br>
        <label for="suiteImage2" >Image 2</label>
        <input type="file" name="suiteImage[]" id="suiteImage2" class="suiteImages" disabled required><br>
        <label for="suiteImage3" >Image 3</label>
        <input type="file" name="suiteImage[]" id="suiteImage3" class="suiteImages" disabled required><br>
        <label for="suiteImage4" >Image 4</label>
        <input type="file" name="suiteImage[]" id="suiteImage4" class="suiteImages" disabled required><br>
        <label for="suiteImage5" >Image 5</label>
        <input type="file" name="suiteImage[]" id="suiteImage5" class="suiteImages" disabled required>
        <br>
        <br>
        <h2 style="font-weight: bold;">Pricing</h2>
        <h4 style="text-align:left;">Per Room type</h4>
        <div class="pricing">
        <label for="standardPrice"> Standard</label>
        <input type="number" id="standardPrice" name="standardPrice" step=".01" value="" placeholder="100" disabled required>
        <br>
        <label for="deluxePrice"> Deluxe</label>
        <input type="number" id="deluxePrice" name="deluxePrice" step=".01" value="" placeholder="100" disabled required>
        <br>
        <label for="suitePrice"> Suite</label>
        <input type="number" id="suitePrice" name="suitePrice" step=".01" value="" placeholder="100" disabled required>
        <br>
        </div>
        <label for="type1"> Per adult: $</label>
        <input type="number" id="adult" name="adult" value="" step=".01" placeholder="100" required>
        <br>
        <label for="type1"> Per child: $</label>
        <input type="number" id="child" name="child" value="" step=".01" placeholder="100" required>
        <br>
        <br>
        <h2>Covid Safety</h2>
        <input type="checkbox" id="cs" name="safety1" value="regulation1">
        <label for="cs"> Fully Vaccinated travellers are exempted from pre-departure & on-arrival COVID-19 PCR/Rapid Antigen tests.</label><br>
        <input type="checkbox" id="cs" name="safety2" value="regulation2">
        <label for="cs"> No restrictive quarantine required</label><br>
        <input type="checkbox" id="cs" name="safety3" value="regulation3">
        <label for="cs"> Not-Vaccinated & Not-fully vaccinated Travellers are released from On-arrival PCR test & Quarantine period.</label><br>
        <input type="checkbox" id="cs" name="safety4" value="regulation4">
        <label for="cs"> No on-arrival PCR test for children and they will be allowed to travel with their parents.</label>
        <br>
        <br>
        <div class="input box">
            <?php 
                if ($updateProfile!=true) {
                    echo '<input type="submit" value="Submit and Check Profile" name="checkProfile" id="checkProfile">';
                }
                else if ($updateProfile==true) {
                    echo '<input type="submit" value="Update and Check Profile" name="checkProfile" id="checkProfile">';
                }
            ?>
            </div>
        <br>
    <br>
    <br>    
      </form>
     
 </div>
    
    <script src="profile.js"></script>
    <script src="script.js"></script>
</body>

</html>