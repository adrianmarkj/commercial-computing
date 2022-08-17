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
if (isset($_SESSION['type'])) {
  $userType = $_SESSION['type'];
}
$query = "SELECT id, hotelName, email, fdContactNo, rContactNo, standard, deluxe, suite, standardPrice, deluxePrice, suitePrice, adultPrice, childPrice, profileCreated, profileVerified, safety1, safety2, safety3, safety4, description, hour FROM Hotels WHERE hotelName='$hotelName'";
$result = mysqli_query($conn, $query);
if (!$result) {
  echo "Database error: " . mysqli_error($conn);
  die();
}
$data = mysqli_fetch_assoc($result);
if ($data['hour']!=null) {
    echo '<script>document.getElementById("hours").value = ' . $data['hour'] . '</script>';
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial=scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles-login.css">
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
    <form action="connect.php" method="post">
      <div class="form-content">
        <div class="login-form">
          <div class="title">
            <h1>Chat Hours</h1>
            <h4>Will be set for 4 hours from start time</h4>
          </div>
          <div class="input-boxes">
            <div class="input-box">
              <!-- <div class="pass"><a href="forgotPassword.php">Forgot password?</a></div> -->
              <br>
              <div class="input box">
                <label for="hours">Choose a Start Time:</label>
                <select name="hours" id="hours" required>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                </select>
                <input type="submit" value="Set Hours" name="setHours">
              <br>

            </div>
          </div>

    </form>

  </div>
  </div>
  <script src="script.js"></script>
</body>

</html>