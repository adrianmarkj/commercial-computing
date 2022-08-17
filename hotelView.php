<?php
include("connect.php");
if (isset($_SESSION['loggedIn'])) {
    $loggedIn=true;
  }
  else {
    $loggedIn = false;
  }
if (isset($_SESSION['type'])) {
    $userType = $_SESSION['type'];
  }
if (isset($_SESSION['hotelName'])) {
    $hotelName = $_SESSION['hotelName'];
}
else{
    $hotelName = $_GET['hotelName'];
}
$query = "SELECT id, hotelName, email, fdContactNo, rContactNo, standard, deluxe, suite, standardPrice, deluxePrice, suitePrice, adultPrice, childPrice, profileCreated, profileVerified, safety1, safety2, safety3, safety4, description, hour FROM Hotels WHERE hotelName='$hotelName'";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "Database error: " . mysqli_error($conn); 
    die();
}
$data = mysqli_fetch_assoc($result);
$query = "SELECT * FROM MainImages WHERE hotelName='$hotelName'";
$result1 = mysqli_query($conn, $query);
if (!$result1) {
    echo "Database error: " . mysqli_error($conn); 
    die();
}
$query = "SELECT * FROM Users WHERE hotelName='$hotelName'";
$result2 = mysqli_query($conn, $query);
if (!$result1) {
    echo "Database error: " . mysqli_error($conn); 
    die();
}
$data2 = mysqli_fetch_assoc($result2);
$query = "SELECT * FROM StandardImages WHERE hotelName='$hotelName'";
$result3 = mysqli_query($conn, $query);
if (!$result3) {
    echo "Database error: " . mysqli_error($conn); 
    die();
}
$query = "SELECT * FROM DeluxeImages WHERE hotelName='$hotelName'";
$result4 = mysqli_query($conn, $query);
if (!$result4) {
    echo "Database error: " . mysqli_error($conn); 
    die();
}
$query = "SELECT * FROM SuiteImages WHERE hotelName='$hotelName'";
$result5 = mysqli_query($conn, $query);
if (!$result5) {
    echo "Database error: " . mysqli_error($conn); 
    die();
}
if (isset($_POST['check-form'])) {
    $_SESSION['hotelName']=$data['hotelName'];
    $_SESSION['adultNo']=$_POST['adultNo'];
    $_SESSION['childNo']=$_POST['childNo'];
    $_SESSION['roomNo']=$_POST['roomNo'];
    $_SESSION['inDate']=$_POST['inDate'];
    $_SESSION['outDate']=$_POST['outDate'];
    $_SESSION['roomType']=$_POST['r-type'];
}

$time = date("H");
$timezone = date("e");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="menu.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4d254bfadd.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
    <script>
        function submitForms(){
            document.getElementById("check-form").submit();
            document.getElementById("escrowForm").submit();
        }
        const diffDays = (date, otherDate) => Math.ceil(Math.abs(date - otherDate) / (1000 * 60 * 60 * 24));
    </script>
