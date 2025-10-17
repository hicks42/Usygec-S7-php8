// modal Module
const modalBtns = document.querySelectorAll(".modal-btn");
const formTitle = document.querySelector("#form-title");
const submitModalBtn = document.querySelector(".submit-modal");
const modalContainer = document.querySelector(".modal-container");
const modalInput = document.querySelector(".modal-container input");
const closeModaldBtns = document.querySelectorAll(".close-popup");

modalBtns.forEach((modalBtn) => {
  modalBtn.addEventListener("click", (e) => {
    e.preventDefault(); // Empêcher le comportement par défaut du lien
    openModal(e);
  });
});
closeModaldBtns.forEach((closeModaldBtn) => {
  closeModaldBtn.addEventListener("click", (e) => {
    e.preventDefault(); // Empêcher le comportement par défaut
    closeModal(e);
  });
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

// CSV Import Error Modal
function showCsvErrorModal(result) {
  const modal = document.getElementById("csv-error-modal");
  if (!modal) return;

  // Construire le contenu de la modal
  const errorsContainer = modal.querySelector(".errors-list");
  if (!errorsContainer) return;

  errorsContainer.innerHTML = "";

  // Afficher le résumé
  const summary = document.createElement("div");
  summary.className =
    "error-summary mb-4 p-4 bg-red-50 border border-red-200 rounded-lg";
  summary.innerHTML = `
    <h6 class="font-bold text-red-800">Résumé de l'import</h6>
    <ul class="text-sm text-red-700 space-y-1">
      <li>Lignes analysées : <strong>${result.totalLines}</strong></li>
      <li>Sociétés importées : <strong class="text-green-600">${
        result.count
      }</strong></li>
      ${
        result.skipped > 0
          ? `<li>Doublons ignorés : <strong class="text-orange-600">${result.skipped}</strong></li>`
          : ""
      }
      ${
        result.errors.length > 0
          ? `<li>Erreurs détectées : <strong class="text-red-600">${result.errors.length}</strong></li>`
          : ""
      }
    </ul>
  `;
  errorsContainer.appendChild(summary);

  // Afficher les erreurs détaillées
  if (result.errors && result.errors.length > 0) {
    const errorsSection = document.createElement("div");
    errorsSection.className = "errors-details mt-4";
    errorsSection.innerHTML =
      '<h4 class="font-bold text-gray-800 mb-3">Détails des erreurs</h4>';

    const errorsList = document.createElement("div");
    errorsList.className = "space-y-3 max-h-96 overflow-y-auto";

    result.errors.forEach((error, index) => {
      const errorItem = document.createElement("div");
      errorItem.className =
        "error-item p-3 bg-white border border-gray-200 rounded-lg shadow-sm";

      let iconClass = "text-red-500";
      let iconSvg = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>`;

      errorItem.innerHTML = `
        <div class="flex items-start gap-3">
          <div class="${iconClass} flex-shrink-0 mt-0.5">
            ${iconSvg}
          </div>
          <div class="flex-1">
            <div class="font-semibold text-gray-900">${error.message}</div>
            ${
              error.details
                ? `<div class="text-sm text-gray-600 mt-1">${error.details}</div>`
                : ""
            }
            ${
              error.solution
                ? `<div class="text-sm text-blue-600 mt-2"><strong>Solution :</strong> ${error.solution}</div>`
                : ""
            }
          </div>
        </div>
      `;
      errorsList.appendChild(errorItem);
    });

    errorsSection.appendChild(errorsList);
    errorsContainer.appendChild(errorsSection);
  }

  // Afficher les doublons si présents
  if (result.duplicates && result.duplicates.length > 0) {
    const duplicatesSection = document.createElement("div");
    duplicatesSection.className =
      "duplicates-section mt-4 p-4 bg-orange-50 border border-orange-200 rounded-lg";
    duplicatesSection.innerHTML = `
      <h4 class="font-bold text-orange-800 mb-2">Doublons ignorés (${
        result.duplicates.length
      })</h4>
      <div class="text-sm text-orange-700 max-h-32 overflow-y-auto">
        <ul class="space-y-1">
          ${result.duplicates
            .slice(0, 10)
            .map(
              (dup) => `
            <li>Ligne ${dup.line}: ${dup.company} (CP: ${dup.cp})</li>
          `
            )
            .join("")}
          ${
            result.duplicates.length > 10
              ? `<li class="font-semibold">... et ${
                  result.duplicates.length - 10
                } autre(s)</li>`
              : ""
          }
        </ul>
      </div>
    `;
    errorsContainer.appendChild(duplicatesSection);
  }

  // Afficher la modal
  modal.classList.add("active");
  const popup = modal.querySelector(".modal-popup");
  if (popup) {
    popup.classList.add("active");
  }
}

// Export pour utilisation globale
if (typeof window !== "undefined") {
  window.showCsvErrorModal = showCsvErrorModal;
}
