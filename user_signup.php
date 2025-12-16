<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";


$sql_con = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST['username']) && isset($_POST['password'])){
  $userName = trim($_POST['username']);
  $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
  $email = trim($_POST['email']);
}

if ($userName !== '') {
      if ($sql_con->connect_error) {
        die("Connection failed: " . $sql_con->connect_error);
      }


      $stmt = $sql_con->prepare("INSERT INTO user1(UserName, Email, Password) VALUES(?, ?, ?)");
      $stmt->bind_param("sss", $userName, $email, $password);
      $stmt->execute();
      $stmt->close();
    }

    header("Location:index.php");
?>