

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

$sql_inc = "SELECT * FROM incomes_tracker WHERE MONTH(Date) = MONTH(CURRENT_DATE) AND YEAR(Date) = YEAR(CURRENT_DATE)";
$result_inc = $sql_con->query($sql_inc);




// $sql_sumIncC = "SELECT SUM(Incomes) AS total_incomeC FROM Incomes_tracker WHERE ";
// $sumIncResult = $sql_con->query($sql_sumInc);
// $total_income = ($sumIncResult && $row = $sumIncResult->fetch_assoc()) ? $row['total_income'] : 0;

$sql_exp = "SELECT * FROM expences_tracker WHERE MONTH(Date) = MONTH(CURRENT_DATE) AND YEAR(Date) = YEAR(CURRENT_DATE)";
$result_exp = $sql_con->query($sql_exp);

// $sql_sumExp = "SELECT SUM(Expences) AS total_expenses FROM expences_tracker";
// $sumExpResult = $sql_con->query($sql_sumExp);
// $total_expenses = ($sumExpResult && $row = $sumExpResult->fetch_assoc()) ? $row['total_expenses'] : 0;


// $sql_cards = $sql_con->prepare("SELECT * FROM Cards WHERE user_id = ? ORDER BY serial_num DESC");

$user_id = $_SESSION['user_id']; // temporary fallback




    
$stmt = $sql_con->prepare("SELECT * FROM cards WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_cards = $stmt->get_result();
            
    $selected_card_id = isset($_GET['card_id'])
  ? intval($_GET['card_id'])
  : null;


  $_SESSION['card_id'] = $selected_card_id;
if ($selected_card_id) {
  $stmt = $sql_con->prepare(
    "SELECT COALESCE(SUM(Incomes), 0)
     FROM incomes_tracker
     WHERE card_id = ?"
  );
  $stmt->bind_param("i", $selected_card_id);
  $stmt->execute();
  $stmt->bind_result($total_income);
  $stmt->fetch();
  $stmt->close();
} else {
  $total_income = 0;
}




if ($selected_card_id) {
  $stmt = $sql_con->prepare(
    "SELECT COALESCE(SUM(Expences), 0)
     FROM expences_tracker
     WHERE card_id = ?"
  );
  $stmt->bind_param("i", $selected_card_id);
  $stmt->execute();
  $stmt->bind_result($total_expences);
  $stmt->fetch();
  $stmt->close();
} else {
  $total_expences = 0;
}
$net_profit = $total_income - $total_expences;



    
  $stmt = $sql_con->prepare("UPDATE cards SET balance = ? WHERE Card_id = ?");
  $stmt->bind_param("ii", $net_profit, $selected_card_id);
  $stmt->execute();
  $stmt->close();

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Smart Wallet Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 text-gray-800">

<?php
if (isset($_GET['error']) && $_GET['error'] === 'email_exists') {
    echo "<script>alert('Email already registered');</script>";
    
}

if (isset($_GET['success']) && $_GET['success'] === 'signup') {
    echo "<script>alert('Signup successful! Please login.');</script>";
}
?>

<!-- HEADER -->
<header class="bg-gradient-to-r from-green-600 to-blue-600 p-4 flex justify-between items-center text-white">
  <h1 class="text-2xl font-bold">Smart Wallet</h1>
  <div class="flex items-center gap-4">
    <span><?php echo htmlspecialchars($_SESSION['user'] ?? 'Guest'); ?></span>
    <form action="logout.php" method="post">
      <button class="bg-red-500 px-4 py-1 rounded">Logout</button>
    </form>
  </div>
</header>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'press-start': ['"Press Start 2P"', 'cursive'],
            'K2D': ['"K2D"', 'cursive'],
          },
          colors: {
            myred: '#A63348',
            magenta: '#5F425F',
            myblue: '#3B4A6B',
            cyan: '#1B7C97',
            myblue: '#3B4A6B',
            gred: '#FF0000',
            legendary: '#FFD400',
            rare: '#0C0091',
            uncommon: '#00FF11',
            common: '#FFFFFF',
            tblue: '#1F2937',
            mygrey: '#6B7280',
            gblue: '#374151',
            stroke: '#4B5563',
            underbg: '#E5E7EB',
            grayish: '#374151',
            brownish: '#EEB76B',
            orangish: '#E2703A',
            redmagenta: '#9C3D54',
            dark_brown: '#310B0B',
          }
        }
      }
    }
  </script>

