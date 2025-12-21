// ===============================
// ELEMENTS
// ===============================
const transactionBtn = document.getElementById("add-transaction-btn");
const transactionModal = document.getElementById("transaction-modal");
const closeTransaction = document.getElementById("close-transaction");

const typeSelect = document.getElementById("transaction-type");
const incomeForm = document.getElementById("income-form");
const expenseForm = document.getElementById("expense-form");

const logoutBtn = document.getElementById("logout-btn");
const logoutModal = document.getElementById("logout-modal");
const cancelLogoutBtn = document.getElementById("cancel-logout");
const logoutBg = document.getElementById("logout-bg");

const contInc = document.getElementById("cont_inc");
const contExp = document.getElementById("cont_exp");

// ===============================
// TRANSACTION MODAL
// ===============================
transactionBtn?.addEventListener("click", () => {
  transactionModal.classList.remove("hidden");
});

closeTransaction?.addEventListener("click", () => {
  transactionModal.classList.add("hidden");
});

// Switch between Income / Expense
typeSelect?.addEventListener("change", () => {
  incomeForm.classList.toggle("hidden", typeSelect.value !== "income");
  expenseForm.classList.toggle("hidden", typeSelect.value !== "expense");
});

// Close modal when clicking background
transactionModal?.addEventListener("click", (e) => {
  if (e.target === transactionModal) {
    transactionModal.classList.add("hidden");
  }
});

// ===============================
// LOGOUT MODAL
// ===============================
logoutBtn?.addEventListener("click", () => {
  logoutModal.classList.remove("hidden");
});

cancelLogoutBtn?.addEventListener("click", () => {
  logoutModal.classList.add("hidden");
});

logoutBg?.addEventListener("click", () => {
  logoutModal.classList.add("hidden");
});

document.querySelector("#logout-modal .cont")?.addEventListener("click", e => {
  e.stopPropagation();
});

// ===============================
// EDIT INCOME
// ===============================
document.querySelectorAll(".edit_btn_inc").forEach(btn => {
  btn.addEventListener("click", e => {
    const row = e.target.closest(".element");
    if (!row) return;

    const modal = document.createElement("div");
    modal.className = "fixed inset-0 bg-black/40 flex items-center justify-center z-50";

    modal.innerHTML = `
      <div class="bg-white p-6 rounded-xl w-96">
        <h2 class="text-xl font-bold mb-4">Edit Income</h2>
        <form action="Income.php" method="post">
          <input name="edit-Incomes" class="w-full border p-2 mb-2 rounded" placeholder="Amount">
          <input name="edit-descreption" class="w-full border p-2 mb-2 rounded" placeholder="Description">
          <input name="edit-date" type="date" class="w-full border p-2 mb-4 rounded">
          <input type="hidden" name="id" value="${row.dataset.id}">
          <button class="w-full bg-green-500 text-white py-2 rounded">Save</button>
        </form>
      </div>
    `;

    modal.addEventListener("click", () => modal.remove());
    modal.querySelector("div").addEventListener("click", e => e.stopPropagation());

    document.body.appendChild(modal);
  });
});

// ===============================
// EDIT EXPENSE
// ===============================
document.querySelectorAll(".edit_btn_exp").forEach(btn => {
  btn.addEventListener("click", e => {
    const row = e.target.closest(".Eelement");
    if (!row) return;

    const modal = document.createElement("div");
    modal.className = "fixed inset-0 bg-black/40 flex items-center justify-center z-50";

    modal.innerHTML = `
      <div class="bg-white p-6 rounded-xl w-96">
        <h2 class="text-xl font-bold mb-4">Edit Expense</h2>
        <form action="Expences.php" method="post">
          <input name="edit-Expenses" class="w-full border p-2 mb-2 rounded" placeholder="Amount">
          <input name="edit-Edescreption" class="w-full border p-2 mb-2 rounded" placeholder="Description">
          <input name="edit-Edate" type="date" class="w-full border p-2 mb-4 rounded">
          <input type="hidden" name="id" value="${row.dataset.id}">
          <button class="w-full bg-red-500 text-white py-2 rounded">Save</button>
        </form>
      </div>
    `;

    modal.addEventListener("click", () => modal.remove());
    modal.querySelector("div").addEventListener("click", e => e.stopPropagation());

    document.body.appendChild(modal);
  });
});

// ===============================
// DELETE INCOME
// ===============================
document.querySelectorAll(".delete_btn_inc").forEach(btn => {
  btn.addEventListener("click", e => {
    if (!confirm("Delete this income?")) return;

    const row = e.target.closest(".element");
    const form = document.createElement("form");
    form.method = "post";
    form.action = "Income.php";
    form.innerHTML = `<input type="hidden" name="Did" value="${row.dataset.id}">`;
    document.body.appendChild(form);
    form.submit();
  });
});

// ===============================
// DELETE EXPENSE
// ===============================
document.querySelectorAll(".delete_btn_exp").forEach(btn => {
  btn.addEventListener("click", e => {
    if (!confirm("Delete this expense?")) return;

    const row = e.target.closest(".Eelement");
    const form = document.createElement("form");
    form.method = "post";
    form.action = "Expences.php";
    form.innerHTML = `<input type="hidden" name="EDid" value="${row.dataset.id}">`;
    document.body.appendChild(form);
    form.submit();
  });
});


document.querySelectorAll('input[name="selected_card"]').forEach(radio => {
  radio.addEventListener('change', () => {
    document.getElementById('income-card-id').value = radio.value;
    document.getElementById('expence-card-id').value = radio.value;
  });
});


// Set default on page load
const checked = document.querySelector('input[name="selected_card"]:checked');
if (checked) {
  document.getElementById('income-card-id').value = checked.value;
  document.getElementById('expence-card-id').value = checked.value;
}
function selectCard(cardId) {
  document.getElementById('income-card-id').value = cardId;
  document.getElementById('expence-card-id').value = cardId;

  // optional: update URL
  window.history.replaceState(null, null, "?card_id=" + cardId);
}