<?php
session_start();
require_once('SMTP.php');
require_once('PHPMailer.php');
require_once('Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

$mail=new PHPMailer(true); // Passing `true` enables exceptions

try {
    //settings
    // $mail->SMTPDebug=2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host='smtp-mail.outlook.com';
    $mail->SMTPAuth=true; // Enable SMTP authentication
    $mail->Username='cb009131@students.apiit.lk'; // SMTP username
    $mail->Password=''; // SMTP password
    $mail->SMTPSecure='tls';
    $mail->Port=587;

    $mail->AddReplyTo(($_POST['email']), ($_POST['name']));
    $mail->setFrom('cb009131@students.apiit.lk', 'Admin');

    //recipient
    $mail->addAddress('cb009131@students.apiit.lk', 'Admin');     // Add a recipient

    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='Contact Request ' . date('d-m-y h:i:s');
    $mail->Body=$_POST['message'];
    $mail->AltBody=$_POST['message'];

    $mail->send();

    // echo 'Message has been sent';
    $_SESSION['emailSuccess'] = true;
    header("Location:contact.php");
} 
catch(Exception $e) {
    // echo 'Message could not be sent.';
    // echo 'Mailer Error: '.$mail->ErrorInfo;
    $_SESSION['emailSuccess'] = false;
    header("Location:contact.php");
}
?>