<!-- ACTION BUTTONS -->
<div class="flex justify-center gap-6 mt-6">
  <button id="add-transaction-btn" class="px-6 py-3 bg-green-500 text-white rounded-xl shadow">
    ➕ Add Transaction
  </button>
  <a href="Card.php">
<button
  id="add-card-btn"
  class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
  ➕ Add Card
</button></a>

<button
  id="send-money-btn"
  class="px-6 py-3 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition">
  💸 Send Money
</button>

<button id="add-limit-btn" class="px-6 py-3 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600 transition">
  ➕ Add Category Limit
</button>


</div>

<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto mt-8 px-6">
  <div class="bg-white rounded-xl p-6 shadow">
    <p class="text-gray-500">Total Income</p>
    <h2 class="text-2xl font-bold text-green-600">
  <?php

  echo number_format($total_income, 2); ?>
</h2>
  </div>

  <div class="bg-white rounded-xl p-6 shadow">
    <p class="text-gray-500">Total Expenses</p>
    <h2 class="text-2xl font-bold text-red-600">$<?php echo $total_expences; ?></h2>
  </div>

  <div class="bg-white rounded-xl p-6 shadow">
    <p class="text-gray-500">Net Profit</p>
    <h2 class="text-2xl font-bold text-blue-600">
      $<?php echo $net_profit; ?>
    </h2>
  </div>
</div>

<?php
$cardStyles = [
  'indigo-purple' => 'from-indigo-600 to-purple-600',
  'green-teal'    => 'from-green-500 to-teal-500',
  'orange-red'    => 'from-orange-500 to-red-500',
  'blue-cyan'     => 'from-blue-500 to-cyan-500',
  'pink-purple'   => 'from-pink-500 to-purple-500'
];


?>

<!-- CARDS -->
<div class="max-w-6xl mx-auto mt-10 px-6">
  <h2 class="text-xl font-bold mb-4">My Cards</h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">



    
  <?php if ($result_cards && $result_cards->num_rows > 0): ?>
  <?php while ($card = $result_cards->fetch_assoc()): ?>

    <?php
      // Get income sum for this card
      $stmtInc = $sql_con->prepare(
        "SELECT COALESCE(SUM(Incomes), 0) 
         FROM incomes_tracker 
         WHERE card_id = ?"
      );
      $stmtInc->bind_param("i", $card['Card_id']);
      $stmtInc->execute();
      $stmtInc->bind_result($card_income);
      $stmtInc->fetch();
      $stmtInc->close();

      // (Optional) subtract expenses later
      $balance = $card['balance'];
 

      $gradient = $cardStyles[$card['card_color']] ?? 'from-gray-600 to-gray-800';
      
    ?>

<div class="card bg-gradient-to-r <?php echo $gradient; ?> text-white rounded-xl p-6 shadow-lg relative"
     data-card="<?php echo $card['Card_id']; ?>">

  <!-- RADIO BUTTON -->
<input
  type="radio"
  name="selected_card"
  value="<?php echo $card['Card_id']; ?>"
  onchange="selectCard(this.value)"
  class="absolute top-3 right-3 scale-125 cursor-pointer"
  <?php if (isset($_GET['card_id']) && $_GET['card_id'] == $card['Card_id']) echo 'checked'; ?>
>
  <p class="text-sm opacity-80">
    <?php echo htmlspecialchars($card['placeholder']); ?>
  </p>

  <p class="text-xl tracking-widest my-4">
    <?php echo htmlspecialchars($card['serial_num']); ?>
  </p>

  <div class="flex justify-between items-center">
    <span class="text-sm">
      Balance: $<?php echo number_format($balance, 2); ?>
    </span>
    <span class="text-lg font-bold">
      <?php echo htmlspecialchars($card['Card_type']); ?>
    </span>
  </div>
</div>


  <?php endwhile; ?>
<?php endif; ?>



  </div>
</div>


<!-- CHART -->
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">
  <canvas id="myChart"></canvas>
</div>

<!-- TABLES -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl mx-auto mt-10 px-6">

