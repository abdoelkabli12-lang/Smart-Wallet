<?php
require 'vendor/autoload.php';
require 'email_send.php';
session_start();

$sql_con = new mysqli("localhost", "root", "", "tracker");
if ($sql_con->connect_error) {
    die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1️⃣ Basic validation
    if (empty($_POST['emailL']) || empty($_POST['passwordL'])) {
        header("Location: index.php?error=login");
        exit;
    }

    $emailL   = trim($_POST['emailL']);
    $password = $_POST['passwordL'];

    // 2️⃣ Fetch password hash
    $stmt = $sql_con->prepare("SELECT Password FROM user1 WHERE Email = ?");
    $stmt->bind_param("s", $emailL);
    $stmt->execute();
    $stmt->bind_result($hashedPasswordFromDb);

    // 3️⃣ Verify password
    if (!$stmt->fetch() || !password_verify($password, $hashedPasswordFromDb)) {
        $stmt->close();
        header("Location: index.php?error=login");
        exit;
    }
    
    $stmt->close();
        $_SESSION['user'] = $emailL;

    if (!sendOTP($emailL)) {
        die("Failed to send OTP");
    }
    
    // Redirect AFTER sending
    header("Location: otp_verify.php");
    exit;

    // 4️⃣ OTP check
    if (!isset($_POST['otp']) || !isset($_SESSION['otp'])) {
        header("Location: otp_verify.php?error=otp_missing");
        exit;
    }

    if ((string) $_POST['otp'] !== (string) $_SESSION['otp']) {
        header("Location: otp_verify.php?error=otp_invalid");
        exit;
    }

    // 5️⃣ SUCCESS → Login complete
    unset($_SESSION['otp']);


    $_SESSION['login_success'] = true;

// SEND OTP

    header("Location: Home.php?success=login");
    exit;
}
