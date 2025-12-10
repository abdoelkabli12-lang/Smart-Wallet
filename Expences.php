<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracker";

      $sql_con = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST['Expences']) && isset($_POST['descreption_exp']))  {
    $Expences = trim($_POST['Expences']);
    $Desc_exp = trim($_POST['descreption_exp']);
    $Date_exp = $_POST['Date_exp1'];
        
    if ($Expences !== '') {
      if ($sql_con->connect_error) {
        die("Connection failed: " . $sql_con->connect_error);
      }
      if($Date_exp != '') {
      $stmt = $sql_con->prepare("INSERT INTO expences_trakcer(Expences, descr, Date) VALUES(?, ?, ?)");
      $stmt->bind_param("iss", $Expences, $Desc_exp, $Date_exp);
      } else { 
        $stmt = $sql_con->prepare("INSERT INTO expences_trakcer(expences, descr, Date) VALUES(?, ?, CURRENT_DATE())");
              $stmt->bind_param("is", $Expences, $Desc_exp);
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
            $stmt = $sql_con->prepare("UPDATE expences_trakcer SET Expences = ?, descr = ?, Date = ? WHERE id = ?");
            $stmt->bind_param("issi", $EExpences, $EXDesc, $EXDate, $id);

        } else {
            // Update without date change
            $stmt = $sql_con->prepare("UPDATE expences_trakcer SET Expences = ?, descr = ? WHERE id = ?");
            $stmt->bind_param("isi", $EExpences, $EXDesc, $id);
        }
          $stmt->execute();
          $stmt->close();
        }
      }
            
      if (isset($_POST['EDid'])){
        $EDid = $_POST['EDid'];
        $stmt = $sql_con->prepare("DELETE FROM expences_trakcer WHERE id = ?");
        $stmt->bind_param("i", $EDid);
        $stmt->execute();
        $stmt->close();
      }
            
      $sql_con->close();

header("Location: Home.php");
exit;

?>