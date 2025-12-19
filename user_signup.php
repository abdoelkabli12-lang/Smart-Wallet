<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracker";

ini_set('display_errors', 'On');

$sql_con = new mysqli($servername, $username, $password, $dbname);

if ($sql_con->connect_error) {
    die("Connection failed: " . $sql_con->connect_error);
}

if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])
) {
    $userName = trim($_POST['username']);
    $email = trim($_POST['email']);
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 1️⃣ Check if email already exists
    $stmt = $sql_con->prepare("SELECT id FROM user1 WHERE Email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
        $stmt->close();
        header("Location: authontification.php?error=email_exists");
        exit;
    }
    $stmt->close();

    // 2️⃣ Insert new user
    $stmt = $sql_con->prepare(
        "INSERT INTO user1 (UserName, Email, Password) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $userName, $email, $passwordHash);
    $stmt->execute();
    $stmt->close();

    header("Location: login.php?success=signup");
    exit;
}

header("Location: index.php");
exit;
