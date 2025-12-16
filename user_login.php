<?php
session_start();

$sql_con = new mysqli("localhost", "root", "", "users");

if (!empty($_POST['emailL']) && !empty($_POST['passwordL'])) {

    $emailL = trim($_POST['emailL']);
    $password = $_POST['passwordL'];

    $stmt = $sql_con->prepare(
        "SELECT Password FROM user1 WHERE Email = ?"
    );
    $stmt->bind_param("s", $emailL);
    $stmt->execute();
    $stmt->bind_result($hashedPasswordFromDb);

    if ($stmt->fetch() && password_verify($password, $hashedPasswordFromDb)) {
        $_SESSION['user'] = $emailL;
        $_SESSION['login_success'] = true; // 🔑 flag
        header("Location: index.php");
        exit;
    }

    header("Location: index.php?error=login");
    exit;
}
