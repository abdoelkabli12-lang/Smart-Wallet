<?php 

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Smart_wallet";

      $sql_con = new mysqli($servername, $username, $password, $dbname);


$user_id = $_SESSION['user_id'];

      $category = trim($_POST['category']);  // e.g., "Food"
$amount = floatval($_POST['Expences']);

$stmt = $sql_con->prepare("
    SELECT COALESCE(SUM(Expences), 0) 
    FROM expences_tracker 
    WHERE user_id = ?  AND MONTH(Date) = MONTH(CURRENT_DATE()) AND YEAR(Date) = YEAR(CURRENT_DATE())
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($spent_this_month);
$stmt->fetch();
$stmt->close();




$stmt = $sql_con->prepare("SELECT monthly_limit FROM category_limits WHERE user_id = ? AND category_name = ?");
$stmt->bind_param("is", $user_id, $category);
$stmt->execute();
$stmt->bind_result($monthly_limit);
$stmt->fetch();
$stmt->close();


if ($spent_this_month + $amount > $monthly_limit) {
    die("You cannot add this expense: it exceeds your monthly limit for $category");
} else {
    // insert expense normally



if (isset($_POST['Expences']) && isset($_POST['descreption_exp']))  {
    $Expences = trim($_POST['Expences']);
    $Desc_exp = trim($_POST['descreption_exp']);
    $Date_exp = $_POST['Date_exp1'];

      if (!isset($_POST['card_id'])) {
  die("No card selected");
}

$card_id = intval($_POST['card_id']);
        
    if ($Expences !== '') {
      if ($sql_con->connect_error) {
        die("Connection failed: " . $sql_con->connect_error);
      }
      if($Date_exp != '') {
      $stmt = $sql_con->prepare("INSERT INTO expences_tracker(card_id, Expences, description, Date) VALUES(?, ?, ?, ?)");
      $stmt->bind_param("iiss",$card_id, $Expences, $Desc_exp, $Date_exp);
      } else { 
        $stmt = $sql_con->prepare("INSERT INTO expences_tracker(card_id, expences, description, Date) VALUES(?, ?, ?, CURRENT_DATE())");
              $stmt->bind_param("iis", $card_id, $Expences, $Desc_exp);
      }
      $stmt->execute();
      $stmt->close();
    }
}

      if (isset($_POST['edit-Expenses'])){
        $EExpences = trim($_POST['edit-Expenses']);
        $EXDesc = trim($_POST['edit-Edescreption']);
        $EXDate = $_POST['edit-Edate'];
        $id = intval($_POST['id']);
        


        if($EExpences !== '') {
        if (!empty($EXDate)) {
            // Update including date
            $stmt = $sql_con->prepare("UPDATE expences_tracker SET Expences = ?, descr = ?, Date = ? WHERE id = ?");
            $stmt->bind_param("issi", $EExpences, $EXDesc, $EXDate, $id);

        } else {
            // Update without date change
            $stmt = $sql_con->prepare("UPDATE expences_tracker SET Expences = ?, descr = ? WHERE id = ?");
            $stmt->bind_param("isi", $EExpences, $EXDesc, $id);
        }
          $stmt->execute();
          $stmt->close();
        }
      }
            
      if (isset($_POST['EDid'])){
        $EDid = $_POST['EDid'];
        $stmt = $sql_con->prepare("DELETE FROM expences_tracker WHERE id = ?");
        $stmt->bind_param("i", $EDid);
        $stmt->execute();
        $stmt->close();
      }
            
      $sql_con->close();
      // $remaining = $monthly_limit - $spent_this_month;
// echo "Remaining for $category: $remaining";

      }

header("Location: test.php");
exit;

?>