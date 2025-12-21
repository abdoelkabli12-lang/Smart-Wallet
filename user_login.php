<?php

require 'email_send.php';
session_start();

$sql_con = new mysqli("localhost", "root", "", "Smart_Wallet");
if ($sql_con->connect_error) {
    die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if(!isset($_SESSION['user'])){



    if (empty($_POST['emailL']) || empty($_POST['passwordL'])) {
        header("Location: index.php?error=login");
        exit;
    }

    $emailL   = trim($_POST['emailL']);
    $password = $_POST['passwordL'];


$stmt = $sql_con->prepare("SELECT id, Password FROM users WHERE Email = ?");
$stmt->bind_param("s", $emailL);
$stmt->execute();
$stmt->bind_result($user_id, $hashedPasswordFromDb);

if (!$stmt->fetch()) {
    die("User not found");
}

$stmt->close();

if (!password_verify($password, $hashedPasswordFromDb)) {
    die("Wrong password");
}

// ✅ NOW user_id exists
$_SESSION['user'] = $emailL;
$_SESSION['user_id'] = $user_id;




    if (!sendOTP($emailL)) {
        die("Failed to send OTP");
    }
    

    header("Location: otp_verify.php");
    exit;


    if (!isset($_POST['otp']) || !isset($_SESSION['otp'])) {
        header("Location: otp_verify.php?error=otp_missing");
        exit;
    }

    if ((string) $_POST['otp'] !== (string) $_SESSION['otp']) {
        header("Location: otp_verify.php?error=otp_invalid");
        exit;
    }


    unset($_SESSION['otp']);


    $_SESSION['login_success'] = true;
        }

// SEND OTP
    header("Location: test.php?success=login");
    exit;
}
