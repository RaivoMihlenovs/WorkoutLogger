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
    modal.style.display = "none";
  };
});

function deleteExercise(id) {
  var liDocuments = document.getElementById(id);
  liDocuments.remove();

  var select = document.getElementsByName("selected_exercise_id");
  for (var i = 0; i < select.length; i++) {
    const currSelect = select[i];
    for (var j = 0; j < currSelect.childNodes.length; j++) {
      const currChild = currSelect.childNodes[j];
      if (currChild.nodeName == "OPTION") {
        if (currChild.value == id.toString()) {
          currChild.remove();
        }
      }
    }
  }
}