<!-- INCOMES -->
<div class="bg-white rounded-xl shadow p-4 overflow-y-auto max-h-[400px]">
  <h3 class="text-lg font-bold mb-4">Incomes</h3>
  <table class="w-full text-sm">
    <tbody>
    <?php
     if ($result_inc && $result_inc->num_rows > 0): ?>
      <?php while ($row_inc = $result_inc->fetch_assoc()): ?>
      <tr class="element border-b">
        <td class="py-2 text-green-600 font-semibold">$<?php echo $row_inc['Incomes']; ?></td>
        <td class="py-2"><?php echo $row_inc['Date']; ?></td>
        <td class="py-2"><?php echo $row_inc['description']; ?></td>
        <td class="py-2"><button class="edit_btn_inc text-green-500">Edit</button>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td class="py-2 text-center text-gray-400">No income data</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- EXPENSES -->
<div class="bg-white rounded-xl shadow p-4 overflow-y-auto max-h-[400px]">
  <h3 class="text-lg font-bold mb-4">Expenses</h3>
  <table class="w-full text-sm">
    <tbody>
    <?php if ($result_exp && $result_exp->num_rows > 0): ?>
      <?php while ($row_exp = $result_exp->fetch_assoc()): ?>
      <tr class="border-b">
        <td class="py-2 text-red-600 font-semibold">$<?php echo $row_exp['Expences']; ?></td>
        <td class="py-2"><?php echo $row_exp['Date']; ?></td>
        <td class="py-2"><?php echo $row_exp['description']; ?></td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td class="py-2 text-center text-gray-400">No expense data</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</div>

</div>

<!-- TRANSACTION MODAL -->
<div id="transaction-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-xl w-96">
    <h2 class="text-xl font-bold mb-4">Add Transaction</h2>

    <select id="transaction-type" class="w-full border p-2 mb-4 rounded">
      <option value="income">Income</option>
      <option value="expense">Expense</option>
    </select>

    <!-- Income -->
    <form id="income-form" action="Income.php" method="post">
      <input name="Incomes" class="w-full border p-2 mb-2 rounded" placeholder="Amount">
      <input name="descreption" class="w-full border p-2 mb-2 rounded" placeholder="Description">
      <input name="date" type="date" class="w-full border p-2 mb-4 rounded">
      <button class="w-full bg-green-500 text-white py-2 rounded">Save Income</button>
      <input type="hidden" name="card_id" id="income-card-id">
    </form>

        <!-- Limits
    <form action="limits.php" method="post">
    <input type="text" name="category_name" class="w-full border p-2 mb-2 rounded" placeholder="Category Name" required>
    <input type="number" name="monthly_limit" class="w-full border p-2 mb-2 rounded" placeholder="Monthly Limit" required>
    <button type="submit">Save Limit</button>
    </form> -->


    <!-- Expense -->
    <form id="expense-form" action="Expences.php" method="post" class="hidden">
      <input name="Expences" class="w-full border p-2 mb-2 rounded" placeholder="Amount">
      <input name="descreption_exp" class="w-full border p-2 mb-2 rounded" placeholder="Description">
      <input name="Date_exp1" type="date" class="w-full border p-2 mb-4 rounded">
      <select name="category" required>
  <option value="Food">Food</option>
  <option value="Transport">Transport</option>
</select>

      <button class="w-full bg-red-500 text-white py-2 rounded">Save Expence</button>
      <input type="hidden" name="card_id" id="expence-card-id">

    </form>


    <button id="close-transaction" class="w-full mt-4 border py-2 rounded">Cancel</button>
  </div>
</div>

<!-- ADD CARD MODAL -->
<div id="card-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-xl w-96">
    <h2 class="text-xl font-bold mb-4">Add Card</h2>
    <input class="w-full border p-2 mb-2 rounded" placeholder="Card Number">
    <input class="w-full border p-2 mb-2 rounded" placeholder="Card Holder">
    <div class="flex gap-2">
      <input class="w-1/2 border p-2 rounded" placeholder="MM/YY">
      <input class="w-1/2 border p-2 rounded" placeholder="CVV">
    </div>
    <button class="w-full bg-indigo-500 text-white py-2 rounded mt-4">Save Card</button>
    <button id="close-card" class="w-full mt-3 border py-2 rounded">Cancel</button>
  </div>
</div>

