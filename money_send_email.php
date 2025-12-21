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

  require __DIR__ . '/vendor/autoload.php';
  use PHPMailer\PHPMailer\PHPMailer;

function sendMONEY($email, $amount, $sender) {


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'abdo.el.kabli12@gmail.com';
        $mail->Password   = 'qdxf pxgb guvi llak';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($sender, 'Smart Wallet');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = " $sender send you sum money";
        $mail->Body    = "<h2>Amount: <strong>$amount</strong></h2>";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}

?>