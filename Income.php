<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracker";


$sql_con = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST['Incomes']) && isset($_POST['descreption'])){
  $Incomes = trim($_POST['Incomes']);
  $Desc = trim($_POST['descreption']);
  $Date = $_POST['date'];
        
    if ($Incomes !== '') {


              
      if ($sql_con->connect_error) {
        die("Connection failed: " . $sql_con->connect_error);
      }


            
      if($Date != '') {
        $stmt = $sql_con->prepare("INSERT INTO income_tracker(Income, descr, Date) VALUES(?, ?, ?)");
        $stmt->bind_param("iss", $Incomes, $Desc, $Date);
      } else {
            $stmt = $sql_con->prepare("INSERT INTO income_tracker (Income, descr, Date) VALUES (?, ?, CURRENT_DATE())");
            $stmt->bind_param("is", $Incomes, $Desc);

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
            $stmt = $sql_con->prepare("UPDATE income_tracker SET Income = ?, descr = ?, Date = ? WHERE id = ?");
            $stmt->bind_param("issi", $EIncomes, $EDesc, $EDate, $id);

        } else {
            // Update without date change
            $stmt = $sql_con->prepare("UPDATE income_tracker SET Income = ?, descr = ? WHERE id = ?");
            $stmt->bind_param("isi", $EIncomes, $EDesc, $id);
        }
          $stmt->execute();
          $stmt->close();
        }
      }

      if (isset($_POST['Did'])){
        $Did = $_POST['Did'];
        $stmt = $sql_con->prepare("DELETE FROM income_tracker WHERE id = ?");
        $stmt->bind_param("i", $Did);
        $stmt->execute();
        $stmt->close();
      }


    $sql_con->close();
    






header("Location: Home.php");
exit;

?>