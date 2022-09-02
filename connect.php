<?php
session_start();

$servername = "localhost";
$database = "Helaview";
$username = "root";
$password = null;
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully";

if (isset($_POST['regTourist'])){
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
    $pwd1 = $_POST['cpwd'];
    $cpwd = $_POST['cpwd'];

    $user_check_query = "SELECT * FROM Users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $_SESSION['email_err'] = "There is already an account with this email.";
        header("Location:registerTourist.php");
    }
    else{
        if ($pwd1 == $cpwd) {
            if(substr($email,-13)=="@helaview.com"){
                $type = "A";
            }
            else{
                $type = "T";
            }
            $sql = "INSERT INTO Users (firstName, lastName, email, pwd, type, country) VALUES ('$firstName', '$lastName', '$email', '$pwd', '$type', '$country)";
            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
                $_SESSION['email'] = $email;
                $_SESSION['loggedIn'] = true;
                $_SESSION['type'] = $type;
                header("Location:index.php");
            } else {
                // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                $_SESSION['register_err'] = "An error occured while registering.";
                header("Location:index.php");
            }   
        }
        else{
            $_SESSION['password_err'] = "The passwords do not match.";
            header("Location:registerTourist.php");
        }
        mysqli_close($conn);
    }
}
if (isset($_POST['regHotel'])){
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $hotelName = mysqli_real_escape_string($conn, $_POST['hotelName']);
    $fdContactNo = mysqli_real_escape_string($conn, $_POST['fdContactNo']);
    $rContactNo = mysqli_real_escape_string($conn, $_POST['rContactNo']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
    $pwd1 = $_POST['cpwd'];
    $cpwd = $_POST['cpwd'];
    $tableOne = false;
    $tableTwo = false;

    $user_check_query = "SELECT * FROM Users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $_SESSION['email_err'] = "There is already an account with this email.";
        header("Location:login.php");
    }
    else{
        if ($fdContactNo != $rContactNo) {
            if ($pwd1 == $cpwd) {
                $sql = "INSERT INTO Users (firstName, lastName, email, pwd, type, hotelName) VALUES ('$firstName', '$lastName', '$email', '$pwd', 'H', '$hotelName')";
                if (mysqli_query($conn, $sql)) {
                    // echo "New record created successfully";
                    $tableOne = true;
                }
                // else {
                //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                // }
                $sql = "INSERT INTO Hotels (hotelName, email, fdContactNo, rContactNo) VALUES ('$hotelName', '$email', '$fdContactNo', '$rContactNo')";
                if (mysqli_query($conn, $sql)) {
                    // echo "New record created successfully";
                    $tableTwo = true;
                }
                // else {
                //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                // }
                if ($tableOne == true && $tableTwo == true){
                    $_SESSION['email'] = $email;
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['type'] = 'H';
                    $_SESSION['hotelName'] = $hotelName;
                    header("Location:index.php");
                }
                else{
                    $_SESSION['register_err'] = "An error occured while registering.";
                    header("Location:index.php");
                }
            }
            else{
                $_SESSION['password_err'] = "The passwords do not match.";
                header("Location:registerTourist.php");
            }
        }
        else{
            $_SESSION['contact_err'] = "Please enter two different contacts.";
            header("Location:login.php");
        }
        mysqli_close($conn);
    }
}
if (isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = $_POST['pwd'];

    $user_exist_query = "SELECT * FROM Users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_exist_query);
    $user = mysqli_fetch_assoc($result);

    if ($user){
        $password_check_query = "SELECT pwd FROM Users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $password_check_query);
        $password_result = mysqli_fetch_assoc($result);
        if (password_verify($pwd, $password_result['pwd'])){
            $_SESSION['email'] = $email;
            $_SESSION['loggedIn'] = true;
            if ($user['type']=='H') {
                $_SESSION['hotelName'] = $user['hotelName'];
                $_SESSION['type'] = 'H';
                header("Location:dashboard.php");
            }
            else if ($user['type']=='A') {
                $_SESSION['type'] = 'A';
                header("Location:dashboard.php");
            }
            else if ($user['type']=='T') {
                $_SESSION['type'] = 'T';
                header("Location:index.php");
            }
        }
        else{
            $_SESSION['password_err'] = "Invalid password";
            header("Location:login.php");
        }
    }
    else{
        $_SESSION['email_err'] = "There is no account with this email";
            header("Location:login.php");
    }
}

