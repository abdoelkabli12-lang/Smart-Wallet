<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Smart_wallet";

$sql_con = new mysqli($servername, $username, $password, $dbname);
if ($sql_con->connect_error) {
  die("Connection failed: " . $sql_con->connect_error);
}

$user_id = $_SESSION['user_id'];

$category = trim($_POST['category_name']);
$limit = floatval($_POST['monthly_limit']);

$stmt = $sql_con->prepare("INSERT INTO category_limits (user_id, category_name, monthly_limit) VALUES (?, ?, ?)");
$stmt->bind_param("isd", $user_id, $category, $limit);
$stmt->execute();
$stmt->close();

header("Location: Expences.php");
?>
