<?php
include("connect.php");
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}
if (isset($_SESSION['loggedIn'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
    header("Location:index.php");
}
if (isset($_SESSION['hotelName'])) {
    $hotelName = $_SESSION['hotelName'];
}
if (isset($_SESSION['type'])) {
    $userType = $_SESSION['type'];
    if ($userType!='A') {
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
    <meta name="viewport" content="width=device-width, initial=scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4d254bfadd.js" crossorigin="anonymous"></script>
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
                if ($loggedIn == true) {
                    if ($userType == 'T') {
                        echo "<li><a href='dashboard.php' class='active-ham'>Profile</a></li>";
                        echo "<li><a href='logout.php' class='active-ham'>Logout</a></li>";
                    } else {
                        echo "<li><a href='dashboard.php' class='active-ham'>Dashboard</a></li>";
                        echo "<li><a href='logout.php' class='active-ham'>Logout</a></li>";
                    }
                } else {
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
            <h2 class="header">Report</h2>
            <div class="input-boxes">
                <br>
                <?php
                $query = "SELECT COUNT(*) FROM Users WHERE type='T'";
                $result = mysqli_query($conn, $query);
                $count = mysqli_fetch_array($result);
                echo '<h3 class="a-content"><i class="fa-solid fa-users fa-3x"></i> <div class="a">
                The total number of registered tourists is:
                </div>  <div class="value">' . $count[0] . '</div> </h3>';
                $query = "SELECT COUNT(*) FROM Users WHERE type='H'";
                $result = mysqli_query($conn, $query);
                $count = mysqli_fetch_array($result);
                echo '<h3 class="flex-a"><i class="fa-solid fa-hotel fa-3x"></i> <div class="a">
                The total number of registered hotels is:
                </div>  <div class="value-a">' . $count[0] . '</div> </h3><br>';

                $query = "SELECT hotelName FROM Bookings WHERE hotelName IS NOT NULL GROUP BY hotelName ORDER BY COUNT(*) DESC LIMIT 3";
                $result = mysqli_query($conn, $query);
                $counter = 1;
                echo '<h3>The Top 3 Hotels with the Most Bookings are: </h3>';
                while($top = mysqli_fetch_assoc($result)){
                    echo '<div class="rank">' . $counter . '. ' . $top['hotelName'] . '</div>';
                    $counter++;
                }

                $query = "SELECT AVG(cost) AS AveragePrice FROM Bookings";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                echo '<h3 class="center-a"><i class="fa-solid fa-hand-holding-dollar fa-3x"></i> <div class="b">
                Average price a tourist spends on a booking is 
                </div> <div class="value-a1">
                $' . round($row['AveragePrice'], 2) .'</div></h3>';

                $query = "SELECT hotelName FROM Visits ORDER BY COUNT(*) DESC LIMIT 1";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                echo '<h3 class="popular-left">The most popular hotel is: <div class="p1">
                ' . $row[0].'</div> </h3>';

                $query = "SELECT hotelName FROM Bookings ORDER BY COUNT(*) DESC LIMIT 1";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_array($result);
                echo '<h3 class="popular-right">The most booked hotel is: <div class="p2">
                 ' . $row[0].'</div></h3>';
                ?>
                <br>
                <br>
                <br>
            </div>
        </form>
    </div>
    <script src="script.js"></script>
</body>
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript">
var ctx = document.getElementById("chartjs_bar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:<?php echo json_encode($countryName); ?>,
                        datasets: [{
                            backgroundColor: [
                               "#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750",
                                "#2ec551",
                                "#7040fa",
                                "#ff004e"
                            ],
                            data:<?php echo json_encode($visits); ?>,
                        }]
                    },
                    options: {
                           legend: {
                        display: true,
                        position: 'bottom',
 
                        labels: {
                            fontColor: '#71748d',
                            fontFamily: 'Circular Std Book',
                            fontSize: 14,
                        }
                    },
 
 
                }
                });
</script>
</html>