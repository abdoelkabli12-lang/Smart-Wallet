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

$colors = [
  'indigo-purple',
  'green-teal',
  'orange-red',
  'blue-cyan',
  'pink-purple'
];

// pick random color for new card

$stmt = $sql_con->prepare("SELECT id FROM users WHERE Email = ?");
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

$_SESSION['user_id'] = $user_id;

if (!$user_id) {
  die("User not found");
}

if(isset($_POST['addCard'])){
  
  $card_color = $colors[array_rand($colors)];
  $Card_number = trim($_POST['card-number']);
  $Card_name   = trim($_POST['card-name']);
  $Card_date   = $_POST['expire-date']; // (not stored yet)
  $Card_cvv    = trim($_POST['cvv']);

  $card_type = "Visa";

  $stmt1 = $sql_con->prepare("INSERT INTO cards(user_id, Card_type, serial_num, CVV, placeholder, card_color) VALUES(?, ? ,?, ?, ?, ?)");
  $stmt1->bind_param("isssss", $user_id, $card_type, $Card_number, $Card_cvv, $Card_name, $card_color);  
    $stmt1->execute();
      $stmt1->close();
}

  $sql_con->close();

header("Location: test.php");
exit;
?>
