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

?>