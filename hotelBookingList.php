<?php
  include("connect.php");
  if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
  }
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
    if ($userType!='H') {
        header("Location:index.php");
    }
  }
  $query = "SELECT * FROM Bookings WHERE email='$email'";
  $result = mysqli_query($conn, $query);
  if (!$result) {
      echo "Database error: " . mysqli_error($conn); 
      die();
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Verify Hotels</title>
            <meta name="viewport" content= "width=device-width, initial=scale=1.0">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="h-profile.css">
            <link rel="stylesheet" href="menu.css">
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
          <br>
    <br>
    <br>
        <div class="container-hotel">
            <form action="connect.php" method="post">
            <!-- <div class="form-content"> 
                <div class="login-form"> -->
                    <!-- <div class="title"> -->
                        <h2>Hotel List</h2>
                    <!-- </div> -->
                    <div class="input-boxes">
                        <br>
                        <?php
                            echo "<table border='1'>
                            <tr>
                            <th>Hotel</th>
                            <th>No. Of Adults</th>
                            <th>No. of Kids</th>
                            <th>Room Type</th>
                            <th>No. of Rooms</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Check-In</th>
                            <th>Cost</th>
                            </tr>";
                            while ($row = mysqli_fetch_assoc($result)){
                                echo "<tr>";
                                echo "<td>" . $row['hotelName'] . "</td>";
                                echo "<td>" . $row['adultNo'] . "</td>";
                                echo "<td>" . $row['childNo'] . "</td>";
                                echo "<td>" . $row['roomType'] . "</td>";
                                echo "<td>" . $row['roomNo'] . "</td>";
                                echo "<td>" . $row['inDate'] . "</td>";
                                echo "<td>" . $row['outDate'] . "</td>";
                                echo "<td>" . $row['cost'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                         ?>
                    </div>
                <!-- </div>
            </div> -->
            </form>
        </div>
        <script src="script.js"></script>
    </body>
</html>