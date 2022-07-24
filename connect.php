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
            $sql = "INSERT INTO Users (firstName, lastName, email, pwd, type) VALUES ('$firstName', '$lastName', '$email', '$pwd', '$type')";
            if (mysqli_query($conn, $sql)) {
                // echo "New record created successfully";
                $_SESSION['email'] = $email;
                $_SESSION['loggedIn'] = true;
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
                $sql = "INSERT INTO Users (firstName, lastName, email, pwd, type) VALUES ('$firstName', '$lastName', '$email', '$pwd', 'H')";
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
            header("Location:index.php");
            // echo "Login successful";
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

?>