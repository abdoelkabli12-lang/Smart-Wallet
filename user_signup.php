<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";


$sql_con = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST['Incomes']) && isset($_POST['descreption'])){
  $Incomes = trim($_POST['Incomes']);
?>