<!-- SEND MONEY MODAL -->
<div id="send-money-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-xl w-96">
    <h2 class="text-xl font-bold mb-4 text-center">Send Money</h2>

    <form action="send_money.php" method="post">

      <!-- Choose method -->
      <label class="block mb-1 font-semibold">Send to</label>
      <select id="send-type" name="send_type" class="w-full border p-2 mb-3 rounded" required>
        <option value="email">Email</option>
        <option value="id">User ID</option>
      </select>

      <!-- Email -->
      <input
        id="send-email"
        name="receiver_email"
        type="email"
        class="w-full border p-2 mb-3 rounded"
        placeholder="Receiver Email">

      <!-- User ID -->
      <input
        id="send-id"
        name="receiver_id"
        type="number"
        class="w-full border p-2 mb-3 rounded hidden"
        placeholder="Receiver User ID">

      <!-- Amount -->
      <input
        name="amount"
        type="number"
        step="0.01"
        class="w-full border p-2 mb-3 rounded"
        placeholder="Amount"
        required>

      <!-- Description -->
      <input
        name="description"
        class="w-full border p-2 mb-4 rounded"
        placeholder="Description (optional)">

      <!-- Submit -->
      <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        Send Money
      </button>
    </form>


    <button
      id="close-send-money"
      class="w-full mt-4 border py-2 rounded">
      Cancel
    </button>
  </div>
</div>

<!-- CATEGORY LIMIT MODAL -->
<div id="limit-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-xl w-96">
    <h2 class="text-xl font-bold mb-4">Add Category Limit</h2>

    <form action="limits.php" method="post">
      <input type="text" name="category_name" class="w-full border p-2 mb-2 rounded" placeholder="Category Name" required>
      <input type="number" name="monthly_limit" class="w-full border p-2 mb-2 rounded" placeholder="Monthly Limit" required>
      <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600">
        Save Limit
      </button>
    </form>

    <button id="close-limit" class="w-full mt-4 border py-2 rounded">Cancel</button>
  </div>
</div>



<!-- JS -->
<script>
const tBtn = document.getElementById('add-transaction-btn');
const tModal = document.getElementById('transaction-modal');
const cBtn = document.getElementById('add-card-btn');
const cModal = document.getElementById('card-modal');

document.getElementById('close-transaction').onclick = () => tModal.classList.add('hidden');
document.getElementById('close-card').onclick = () => cModal.classList.add('hidden');

tBtn.onclick = () => tModal.classList.remove('hidden');


document.getElementById('transaction-type').onchange = (e) => {
  document.getElementById('income-form').classList.toggle('hidden', e.target.value !== 'income');
  document.getElementById('expense-form').classList.toggle('hidden', e.target.value !== 'expense');
};

// const addCardBtn = document.getElementById("add-card-btn");

// addCardBtn?.addEventListener("click", () => {
//   window.location.href = "Card.php";
// });


new Chart(document.getElementById('myChart'), {
  type: 'bar',
  data: {
    labels: ['Income', 'Expenses', 'Net'],
    datasets: [{
data: [<?php echo $total_income; ?>, <?php echo $total_expences; ?>, <?php echo $net_profit; ?>],
      backgroundColor: ['#22c55e', '#ef4444', '#3b82f6']
    }]
  }
});

const sendMoneyBtn = document.getElementById("send-money-btn");
const sendMoneyModal = document.getElementById("send-money-modal");
const closeSendMoney = document.getElementById("close-send-money");

const sendType = document.getElementById("send-type");
const sendEmail = document.getElementById("send-email");
const sendId = document.getElementById("send-id");

// Open modal
sendMoneyBtn?.addEventListener("click", () => {
  sendMoneyModal.classList.remove("hidden");
});

// Close modal
closeSendMoney?.addEventListener("click", () => {
  sendMoneyModal.classList.add("hidden");
});

// Close when clicking background
sendMoneyModal?.addEventListener("click", e => {
  if (e.target === sendMoneyModal) {
    sendMoneyModal.classList.add("hidden");
  }
});

// Switch between Email / ID
sendType?.addEventListener("change", () => {
  if (sendType.value === "email") {
    sendEmail.classList.remove("hidden");
    sendId.classList.add("hidden");
    sendEmail.required = true;
    sendId.required = false;
  } else {
    sendId.classList.remove("hidden");
    sendEmail.classList.add("hidden");
    sendId.required = true;
    sendEmail.required = false;
  }
});


const limitBtn = document.getElementById('add-limit-btn');
const limitModal = document.getElementById('limit-modal');
const closeLimit = document.getElementById('close-limit');

limitBtn?.addEventListener('click', () => limitModal.classList.remove('hidden'));
closeLimit?.addEventListener('click', () => limitModal.classList.add('hidden'));

// Close when clicking background
limitModal?.addEventListener('click', e => {
  if (e.target === limitModal) {
    limitModal.classList.add('hidden');
  }
});


</script>


<script type="text/javascript" src="script.js" defer></script>
</body>
</html>
