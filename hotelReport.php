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
            <h2>Report</h2>
            <div class="input-boxes">
                <br>
                <?php
                $query = "SELECT COUNT(*) FROM Visits WHERE hotelName='$hotelName'";
                $result = mysqli_query($conn, $query);
                $count = mysqli_fetch_array($result);
                echo '<h3>The total number of page visits: ' . $count[0] . '</h3>';

                $query = "SELECT COUNT(*) FROM Bookings WHERE hotelName='$hotelName'";
                $result = mysqli_query($conn, $query);
                $count = mysqli_fetch_array($result);
                echo '<h3>The total number of bookings for the hotel are: ' . $count[0] . '</h3>';
                $query = "SELECT COUNT(*) FROM Bookings WHERE hotelName='$hotelName' AND roomType='standard'";
                $result = mysqli_query($conn, $query);
                $standard = mysqli_fetch_array($result);
                $query = "SELECT COUNT(*) FROM Bookings WHERE hotelName='$hotelName' AND roomType='deluxe'";
                $result = mysqli_query($conn, $query);
                $deluxe = mysqli_fetch_array($result);
                $query = "SELECT COUNT(*) FROM Bookings WHERE hotelName='$hotelName' AND roomType='suite'";
                $result = mysqli_query($conn, $query);
                $suite = mysqli_fetch_array($result);
                if ($standard[0] > $deluxe[0] && $standard[0] > $suite[0]) {
                    echo '<h3>The most popular room is the standard room.</h3>';
                }
                elseif ($deluxe[0] > $standard[0] && $deluxe[0] > $suite[0]) {
                    echo '<h3>The most popular room is the deluxe room.</h3>';
                }
                elseif ($suite[0] > $standard[0] && $suite[0] > $deluxe[0]) {
                    echo '<h3>The most popular room is the suite.</h3>';
                }
                elseif ($standard[0] == $deluxe[0] && $standard[0] > $suite[0]) {
                    echo '<h3>The most popular rooms are the standard and deluxe rooms.';
                }
                elseif ($standard[0] == $suite[0] && $standard[0] > $deluxe[0]) {
                    echo '<h3>The most popular rooms are the standard rooms and the suites.';
                }
                elseif ($suite[0] == $deluxe[0] && $suite[0] > $standard[0]) {
                    echo '<h3>The most popular rooms are the deluxe rooms and the suites.';
                }

                $query = "SELECT AVG(cost) AS AveragePrice FROM Bookings WHERE hotelName='$hotelName'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                echo '<h3>The average price a tourist spends on a booking at your hotel is $' . $row['AveragePrice'];

                $sql ="SELECT DISTINCT country FROM Visits WHERE hotelName='$hotelName'";
                $result = mysqli_query($conn,$sql);
                $chart_data="";
                while ($row = mysqli_fetch_array($result)) { 
                    $countryName[]  = $row['country'];
                    $sql ="SELECT COUNT(*) FROM Visits WHERE country='$row[country]'";
                    $result1 = mysqli_query($conn,$sql);
                    $row1 = mysqli_fetch_array($result1);
                    $visits[] = $row1[0];
                }
                ?>
                <canvas  id="chartjs_bar"></canvas>
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
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)'
                            ],
                            borderWidth: 1,
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
                    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
 
 
                }
                });
</script>
</html>