</head>
<?php 
if ($time >= $data['hour'] && $time <= ($data['hour']+4)) {
    echo '<script src="//code.tidio.co/1ibtzvb5omyb0tntnewunnvnuypl9joo.js" async></script>';
}
 ?>
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
    <div class="house-details">
        <div class="house-title">
            <h1><?php echo $data['hotelName'] ?></h1>
            <select name="imgSrc" id="imgSrc" onchange="imageChange()">
                <option value="view" id="mainImg">View</option>
                <?php 
                        if ($data['standard']==1) {
                            echo '<option value="standardImg" id="standardImg">Standard</option>';
                        }
                        if ($data['deluxe']==1) {
                            echo '<option value="deluxeImg" id="deluxeImg">Deluxe</option>';
                        }
                        if ($data['suite']==1) {
                            echo '<option value="suiteImg" id="suiteImg">Suite</option>';
                        }
                ?>  
            </select>
            <div class="row">

            </div>
        </div>
        <div class="gallery" id="mainGallery">
            <?php $rows= mysqli_fetch_assoc($result1);
                $image = $rows['mainImages'];
                echo "<div class='gallery-img-1'><img src=uploads/$image></div>";
            ?>
            <?php while($rows= mysqli_fetch_assoc($result1)){
                $image = $rows['mainImages'];
                echo "<div><img src=uploads/$image></div>";
            } ?>
        </div>
        <?php 
        if ($data['standard']==1) {
            ?>
            <div class="gallery" style="display: none;" id="standardGallery">
                <?php $rows= mysqli_fetch_assoc($result3);
                $image = $rows['standardImages'];
                echo "<div class='gallery-img-1'><img src=uploads/$image></div>";
                while($rows= mysqli_fetch_assoc($result3)){
                    $image = $rows['standardImages'];
                    echo "<div><img src=uploads/$image></div>"; 
                }?>
            </div>
        <?php
        }
        ?>
        <?php 
        if ($data['deluxe']==1) {
            ?>
            <div class="gallery" style="display: none;" id="deluxeGallery">
                <?php $rows= mysqli_fetch_assoc($result4);
                $image = $rows['deluxeImages'];
                echo "<div class='gallery-img-1'><img src=uploads/$image></div>";
                while($rows= mysqli_fetch_assoc($result4)){
                    $image = $rows['deluxeImages'];
                    echo "<div><img src=uploads/$image></div>"; 
                }?>
            </div>
        <?php
        }
        ?>
        <?php 
        if ($data['suite']==1) {
            ?>
            <div class="gallery" style="display: none;" id="suiteGallery">
                <?php $rows= mysqli_fetch_assoc($result5);
                $image = $rows['suiteImages'];
                echo "<div class='gallery-img-1'><img src=uploads/$image></div>";
                while($rows= mysqli_fetch_assoc($result5)){
                    $image = $rows['suiteImages'];
                    echo "<div><img src=uploads/$image></div>"; 
                }?>
            </div>
        <?php
        }
        ?>
        <?php
        $standard = $data['standardPrice'];
        $deluxe = $data['deluxePrice'];
        $suite = $data['suitePrice'];
        $adultP = $data['adultPrice'];
        $childP = $data['childPrice'];
        ?>

        <hr class="line">
        <script>
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
            var yyyy = today.getFullYear();
            if(dd<10){
            dd='0'+dd
            } 
            if(mm<10){
            mm='0'+mm
            } 

            today = yyyy+'-'+mm+'-'+dd;
            document.getElementById("inDate").setAttribute("min", today);
        </script>
        <form class="check-form" id="check-form" action="#" method="POST">
            <div style="margin-left:-5%">
                <label>Check-in</label>
                <input type="date" placeholder="Add Date" onchange="calculatePrice()" name="inDate" id="inDate">
            </div>
            <div>
                <label>Check-out</label>
                <input type="date" placeholder="Add Date" onchange="calculatePrice()" name="outDate" id="outDate"> 
            </div>
            <div class="guest-field">
                <label>Adult</label>
                <input type="number" placeholder="0 guests" onchange="calculatePrice()" id="adultNo" name="adultNo" min="0">
            </div>
            <div class="C-field">
                <label>Children</label>
                <input type="number" placeholder="0 guests" onchange="calculatePrice()" id="childNo" name="childNo" min="0">
            </div>
            <div class="guest-field" style="margin-top: -5%;">
                <label>Rooms</label>
                <input type="number" placeholder="1" value="1" onchange="calculatePrice()" id="roomNo" name="roomNo" min="1">
            </div>
            <div class="r-type" style="margin-left: -14%;margin-top:5.5%;">
                <label>Room type</label>
                <select name="r-type" id="r-type" onchange="calculatePrice()">
                <option value="none" id="none">Select</option>
                    <?php 
                        if ($data['standard']==1) {
                            echo '<option value="standard" id="standard">Standard</option>';
                        }
                        if ($data['deluxe']==1) {
                            echo '<option value="deluxe" id="deluxe">Deluxe</option>';
                        }
                        if ($data['suite']==1) {
                            echo '<option value="suite" id="suite">Suite</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="guest-field" style="margin: 5%;margin-left:8%;">
                <label>Total/$</label>
                <p id="priceDisplay">0</p>
            </div>
            <?php 
            if ($_SESSION['type']=='H' || $_SESSION['type']=='A') {
                echo '<script>document.getElementById("escrowBtn").disabled = true</script>';
            }
            else{ ?>
            <script>
                function calculatePrice(){
                var adults = document.getElementById("adultNo").value;
                var children = document.getElementById("childNo").value;
                var type = document.getElementById("r-type").value;
                var rooms = document.getElementById("roomNo").value;
                var checkin = document.getElementById("inDate").value;
                var checkout = document.getElementById("outDate").value;
                var noOfDays = diffDays(new Date(checkout), new Date(checkin));
                var standardP = "<?php echo $standard; ?>";
                var deluxeP = "<?php echo $deluxe; ?>";
                var suiteP = "<?php echo $suite; ?>";
                var adultP = "<?php echo $adultP; ?>";
                var childP = "<?php echo $childP; ?>";
                var total = 0;
                total = adults * adultP;
                total = total + (children * childP);
                switch (type) {
                    case "standard":
                        total = total + (rooms * standardP * noOfDays);
                        break;
                    case "deluxe":
                        total = total + (rooms * deluxeP * noOfDays);
                        break;
                    case "suite":
                        total = total + (rooms * suiteP * noOfDays);
                        break;
                    default:
                        break;
                }
                document.getElementById("priceDisplay").innerText = total;
                document.getElementById("escrowPrice").value = total;
                }
            </script>
            <?php    
            }
            ?>

        </form>

        <form action="https://www.escrow.com/checkout" method="post" id="escrowForm"><input type="hidden" name="type" value="domain_name"><input type="hidden" name="non_initiator_email" value="cb009131@students.apiit.lk"><input type="hidden" name="non_initiator_id" value="2837035"><input type="hidden" name="non_initiator_role" value="seller"><input type="hidden" name="title" value="Booking"><input type="hidden" name="currency" value="USD"><input type="hidden" name="domain" value="http://localhost/helaview/hotelView.php"><input type="hidden" name="price" value="" id="escrowPrice"><input type="hidden" name="concierge" value="false"><input type="hidden" name="with_content" value="false"><input type="hidden" name="inspection_period" value="1"><input type="hidden" name="fee_payer" value="buyer"><input type="hidden" name="return_url" value="http://localhost/helaview/index.php?bookingSuccess=1"><input type="hidden" name="button_types" value="buy_now"><input type="hidden" name="auto_accept" value=""><input type="hidden" name="auto_reject" value=""><input type="hidden" name="item_key" value="undefined">
        <style>
            @import url(https://fonts.googleapis.com/css?family=Open+Sans:600);

            .EscrowButtonSecondary.EscrowButtonSecondary {
                background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG8AAAALCAMAAABGfiMeAAAAjVBMVEUAAAA8ul08ul48ul08ul08ul9CwGE/vGFHv2lT2Hs8ul08ul49ul09u188ul09ul09ul08ul09ul49ul49u149ul48ul4+u18+u2A9uV09ul49ul5Av2FCvWE8uV09ul49ul49u149u18+vGA/wGM8ul48ul48ul48ul49ul49u18/vWE8uV09ul88uV1RkItgAAAALnRSTlMA+/fz1m4RKwwF4cWUV+vbzLGBU0qlnj01rI16HRq6uGdNYDAV5tC/tYdEI5p0k6hGXAAAAi1JREFUOMuFktuSojAURXcCIheROypIt8hV2t7//3lzwjjVXc7Ysx5SVA45K8kO3ld2QFP6eog74BIp7Zdo34T7FoBbj1ZUnpEzBjBQfv6g5UHoksiPCwDhexSkLnAYSghuFOHfUO2FCQjkS7HDhbQ0bWxo0CKcSansG1cpB1tKDVfOgGgt+r6lgVRm94w9tFQ9TF298tlYaWi7QO9h5AI4W/HNbfbGQgxDBzfhDTFbsx32KPkJGM3VLAUs/wyvYIiQayUgvZ99Dsf1D0/tYRDfDuIakYkTOHBGxQoFY2bweYSQ0IHhzBLAkSmuZGSWkc4Lnx8KLjDSrs/Ga3/5xPWO7NHsbQ1w0CF350d8gcbDd4ex3HChxQMqGZsXvpUPyWIkRdF/+fxk1rx+8zlKHTnJjq6yjdVnPfs2rFh4ez/hx6vz5YILoast5t/OZ0jxzYeYicyMMta/ferZVzOM9YZ1we3P+T0cNbT15ztZbNO35QnAwgSoSB6wW0fD6ZFS/4g4Rcr2QqWaO4//8WWd5xa8IODV6bfLmt9WqyMa6hbnialRU3vIaOJbdg1q8xjdDhiso3nCGSoursUEOx5e5aeFAI5FRe576WawVx8ujFxUNCXfARxyMqcxd2szRbOn0lRASA6ak7d62s0WN+Zo6s/8L+tppYK7mfyoNCHnUxQFN+SnK4D0lEm3WSYcCFURAtiZ8RJ0wPkexHNl4i2DZOMBaWxaSDUW03LIn2/1F/O5RSAdFTG2AAAAAElFTkSuQmCC);
                -moz-osx-font-smoothing: grayscale !important;
                -webkit-font-smoothing: antialiased !important;
                background-color: #f0f2f5 !important;
                background-repeat: no-repeat !important;
                background-position: right 13px !important;
                border-radius: 4px !important;
                border: 1px solid rgba(0, 0, 0, .05) !important;
                -webkit-box-shadow: 0 2px 4px 0 hsla(0, 12%, 54%, .1) !important;
                box-shadow: 0 2px 4px 0 hsla(0, 12%, 54%, .1) !important;
                -webkit-box-sizing: border-box !important;
                box-sizing: border-box !important;
                color: #555 !important;
                cursor: pointer !important;
                display: inline-block !important;
                font-family: Open Sans, sans-serif !important;
                font-size: 14px !important;
                font-weight: 600 !important;
                letter-spacing: .4px !important;
                line-height: 1.2 !important;
                min-height: 40px !important;
                padding: 8px 118px 8px 21px !important;
                text-align: left !important;
                text-decoration: none !important;
                text-shadow: none !important;
                text-transform: none !important;
                -webkit-transition: all .1s linear !important;
                transition: all .1s linear !important;
                vertical-align: middle !important
            }

            .EscrowButtonSecondary.EscrowButtonSecondary:focus,
            .EscrowButtonSecondary.EscrowButtonSecondary:hover {
                color: #555 !important;
                font-size: 14px !important;
                font-weight: 600 !important;
                outline: 0 !important;
                text-decoration: none !important;
                -webkit-transform: none !important;
                transform: none !important
            }

            .EscrowButtonSecondary.EscrowButtonSecondary:hover {
                background-color: #f4f5f8 !important;
                border-color: rgba(0, 0, 0, .05) !important
            }

            .EscrowButtonSecondary.EscrowButtonSecondary:focus {
                background-color: #e8e9ec !important
            }
        </style><button class="EscrowButtonSecondary" onclick="submitForms()" type="submit" style="float: right; margin-top:-13%;margin-right:4%;" id="escrowBtn">Book Now</button><img src="https://t.escrow.com/1px.gif?name=bin&price=10&title=Booking&user_id=2837035" style="display: none;">
    </form>

        <hr class="line">
        <p class="home-desc">
            <?php echo $data['description'] ?>
        </p>


        <?php
        if ($data['safety1'] || $data['safety2'] || $data['safety3'] || $data['safety4']) {
            echo '<hr class="line">
        
            <ul class="details-list">
                <li>
                <i style="margin-left:-10px" class="fa-solid fa-shield-virus fa-2x"></i>
                </li>';
        }
        ?>               
            <?php 
            if ($data['safety1']==1) {
                echo '<li>
                Full Vaccination 
                    <span>Fully Vaccinated travellers are exempted from pre-departure & on-arrival COVID-19 PCR/ Rapid Antigen tests.</span>
                </li>';
            }
            if ($data['safety2']==1) {
                echo '<li>
                Qurantine  
                    <span>No restrictive quarantine required</span>
                </li>';
            }
            if ($data['safety3']==1) {
                echo '<li>
                On arrival PCR test
                     <span>Not-Vaccinated & Not-fully vaccinated Travellers are released from On-arrival PCR test & Quarantine period.</span>
                 </li>';
            }
            if ($data['saftey4']==1) {
                echo '<li>
                </i>PCR for Children  
                 <span>No on-arrival PCR test for children and they will be allowed to travel with their parents.</span>
             </li>';
            } 
            ?>
            
        </ul>
        <hr class="line">

        <div class="host">
            <div>
                <h2>Represented by <?php echo $data2["firstName"].' '.$data2["lastName"] ?></h2>
                <!-- <p>
                    <span>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </span>&nbsp; &nbsp; 245 reviews &nbsp; &nbsp; response rate 100% &nbsp; &nbsp;
                  Response time: 60 min</p> -->
            </div>
        </div>
        <a href="#" class="contact-host">
            <?php 
            if ($time = $data['hour']) {
                echo 'Hotel Representative is online';
            }
            else if ($data['hour']!=null){
                echo 'Hotel Representative will be available at '. $data['hour'] . ':00 for chat.';
            }
            else {
                echo 'Hotel Representative is unavailable for chat.';
            }
            ?>
        </a>
    </div>
    <div class="container">
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
    <script src="profile.js"></script>
    <script src="script.js"></script>
</body>

</html>