if (isset($_POST['checkProfile'])){
    $_SESSION['databaseRow'] = "This Hotel";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $uploadsDir = "uploads/";
    $allowedFileType = array('jpg','png','jpeg', 'webp');
    // $hotelName = mysqli_real_escape_string($conn, $_POST['hotelName']);
    $hotelName = $_SESSION['hotelName'];
    
    // Validate if files exist
    if (!empty(array_filter($_FILES['mainImage']['name']))) {
        
        // Loop through file items
        foreach($_FILES['mainImage']['name'] as $id=>$val){
            // Get files upload path
            $fileName        = $_FILES['mainImage']['name'][$id];
            $tempLocation    = $_FILES['mainImage']['tmp_name'][$id];
            $targetFilePath  = $uploadsDir . $fileName;
            $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $uploadOk = 1;
            if(in_array($fileType, $allowedFileType)){
                    if(move_uploaded_file($tempLocation, $targetFilePath)){
                        $sqlVal = "('".$fileName."', '".$hotelName."')";
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "File coud not be uploaded."
                        );
                    }
                
            } else {
                $response = array(
                    "status" => "alert-danger",
                    "message" => "Only .jpg, .jpeg and .png file formats allowed."
                );
                echo $response . " 1";
            }
            // Add into MySQL database
            if(!empty($sqlVal)) {
                //new
                $sql = "INSERT INTO MainImages (mainImages, hotelName) VALUES :sqlVal";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":sqlVal", $sqlVal);
                if($stmt->execute()) {
                    $response = array(
                        "status" => "alert-success",
                        "message" => "Files successfully uploaded."
                    );
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Files coudn't be uploaded due to database error."
                    );
                    echo $response . " 2";
                }
                $adultPrice = mysqli_real_escape_string($conn, $_POST['adult']);
                $childPrice = mysqli_real_escape_string($conn, $_POST['child']);
                $sql ="UPDATE Hotels SET adultPrice='$adultPrice', childPrice='$childPrice' WHERE hotelName='$hotelName'";
                mysqli_query($conn, $sql);
                $sql ="UPDATE Hotels SET profileCreated = TRUE WHERE hotelName='$hotelName'";
                mysqli_query($conn, $sql);
            }
        }
    } else {
        // Error
        $response = array(
            "status" => "alert-danger",
            "message" => "Please select a file to upload."
        );
        echo $response . " 3";
    }

    if (isset($_POST['standardCheck'])){
        if (!empty(array_filter($_FILES['standardImage']['name']))) {
        
            // Loop through file items
            foreach($_FILES['standardImage']['name'] as $id=>$val){
                // Get files upload path
                $fileName        = $_FILES['standardImage']['name'][$id];
                $tempLocation    = $_FILES['standardImage']['tmp_name'][$id];
                $targetFilePath  = $uploadsDir . $fileName;
                $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $uploadOk = 1;
                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $targetFilePath)){
                            $sqlVal = "('".$fileName."', '".$hotelName."')";
                        } else {
                            $response = array(
                                "status" => "alert-danger",
                                "message" => "File coud not be uploaded."
                            );
                            echo $response . " 4";
                        }
                    
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Only .jpg, .jpeg and .png file formats allowed."
                    );
                    echo $response . " 5";
                }
                // Add into MySQL database
                if(!empty($sqlVal)) {
                    //new
                    $sql = "INSERT INTO StandardImages (standardImages, hotelName) VALUES $sqlVal";
                    if(mysqli_query($conn, $sql)) {
                        $response = array(
                            "status" => "alert-success",
                            "message" => "Files successfully uploaded."
                        );
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "Files coudn't be uploaded due to database error."
                        );
                        echo $response . " 6";
                    }
                    $standardPrice = mysqli_real_escape_string($conn, $_POST['standardPrice']);
                    $sql ="UPDATE Hotels SET standard = TRUE WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql ="UPDATE Hotels SET standardPrice='$standardPrice' WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                }
            }
        } else {
            // Error
            $response = array(
                "status" => "alert-danger",
                "message" => "Please select a file to upload."
            );
            echo $response . " 7";
        }
    }

    if (isset($_POST['deluxeCheck'])){
        if (!empty(array_filter($_FILES['deluxeImage']['name']))){
            // Loop through file items
            foreach($_FILES['deluxeImage']['name'] as $id=>$val){
                // Get files upload path
                $fileName        = $_FILES['deluxeImage']['name'][$id];
                $tempLocation    = $_FILES['deluxeImage']['tmp_name'][$id];
                $targetFilePath  = $uploadsDir . $fileName;
                $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $uploadOk = 1;
                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $targetFilePath)){
                            $sqlVal = "('".$fileName."', '".$hotelName."')";
                        } else {
                            $response = array(
                                "status" => "alert-danger",
                                "message" => "File coud not be uploaded."
                            );
                            echo $response . " 8";
                        }
                    
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Only .jpg, .jpeg and .png file formats allowed."
                    );
                    echo $response . " 9";
                }
                // Add into MySQL database
                if(!empty($sqlVal)) {
                    //new
                    $sql = "INSERT INTO DeluxeImages (deluxeImages, hotelName) VALUES $sqlVal";
                    if(mysqli_query($conn, $sql)) {
                        $response = array(
                            "status" => "alert-success",
                            "message" => "Files successfully uploaded."
                        );
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "Files coudn't be uploaded due to database error."
                        );
                        echo $response . " 10";
                    }
                    $deluxePrice = mysqli_real_escape_string($conn, $_POST['deluxedPrice']);
                    $sql ="UPDATE Hotels SET deluxe = TRUE WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql ="UPDATE Hotels SET deluxePrice='$deluxePrice' WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                }
            }
        } else {
            // Error
            $response = array(
                "status" => "alert-danger",
                "message" => "Please select a file to upload."
            );
            echo $response . " 11";
        }
    }

    if (isset($_POST['suiteCheck'])){
        if (!empty(array_filter($_FILES['suiteImage']['name']))) {
        
            // Loop through file items
            foreach($_FILES['suiteImage']['name'] as $id=>$val){
                // Get files upload path
                $fileName        = $_FILES['suiteImage']['name'][$id];
                $tempLocation    = $_FILES['suiteImage']['tmp_name'][$id];
                $targetFilePath  = $uploadsDir . $fileName;
                $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $uploadOk = 1;
                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $targetFilePath)){
                            $sqlVal = "('".$fileName."', '".$hotelName."')";
                        } else {
                            $response = array(
                                "status" => "alert-danger",
                                "message" => "File coud not be uploaded."
                            );
                        }
                    
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Only .jpg, .jpeg and .png file formats allowed."
                    );
                    echo $response . " 12";
                }
                // Add into MySQL database
                if(!empty($sqlVal)) {
                    //new
                    $sql = "INSERT INTO SuiteImages (suiteImages, hotelName) VALUES $sqlVal";
                    if(mysqli_query($conn, $sql)) {
                        $response = array(
                            "status" => "alert-success",
                            "message" => "Files successfully uploaded."
                        );
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "Files coudn't be uploaded due to database error."
                        );
                        echo $response . " 13";
                    }
                    $suitePrice = mysqli_real_escape_string($conn, $_POST['suitePrice']);
                    $sql ="UPDATE Hotels SET suite = TRUE WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql ="UPDATE Hotels SET suitePrice='$suitePrice' WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                }
            }
        } else {
            // Error
            $response = array(
                "status" => "alert-danger",
                "message" => "Please select a file to upload."
            );
            echo $response . " 14";
        }
    }

    if (isset($_POST['safety1'])){
        $sql ="UPDATE Hotels SET safety1=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['safety2'])) {
        $sql ="UPDATE Hotels SET safety2=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['safety3'])) {
        $sql ="UPDATE Hotels SET safety3=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['safety4'])) {
        $sql ="UPDATE Hotels SET safety4=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }

    $sql ="UPDATE Hotels SET facilities=1 WHERE hotelName='$hotelName'";
    mysqli_query($conn, $sql);

    $sql ="INSERT INTO Facilities (hotelName) VALUES ('$hotelName')";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
    if (isset($_POST['cityView'])){
        $sql ="UPDATE Facilities SET cityView=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }

    if (isset($_POST['oceanView'])){
        $sql ="UPDATE Facilities SET oceanView=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['lakeView'])){
        $sql ="UPDATE Facilities SET lakeView=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['gardenView'])){
        $sql ="UPDATE Facilities SET gardenView=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['swimmingPool'])){
        $sql ="UPDATE Facilities SET swimmingPool=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['freeWiFi'])){
        $sql ="UPDATE Facilities SET freeWiFi=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['gym'])){
        $sql ="UPDATE Facilities SET gym=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['airportShuttle'])){
        $sql ="UPDATE Facilities SET airportShuttle=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['nonSmokingRooms'])){
        $sql ="UPDATE Facilities SET nonSmokingRooms=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['roomService'])){
        $sql ="UPDATE Facilities SET roomService=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['differentlyAbled'])){
        $sql ="UPDATE Facilities SET differentlyAbled=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['teaCoffee'])){
        $sql ="UPDATE Facilities SET teaCoffee=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['bar'])){
        $sql ="UPDATE Facilities SET bar=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['freeParking'])){
        $sql ="UPDATE Facilities SET freeParking=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }

    $textareaValue = trim($_POST['description']);
    $sql ="UPDATE Hotels SET description='$textareaValue' WHERE hotelName='$hotelName'";
    mysqli_query($conn, $sql);
    $sql ="UPDATE Hotels SET profileCreated=1 WHERE hotelName='$hotelName'";
    mysqli_query($conn, $sql);
    header("Location:hotelView.php");
}

if (isset($_POST['updateProfile'])){
    $_SESSION['databaseRow'] = "This Hotel";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $uploadsDir = "uploads/";
    $allowedFileType = array('jpg','png','jpeg', 'webp');
    // $hotelName = mysqli_real_escape_string($conn, $_POST['hotelName']);
    $hotelName = $_SESSION['hotelName'];
    $updateProfile = $_SESSION['updateProfile'];
    
    // Validate if files exist
    if (!empty(array_filter($_FILES['mainImage']['name']))) {
        
        // Loop through file items
        foreach($_FILES['mainImage']['name'] as $id=>$val){
            // Get files upload path
            $fileName        = $_FILES['mainImage']['name'][$id];
            $tempLocation    = $_FILES['mainImage']['tmp_name'][$id];
            $targetFilePath  = $uploadsDir . $fileName;
            $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $uploadOk = 1;
            if(in_array($fileType, $allowedFileType)){
                    if(move_uploaded_file($tempLocation, $targetFilePath)){
                        $sqlVal = "('".$fileName."', '".$hotelName."')";
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "File coud not be uploaded."
                        );
                    }
                
            } else {
                $response = array(
                    "status" => "alert-danger",
                    "message" => "Only .jpg, .jpeg and .png file formats allowed."
                );
                echo $response . " 1";
            }
            // Add into MySQL database
            if(!empty($sqlVal)) {
                //new
                $sql ="DELETE FROM MainImages WHERE hotelName='$hotelName'";
                mysqli_query($conn, $sql);
                $sql = "INSERT INTO MainImages (mainImages, hotelName) VALUES $sqlVal";
                if(mysqli_query($conn, $sql)) {
                    $response = array(
                        "status" => "alert-success",
                        "message" => "Files successfully uploaded."
                    );
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Files coudn't be uploaded due to database error."
                    );
                    echo $response . " 2";
                }
                $adultPrice = mysqli_real_escape_string($conn, $_POST['adult']);
                $childPrice = mysqli_real_escape_string($conn, $_POST['child']);
                $sql ="UPDATE Hotels SET adultPrice='$adultPrice', childPrice='$childPrice' WHERE hotelName='$hotelName'";
                mysqli_query($conn, $sql);
                $sql ="UPDATE Hotels SET profileCreated = TRUE WHERE hotelName='$hotelName'";
                mysqli_query($conn, $sql);
            }
        }
    } else {
        // Error
        $response = array(
            "status" => "alert-danger",
            "message" => "Please select a file to upload."
        );
        echo $response . " 3";
    }

    if (isset($_POST['standardCheck'])){
        if (!empty(array_filter($_FILES['standardImage']['name']))) {
        
            // Loop through file items
            foreach($_FILES['standardImage']['name'] as $id=>$val){
                // Get files upload path
                $fileName        = $_FILES['standardImage']['name'][$id];
                $tempLocation    = $_FILES['standardImage']['tmp_name'][$id];
                $targetFilePath  = $uploadsDir . $fileName;
                $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $uploadOk = 1;
                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $targetFilePath)){
                            $sqlVal = "('".$fileName."', '".$hotelName."')";
                        } else {
                            $response = array(
                                "status" => "alert-danger",
                                "message" => "File coud not be uploaded."
                            );
                            echo $response . " 4";
                        }
                    
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Only .jpg, .jpeg and .png file formats allowed."
                    );
                    echo $response . " 5";
                }
                // Add into MySQL database
                if(!empty($sqlVal)) {
                    //new
                    $sql ="DELETE FROM StandardImages WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql = "INSERT INTO StandardImages (standardImages, hotelName) VALUES $sqlVal";
                    if(mysqli_query($conn, $sql)) {
                        $response = array(
                            "status" => "alert-success",
                            "message" => "Files successfully uploaded."
                        );
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "Files coudn't be uploaded due to database error."
                        );
                        echo $response . " 6";
                    }
                    $standardPrice = mysqli_real_escape_string($conn, $_POST['standardPrice']);
                    $sql ="UPDATE Hotels SET standard = TRUE WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql ="UPDATE Hotels SET standardPrice='$standardPrice' WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                }
            }
        } else {
            // Error
            $response = array(
                "status" => "alert-danger",
                "message" => "Please select a file to upload."
            );
            echo $response . " 7";
        }
    }

    if (isset($_POST['deluxeCheck'])){
        if (!empty(array_filter($_FILES['deluxeImage']['name']))){
            // Loop through file items
            foreach($_FILES['deluxeImage']['name'] as $id=>$val){
                // Get files upload path
                $fileName        = $_FILES['deluxeImage']['name'][$id];
                $tempLocation    = $_FILES['deluxeImage']['tmp_name'][$id];
                $targetFilePath  = $uploadsDir . $fileName;
                $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $uploadOk = 1;
                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $targetFilePath)){
                            $sqlVal = "('".$fileName."', '".$hotelName."')";
                        } else {
                            $response = array(
                                "status" => "alert-danger",
                                "message" => "File coud not be uploaded."
                            );
                            echo $response . " 8";
                        }
                    
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Only .jpg, .jpeg and .png file formats allowed."
                    );
                    echo $response . " 9";
                }
                // Add into MySQL database
                if(!empty($sqlVal)) {
                    //new
                    $sql ="DELETE FROM DeluxeImages WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql = "INSERT INTO DeluxeImages (deluxeImages, hotelName) VALUES $sqlVal";
                    if(mysqli_query($conn, $sql)) {
                        $response = array(
                            "status" => "alert-success",
                            "message" => "Files successfully uploaded."
                        );
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "Files coudn't be uploaded due to database error."
                        );
                        echo $response . " 10";
                    }
                    $deluxePrice = mysqli_real_escape_string($conn, $_POST['deluxedPrice']);
                    $sql ="UPDATE Hotels SET deluxe = TRUE WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql ="UPDATE Hotels SET deluxePrice='$deluxePrice' WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                }
            }
        } else {
            // Error
            $response = array(
                "status" => "alert-danger",
                "message" => "Please select a file to upload."
            );
            echo $response . " 11";
        }
    }

    if (isset($_POST['suiteCheck'])){
        if (!empty(array_filter($_FILES['suiteImage']['name']))) {
        
            // Loop through file items
            foreach($_FILES['suiteImage']['name'] as $id=>$val){
                // Get files upload path
                $fileName        = $_FILES['suiteImage']['name'][$id];
                $tempLocation    = $_FILES['suiteImage']['tmp_name'][$id];
                $targetFilePath  = $uploadsDir . $fileName;
                $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $uploadOk = 1;
                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $targetFilePath)){
                            $sqlVal = "('".$fileName."', '".$hotelName."')";
                        } else {
                            $response = array(
                                "status" => "alert-danger",
                                "message" => "File coud not be uploaded."
                            );
                        }
                    
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Only .jpg, .jpeg and .png file formats allowed."
                    );
                    echo $response . " 12";
                }
                // Add into MySQL database
                if(!empty($sqlVal)) {
                    //new
                    $sql ="DELETE FROM SuiteImages WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql = "INSERT INTO SuiteImages (suiteImages, hotelName) VALUES $sqlVal";
                    if(mysqli_query($conn, $sql)) {
                        $response = array(
                            "status" => "alert-success",
                            "message" => "Files successfully uploaded."
                        );
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "Files coudn't be uploaded due to database error."
                        );
                        echo $response . " 13";
                    }
                    $suitePrice = mysqli_real_escape_string($conn, $_POST['suitePrice']);
                    $sql ="UPDATE Hotels SET suite = TRUE WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                    $sql ="UPDATE Hotels SET suitePrice='$suitePrice' WHERE hotelName='$hotelName'";
                    mysqli_query($conn, $sql);
                }
            }
        } else {
            // Error
            $response = array(
                "status" => "alert-danger",
                "message" => "Please select a file to upload."
            );
            echo $response . " 14";
        }
    }

    if (isset($_POST['safety1'])){
        $sql ="UPDATE Hotels SET safety1=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Hotels SET safety1=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['safety2'])) {
        $sql ="UPDATE Hotels SET safety2=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Hotels SET safety2=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['safety3'])) {
        $sql ="UPDATE Hotels SET safety3=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Hotels SET safety3=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['safety4'])) {
        $sql ="UPDATE Hotels SET safety4=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Hotels SET safety4=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
        
    if (isset($_POST['cityView'])){
        $sql ="UPDATE Facilities SET cityView=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET cityView=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }

    if (isset($_POST['oceanView'])){
        $sql ="UPDATE Facilities SET oceanView=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET oceanView=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['lakeView'])){
        $sql ="UPDATE Facilities SET lakeView=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET lakeView=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['gardenView'])){
        $sql ="UPDATE Facilities SET gardenView=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET gardenView=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['swimmingPool'])){
        $sql ="UPDATE Facilities SET swimmingPool=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET swimmingPool=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['freeWiFi'])){
        $sql ="UPDATE Facilities SET freeWiFi=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET freeWiFi=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['gym'])){
        $sql ="UPDATE Facilities SET gym=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET gym=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['airportShuttle'])){
        $sql ="UPDATE Facilities SET airportShuttle=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET airportShuttle=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['nonSmokingRooms'])){
        $sql ="UPDATE Facilities SET nonSmokingRooms=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET nonSmokingRooms=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['roomService'])){
        $sql ="UPDATE Facilities SET roomService=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET roomService=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['differentlyAbled'])){
        $sql ="UPDATE Facilities SET differentlyAbled=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET differentlyAbled=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['teaCoffee'])){
        $sql ="UPDATE Facilities SET teaCoffee=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET teaCoffee=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['bar'])){
        $sql ="UPDATE Facilities SET bar=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET bar=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    if (isset($_POST['freeParking'])){
        $sql ="UPDATE Facilities SET freeParking=1 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql ="UPDATE Facilities SET freeParking=0 WHERE hotelName='$hotelName'";
        mysqli_query($conn, $sql);
    }


    $textareaValue = trim($_POST['description']);
    $sql ="UPDATE Hotels SET description='$textareaValue' WHERE hotelName='$hotelName'";
    mysqli_query($conn, $sql);
    $sql ="UPDATE Hotels SET profileCreated=1 WHERE hotelName='$hotelName'";
    mysqli_query($conn, $sql);
    header("Location:hotelView.php");
}

if (isset($_POST['checkForm'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $email = $_POST['email'];
    $sql ="SELECT country FROM Users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $value = mysqli_fetch_assoc($result);
    $country = $value['country'];
    $hotelName = $_POST['hotelName'];
    $adultNo = $_POST['adultNo'];
    $childNo = $_POST['childNo'];
    $roomNo = $_POST['roomNo'];
    $inDate = $_POST['inDate'];
    $outDate = $_POST['outDate'];
    $roomType = $_POST['r-type'];
    $cost = $_POST['price'];
    $query = "INSERT INTO Bookings (email, hotelName, adultNo, childNo, roomNo, inDate, outDate, roomType, cost, country) VALUES ('$email', '$hotelName', '$adultNo', '$childNo', '$roomNo', '$inDate', '$outDate', '$roomType', '$cost', '$country')";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location:index.php");
}

if (isset($_POST['c-profile'])){
    header("Location:hotelProfile.php");
}
if (isset($_POST['u-profile'])){
    $_SESSION['updateProfile']=true;
    header("Location:hotelProfile.php");
}
if (isset($_POST['v-profile'])) {
    header("Location:hotelView.php");
}

if (isset($_POST['verifyHotels'])) {
    header("Location:hotelVerifyList.php");
}

if (isset($_POST['myBookings'])){
    header("Location:hotelBookingList.php");
}

if (isset($_POST['hotelReport'])) {
    header("Location:hotelReport.php");
}

if (isset($_POST['adminReport'])) {
    header("Location:adminReport.php");
}

if (isset($_POST['Comment'])) {
    $comment = mysqli_escape_string($conn, $_POST['theComment']);
    $email = $_SESSION['email'];
    $query = "SELECT firstName, lastName FROM Users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['firstName'];
    $lastName = $row['lastName'];
    $query = "INSERT INTO Comments (text, firstName, lastName) VALUES ('$comment', '$firstName', '$lastName')";
    mysqli_query($conn, $query);
    header("Location:hotelView.php?hotelName=" . $_SESSION['hotelName']);
}

if (isset($_POST['viewThis'])) {
    $hotelName = mysqli_real_escape_string($conn, $_POST['viewThis']);
    $_SESSION['hotelName']=$hotelName;
    header("Location:hotelView.php");
}

if (isset($_POST['verifyThis'])) {
    $hotelName = mysqli_real_escape_string($conn, $_POST['verifyThis']);
    $sql ="UPDATE Hotels SET profileVerified=1 WHERE hotelName='$hotelName'";
    mysqli_query($conn, $sql);
    header("Location:hotelVerifyList.php");
}

if (isset($_POST['blockThis'])) {
    $hotelName = mysqli_real_escape_string($conn, $_POST['blockThis']);
    $sql ="UPDATE Hotels SET profileVerified=0 WHERE hotelName='$hotelName'";
    mysqli_query($conn, $sql);
    header("Location:hotelVerifyList.php");
}

if (isset($_POST['chatHours'])){
    header("Location:hotelChatHour.php");
}

if (isset($_POST['setHours'])){
    $hotelName = $_SESSION['hotelName'];
    $hour = mysqli_real_escape_string($conn, $_POST['hours']);
    $sql ="UPDATE Hotels SET hour='$hour' WHERE hotelName='$hotelName'";
    mysqli_query($conn, $sql);
    header("Location:dashboard.php");
}
?>