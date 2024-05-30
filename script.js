document.addEventListener("DOMContentLoaded", (event) => {
  const modal = document.getElementById("modal");
  const openModalBtn = document.getElementById("openModalBtn");
  const closeBtn = document.getElementsByClassName("close")[0];
  const signUpForm = document.getElementById("signUpForm");

  openModalBtn.onclick = function () {
    modal.style.display = "block";
  };

  closeBtn.onclick = function () {
    modal.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  signUpForm.onsubmit = function (event) {
    alert("Sign-up form submitted!");
    modal.style.display = "none";
  };
});
