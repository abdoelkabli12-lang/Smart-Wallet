

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

$sql_inc = "SELECT * FROM income_tracker WHERE MONTH(Date) = MONTH(CURRENT_DATE) AND YEAR(Date) = YEAR(CURRENT_DATE)";
$result_inc = $sql_con->query($sql_inc);

$sql_sumInc = "SELECT SUM(Income) AS total_income FROM income_tracker";
$sumIncResult = $sql_con->query($sql_sumInc);
$total_income = ($sumIncResult && $row = $sumIncResult->fetch_assoc()) ? $row['total_income'] : 0;



$sql_exp = "SELECT * FROM expences_trakcer WHERE MONTH(Date) = MONTH(CURRENT_DATE) AND YEAR(Date) = YEAR(CURRENT_DATE)";
$result_exp = $sql_con->query($sql_exp);

$sql_sumExp = "SELECT SUM(Expences) AS total_expenses FROM expences_trakcer";
$sumExpResult = $sql_con->query($sql_sumExp);
$total_expenses = ($sumExpResult && $row = $sumExpResult->fetch_assoc()) ? $row['total_expenses'] : 0;
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
<button
  id="add-card-btn"
  class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
  ➕ Add Card
</button>

</div>

<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto mt-8 px-6">
  <div class="bg-white rounded-xl p-6 shadow">
    <p class="text-gray-500">Total Income</p>
    <h2 class="text-2xl font-bold text-green-600">$<?php echo $total_income; ?></h2>
  </div>

  <div class="bg-white rounded-xl p-6 shadow">
    <p class="text-gray-500">Total Expenses</p>
    <h2 class="text-2xl font-bold text-red-600">$<?php echo $total_expenses; ?></h2>
  </div>

  <div class="bg-white rounded-xl p-6 shadow">
    <p class="text-gray-500">Net Profit</p>
    <h2 class="text-2xl font-bold text-blue-600">
      $<?php echo $total_income - $total_expenses; ?>
    </h2>
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
    <?php if ($result_inc && $result_inc->num_rows > 0): ?>
      <?php while ($row_inc = $result_inc->fetch_assoc()): ?>
      <tr class="border-b">
        <td class="py-2 text-green-600 font-semibold">$<?php echo $row_inc['Income']; ?></td>
        <td class="py-2"><?php echo $row_inc['Date']; ?></td>
        <td class="py-2"><?php echo $row_inc['descr']; ?></td>
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
        <td class="py-2"><?php echo $row_exp['descr']; ?></td>
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
    </form>

    <!-- Expense -->
    <form id="expense-form" action="Expences.php" method="post" class="hidden">
      <input name="Expences" class="w-full border p-2 mb-2 rounded" placeholder="Amount">
      <input name="descreption_exp" class="w-full border p-2 mb-2 rounded" placeholder="Description">
      <input name="Date_exp1" type="date" class="w-full border p-2 mb-4 rounded">
      <button class="w-full bg-red-500 text-white py-2 rounded">Save Expense</button>
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

const addCardBtn = document.getElementById("add-card-btn");

addCardBtn?.addEventListener("click", () => {
  window.location.href = "Card.php";
});


new Chart(document.getElementById('myChart'), {
  type: 'bar',
  data: {
    labels: ['Income', 'Expenses', 'Net'],
    datasets: [{
      data: [<?php echo $total_income; ?>, <?php echo $total_expenses; ?>, <?php echo $total_income - $total_expenses; ?>],
      backgroundColor: ['#22c55e', '#ef4444', '#3b82f6']
    }]
  }
});
</script>


<script type="text/javascript" src="script.js" defer></script>
</body>
</html>
