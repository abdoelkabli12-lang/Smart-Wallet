const incomeBTN = document.getElementById("incomes-btn");
const expencesBTN = document.getElementById("expences-btn");
const incomeForm = document.getElementById("incomes");
const expencesForm = document.getElementById("expences");
const Blur = document.querySelectorAll(".bgblur");
const cont = document.querySelectorAll(".cont");
const editBtnInc = document.querySelectorAll(".edit_btn_inc");
const editBtnExp = document.querySelectorAll(".edit_btn_exp");
const deleteBtnInc = document.querySelectorAll(".delete_btn_inc");
const deleteBtnExp = document.querySelectorAll(".delete_btn_exp");
const contInc = document.getElementById("cont_inc");
const contExp = document.getElementById("cont_exp");
const User = document.querySelectorAll(".Usser")
const loginBg = document.getElementById("bg-login");
const signupBg = document.getElementById("bg-signup");
const loginForm = document.getElementById("login-form");
const signUp = document.querySelectorAll(".signup");
const user = document.getElementById("user");

editBtnInc.forEach(btn => {
  btn.addEventListener("click", (e) => {
    let row = e.target.closest(".element");
    let div = document.createElement("div");
    div.classList.add("w-full");

    let editForm = `
   <div class="bgblur fixed backdrop-blur-sm bg-white/15 flex h-screen w-[100%] justify-center items-center ">
      <div class="cont w-96 mx-auto bg-white rounded shadow">

        <div class="mx-16 py-4 px-8 text-black text-xl font-bold border-b border-grey-500 flex justify-center">Add Income
        </div>

        <form id="edit-inc-form" action="Income.php" method="post">
          <div class="py-4 px-8">

            <div class="mb-4">
              <label for="edit-Incomes" class="block text-grey-darker text-sm font-bold mb-2">Edit Income:</label>
              <input class=" border rounded w-full py-2 px-3 text-grey-darker" type="text"
                name="edit-Incomes" id="edit-Incomes" value="" placeholder="Enter Your Income amount">
            </div>


            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2">Edit Description: </label>
              <input class=" border rounded w-full py-2 px-3 text-grey-darker" type="text"
                name="edit-descreption" id="edit-descreption" value="" placeholder="Enter a descreption">
            </div>

            <input value = '${row.dataset.id}' name = 'id' type = 'hidden'>

            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2">Edit Date: </label>
              <input class=" border rounded w-full py-2 px-3 text-grey-darker" type="date"
                name="edit-date" id="edit-date" value="" placeholder="Enter Your date">
              <p id=error_creater_id></p>
            </div>



            <div class="mb-4">
              <button
                class="mb-2 mx-16 rounded-full py-3 px-24 bg-gradient-to-r from-uncommon to-rare ">
                Save
              </button>
            </div>
          </div>
        </form>
    </div>
    `;

    div.innerHTML = editForm;
    contInc.appendChild(div);
  });
});

editBtnExp.forEach(btn => {
  btn.addEventListener("click", (e) => {
    let row = e.target.closest(".Eelement");
    let div = document.createElement("div");
    div.classList.add("w-full");

    let editForm = `
   <div class="bgblur fixed backdrop-blur-sm bg-white/15 flex h-screen w-[100%] justify-center items-center ">
      <div class="cont w-96 mx-auto bg-white rounded shadow">

        <div class="mx-16 py-4 px-8 text-black text-xl font-bold border-b border-grey-500 flex justify-center">Add Income
        </div>

        <form id="edit-inc-form" action="Expences.php" method="post">
          <div class="py-4 px-8">

            <div class="mb-4">
              <label for="edit-Expenses" class="block text-grey-darker text-sm font-bold mb-2">Edit Expense:</label>
              <input class=" border rounded w-full py-2 px-3 text-grey-darker" type="text"
                name="edit-Expenses" id="edit-Expenses" value="" placeholder="Enter Your Expense amount">
            </div>


            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2">Edit Description: </label>
              <input class=" border rounded w-full py-2 px-3 text-grey-darker" type="text"
                name="edit-Edescreption" id="edit-Edescreption" value="" placeholder="Enter a descreption">
            </div>

            <input value = '${row.dataset.id}' name = 'id' type = 'hidden'>

            <div class="mb-4">
              <label class="block text-grey-darker text-sm font-bold mb-2">Edit Date: </label>
              <input class=" border rounded w-full py-2 px-3 text-grey-darker" type="date"
                name="edit-Edate" id="edit-Edate" value="" placeholder="Enter Your date">
              <p id=error_creater_id></p>
            </div>



            <div class="mb-4">
              <button
                class="mb-2 mx-16 rounded-full py-3 px-24 bg-gradient-to-r from-uncommon to-rare ">
                Save
              </button>
            </div>
          </div>
        </form>
    </div>
    `;

    div.innerHTML = editForm;
    contExp.appendChild(div);
  });
});
incomeBTN.addEventListener("click", () => {
  incomeForm.classList.remove("hidden");
})

expencesBTN.addEventListener("click", () => {
  expencesForm.classList.remove("hidden");
})


Blur.forEach(blur => {
  blur.addEventListener("click", () => {
    expencesForm.classList.add("hidden");
    incomeForm.classList.add("hidden");
  })
})
cont.forEach(cont => {
  cont.addEventListener("click", (e) => {
    e.stopPropagation();
  })
})


deleteBtnInc.forEach(btn => {
  btn.addEventListener("click", (e) => {
    let div = document.createElement("div");
    let row = e.target.closest(".element");
    let deleteForm = `
    <form id="delete-inc-form" action="Income.php" method="post">
    <input value = '${row.dataset.id}' name = 'Did' type = 'hidden'>
    </form>
    `;
div.innerHTML = deleteForm;
contInc.appendChild(div);
    document.getElementById("delete-inc-form").submit();
  })
})


deleteBtnExp.forEach(btn => {
  btn.addEventListener("click", (e) => {
    let div = document.createElement("div");
    let row = e.target.closest(".Eelement");
    let deleteForm = `
    <form id="delete-exp-form" action="Expences.php" method="post">
    <input value = '${row.dataset.id}' name = 'EDid' type = 'hidden'>
    </form>
    `;
div.innerHTML = deleteForm;
contExp.appendChild(div);
    document.getElementById("delete-exp-form").submit();
  })
})


signUp.forEach(btn => {
  btn.addEventListener("click", (e) => {
    loginBg.classList.add("hidden");
  signupBg.classList.add("hidden");
})
})


user.addEventListener("click", () => {
  loginBg.classList.remove("hidden");
})







