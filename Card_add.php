<?php 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracker";

$sql_con = new mysqli($servername, $username, $password, $dbname);
if ($sql_con->connect_error) {
  die("Connection failed: " . $sql_con->connect_error);
}


$user_name = $_POST['username'];

//gets you the last id added in sql (aka the PRIMARY KEY of the user)
$user_id = mysqli_insert_id($sql_con);

  $Card_number = $_POST['card-number'];
  $Card_name = $_POST['card-name'];
  $Card_date = $_POST['expire-date'];
  $Card_cvv =  $_POST['cvv'];

  if(isset($_POST['Visa'])) {
    $card_type = $_POST['Visa'];
  }
  if(isset($_POST['MasterCard'])) {
    $card_type = $_POST['MasterCard'];
  }





  $stmt = $sql_con->prepare("INSERT INTO cards(user_id, Card_type, serial_num, CVV, placeholder) VALUES(?, ?, ? ,?, ?)");
  $stmt->bind_param("isiis", $usrr_id, $card_type, )



?>
