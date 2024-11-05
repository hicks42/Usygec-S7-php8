// modal Module
const modalBtns = document.querySelectorAll(".modal-btn");
const formTitle = document.querySelector("#form-title");
const submitModalBtn = document.querySelector(".submit-modal");
const modalContainer = document.querySelector(".modal-container");
const modalInput = document.querySelector(".modal-container input");
const closeModaldBtns = document.querySelectorAll(".close-popup");

modalBtns.forEach((modalBtn) => {
  modalBtn.addEventListener("click", openModal);
});
closeModaldBtns.forEach((closeModaldBtn) => {
  closeModaldBtn.addEventListener("click", closeModal);
});

// Modal
function openModal(e) {
  const modalType = e.target.getAttribute("data-modal-type");

  handleModalType(modalType);
}

function handleModalType(modalType) {
  if (modalType !== null && modalType !== undefined) {
    switch (modalType) {
      case "email-csv":
        showModal(modalType);
        addStructureIdRow(e);
        break;
      default:
        showModal(modalType);
        break;
    }
  } else {
    console.error(`Pas de modal avec l/id : "${modalType}" !`);
  }
}

function addStructureIdRow(e) {
  const structureId = e.target.getAttribute("data-structureid");
  const existingInput = document.getElementById("modal_structure_id");
  const formFields = document.querySelector("#form-fields");

  if (existingInput) {
    existingInput.value = structureId;
  } else {
    const formRow = `<input type="hidden" id="email_csv_structure_id" name="email_csv[structureId]" value="${structureId}">`;
    formFields.insertAdjacentHTML("afterbegin", formRow);
  }
}

function showModal(modalType) {
  const targetedModal = document.getElementById(modalType);

  const popup = targetedModal.children[0];
  targetedModal.classList.add("active");
  popup.classList.add("active");
}

function closeModal(e) {
  const modals = document.querySelectorAll(".modal-container");
  modals.forEach((modal) => modal.classList.remove("active"));
}
