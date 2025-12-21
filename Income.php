<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Smart_Wallet";

session_start();

$sql_con = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST['Incomes']) && isset($_POST['descreption'])){
  $Incomes = trim($_POST['Incomes']);
  $Desc = trim($_POST['descreption']);
  $Date = $_POST['date'];
  if (!isset($_POST['card_id'])) {
  die("No card selected");
}

$card_id = intval($_POST['card_id']);
        
    if ($Incomes !== '') {


              
      if ($sql_con->connect_error) {
        die("Connection failed: " . $sql_con->connect_error);
      }



            
      if($Date != '') {
        $stmt = $sql_con->prepare("INSERT INTO incomes_tracker(card_id, Incomes, description, Date) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("iiss", $card_id ,$Incomes, $Desc, $Date);
      } else {
            $stmt = $sql_con->prepare("INSERT INTO incomes_tracker (card_id, Incomes, description, Date) VALUES (?, ?, ?, CURRENT_DATE())");
            $stmt->bind_param("iis", $card_id, $Incomes, $Desc);

            

      }

      $stmt->execute();
      $stmt->close();
    }
  }

      if (isset($_POST['edit-Incomes'])){
        $EIncomes = trim($_POST['edit-Incomes']);
        $EDesc = trim($_POST['edit-descreption']);
        $EDate = $_POST['edit-date'];
        $id = intval($_POST['id']);


        if($EIncomes !== '') {
        if (!empty($EDate)) {
            // Update including date
            $stmt = $sql_con->prepare("UPDATE incomes_tracker SET Incomes = ?, description = ?, Date = ? WHERE inc_id = ?");
            $stmt->bind_param("issi", $EIncomes, $EDesc, $EDate, $id);

        } else {
            // Update without date change
            $stmt = $sql_con->prepare("UPDATE incomes_tracker SET Incomes = ?, description = ? WHERE inc_id = ?");
            $stmt->bind_param("isi", $EIncomes, $EDesc, $id);
        }
          $stmt->execute();
          $stmt->close();
        }
      }

      if (isset($_POST['Did'])){
        $Did = $_POST['Did'];
        $stmt = $sql_con->prepare("DELETE FROM incomes_tracker WHERE inc_id = ?");
        $stmt->bind_param("i", $Did);
        $stmt->execute();
        $stmt->close();
      }



    $sql_con->close();
    






header("Location: test.php");
exit;

?>