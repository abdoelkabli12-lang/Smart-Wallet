<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Credit Card Form</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .perspective { perspective: 1200px; }
    .preserve-3d { transform-style: preserve-3d; }
    .backface-hidden { backface-visibility: hidden; }
    .rotate-y-180 { transform: rotateY(180deg); }
    .flip { transform: rotateY(180deg); }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

<!-- Hidden logos -->
<img id="visa-logo" src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" class="hidden">
<img id="mc-logo" src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" class="hidden">

<div class="w-full max-w-4xl grid md:grid-cols-2 gap-10">

  <!-- CARD -->
  <div class="perspective w-full h-56">
    <div id="card" class="relative w-full h-full transition-transform duration-700 preserve-3d">

      <!-- FRONT -->
      <div class="absolute inset-0 rounded-xl bg-gradient-to-br from-slate-800 to-slate-900 text-white p-6 shadow-xl backface-hidden">
        <div class="flex justify-between items-center">
          <span class="text-lg font-light">world</span>
          <div class="flex items-center gap-2">
            <span id="card-type-label" class="text-sm opacity-80">—</span>
            <img id="card-logo" class="w-10 hidden">
          </div>
        </div>

        <div class="mt-6 w-12 h-9 bg-gray-300 rounded"></div>

        <div id="card-number" class="mt-6 text-xl tracking-widest font-mono">
          #### #### #### ####
        </div>

        <div class="flex justify-between mt-6">
          <div>
            <p class="text-xs text-gray-400">Card Holder</p>
            <p id="card-name">FULL NAME</p>
          </div>
          <div>
            <p class="text-xs text-gray-400">Valid Thru</p>
            <p id="card-expiry">MM/YY</p>
          </div>
        </div>
      </div>

      <!-- BACK -->
      <div class="absolute inset-0 rounded-xl bg-slate-900 text-white p-6 shadow-xl rotate-y-180 backface-hidden">
        <div class="h-10 bg-black mt-2 rounded"></div>

        <div class="mt-6 flex justify-end">
          <div class="bg-gray-200 text-black px-3 py-1 rounded tracking-widest font-mono">
            <span id="card-cvv">•••</span>
          </div>
        </div>

        <p class="text-xs text-gray-400 mt-4 text-right">Authorized Signature</p>
      </div>

    </div>
  </div>

  <!-- FORM -->
  <form action="Card_add.php" method = "POST" class="bg-white p-8 rounded-xl shadow space-y-5">
    <div>
      <label class="text-sm font-medium">Card Number</label>
      <input id="input-number" maxlength="19" name = "card-number"
        class="w-full mt-1 px-4 py-2 border rounded focus:ring"
        placeholder="5412 7512 3412 3456">
    </div>

    <div>
      <label class="text-sm font-medium">Card Holder</label>
      <input id="input-name" name="card-name"
        class="w-full mt-1 px-4 py-2 border rounded focus:ring"
        placeholder="Lee M. Cardholder">
    </div>

    <div class="grid grid-cols-3 gap-4">
      <div class="col-span-2">
        <label class="text-sm font-medium">Expiry</label>
        <input id="input-expiry" maxlength="5" name="expire-date"
          class="w-full mt-1 px-4 py-2 border rounded focus:ring"
          placeholder="MM/YY">
      </div>

      <div>
        <label class="text-sm font-medium">CVV</label>
        <input id="input-cvv" maxlength="4" type="password" name = "cvv"
          class="w-full mt-1 px-4 py-2 border rounded focus:ring">
      </div>
    </div>

    <button class="w-full bg-slate-900 text-white py-3 rounded hover:bg-slate-800">
      Add Card
    </button>
  </form>

</div>

<script>
const numberInput = document.getElementById("input-number");
const nameInput = document.getElementById("input-name");
const expiryInput = document.getElementById("input-expiry");
const cvvInput = document.getElementById("input-cvv");

const card = document.getElementById("card");
const cardNumber = document.getElementById("card-number");
const cardName = document.getElementById("card-name");
const cardExpiry = document.getElementById("card-expiry");
const cardCvv = document.getElementById("card-cvv");
const cardTypeLabel = document.getElementById("card-type-label");
const cardLogo = document.getElementById("card-logo");

const visaLogo = document.getElementById("visa-logo").src;
const mcLogo = document.getElementById("mc-logo").src;

function detectCardType(num) {
  if (/^4/.test(num)) return "VISA";
  if (/^5[1-5]/.test(num)) return "MASTERCARD";
  return null;
}

// Card number
numberInput.addEventListener("input", e => {
  let raw = e.target.value.replace(/\D/g, "").slice(0, 16);
  e.target.value = raw.replace(/(.{4})/g, "$1 ").trim();
  cardNumber.textContent = e.target.value || "#### #### #### ####";

  const type = detectCardType(raw);
  if (type === "VISA") {
    cardTypeLabel.textContent = "VISA";
    cardLogo.src = visaLogo;
    cardLogo.classList.remove("hidden");
    document.innerHTML = `
    <form action="Card_add.php" method = "POST">
    <input type = "hidden" value = "Visa" name = "Visa">
    </form>`;
  } else if (type === "MASTERCARD") {
    cardTypeLabel.textContent = "MASTERCARD";
    cardLogo.src = mcLogo;
    cardLogo.classList.remove("hidden");
        document.innerHTML = `
    <form action="Card_add.php" method = "POST">
    <input type = "hidden" value = "MaserCard" name = "MasterCard">
    </form>`;
  } else {
    cardTypeLabel.textContent = "—";
    cardLogo.classList.add("hidden");
  }
});

// Name
nameInput.addEventListener("input", e => {
  cardName.textContent = e.target.value || "FULL NAME";
});

// Expiry
expiryInput.addEventListener("input", e => {
  let v = e.target.value.replace(/\D/g, "").slice(0, 4);
  if (v.length > 2) v = v.slice(0,2) + "/" + v.slice(2);
  e.target.value = v;
  cardExpiry.textContent = v || "MM/YY";
});

// CVV flip
cvvInput.addEventListener("focus", () => card.classList.add("flip"));
cvvInput.addEventListener("blur", () => card.classList.remove("flip"));
cvvInput.addEventListener("input", e => {
  cardCvv.textContent = e.target.value.replace(/\D/g, "").slice(0,4) || "•••";
});
</script>

</body>
</html>
