let isAddActivityOn = false;
document.addEventListener("DOMContentLoaded", function () {
  ////////////////// Add New Activity bloc //////////////////////////////////
  const addActivityToCollection = (e) => {
    if (isAddActivityOn) return; // Exit if the function is already in progress
    isAddActivityOn = true; // Set the lock

    const collectionHolder = document.querySelector(
      "." + e.currentTarget.dataset.collectionHolderClass
    );
    const item = document.createElement("li");
    item.className = `card bg-indigo-100 overflow-hidden p-2 mt-3`;
    item.innerHTML = collectionHolder.dataset.prototype.replace(
      /__name__/g,
      collectionHolder.dataset.index
    );
    collectionHolder.appendChild(item);
    collectionHolder.dataset.index++;
    formBtns(item);
    window.initializeFlatpickr(item.querySelectorAll(".flatpickr"));
    // Initialiser l'auto-resize pour les nouveaux textareas
    if (window.initAutoResizeTextareas) {
      window.initAutoResizeTextareas();
    }
    item.scrollIntoView({ behavior: "smooth" });
  };

  const addActivity = document.querySelector(".add-activity-btn");
  if (addActivity) {
    addActivity.addEventListener("click", addActivityToCollection);
  }

  //////////// Activity save and delete btns //////////////////////
  const formBtns = (item) => {
    const trashButton = document.createElement("button");
    trashButton.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
    trashButton.className = `btn btn-danger p-2 btn-sm mx-1`;

    const saveButton = document.createElement("button");
    saveButton.innerHTML = '<i class="fa-solid fa-file-arrow-down"></i>';
    saveButton.className = `btn btn-warning fs-4 p-2 btn-sm`;
    saveButton.type = "submit";

    const btnsRow = item.querySelector(".activity-buttons");
    if (btnsRow) {
      btnsRow.insertAdjacentElement("afterbegin", trashButton);
      btnsRow.insertAdjacentElement("beforeend", saveButton);

      trashButton.addEventListener("click", (e) => {
        e.preventDefault();
        item.remove();
      });

      saveButton.addEventListener("click", (e) => {
        e.preventDefault();
        saveSituation(item);
      });
    } else {
      // Si pas de btnsRow, créer une div pour les boutons
      const btnsContainer = document.createElement("div");
      btnsContainer.className = "activity-buttons flex justify-around mt-2";
      btnsContainer.appendChild(trashButton);
      btnsContainer.appendChild(saveButton);

      // Chercher le conteneur parent pour ajouter les boutons
      const dateContainer = item.querySelector(".flex.flex-col.md\\:flex-row");
      if (dateContainer) {
        dateContainer.parentElement.appendChild(btnsContainer);
      }

      trashButton.addEventListener("click", (e) => {
        e.preventDefault();
        item.remove();
      });

      saveButton.addEventListener("click", (e) => {
        e.preventDefault();
        saveSituation(item);
      });
    }
  };

  document.querySelectorAll(".activity-card").forEach((item) => {
    formBtns(item);
  });

  function saveSituation(item) {
    const form = item.closest("form");
    if (form) {
      if (form.checkValidity()) {
        form.submit();
        isAddActivityOn = false;
      } else {
        form.reportValidity();
      }
    }
  }

  ////////////////// Filtering Activity bloc //////////////////////////////////
  // Attachez un écouteur d'événement au bouton de filtrage
  const filterButton = document.getElementById("filter-button");
  if (filterButton) {
    filterButton.addEventListener("click", filterActivities);
  }

  // Fonction de filtrage des activités
  function filterActivities() {
    const activities = document.querySelectorAll(".activity-card");
    const isShowInactive = filterButton.classList.contains("show-inactive");

    activities.forEach((activity) => {
      const isActiveInput = activity.querySelector('input[name$="[isActive]"]');
      const isInactive = isActiveInput && !isActiveInput.checked;

      if (isShowInactive && isInactive) {
        activity.style.display = "block";
      } else if (!isShowInactive && isInactive) {
        activity.style.display = "none";
      } else {
        activity.style.display = "block";
      }
    });

    if (isShowInactive) {
      filterButton.innerHTML = '<i class="fa-solid fa-filter"></i> Cacher';
      filterButton.classList.remove("show-inactive");
    } else {
      filterButton.innerHTML = '<i class="fa-solid fa-filter"></i> Voir';
      filterButton.classList.add("show-inactive");
    }
  }

  ////////////////// Ghosting inactive bloc //////////////////////////////////
  function handleIsActiveChange(event) {
    const isActiveInput = event.target;
    const activityCard = isActiveInput.closest(".activity-card");

    if (!isActiveInput.checked) {
      activityCard.classList.add("inactive");
    } else {
      activityCard.classList.remove("inactive");
    }
  }

  // Attach event listeners to each isActive input
  const isActiveInputs = document.querySelectorAll('input[name$="[isActive]"]');
  isActiveInputs.forEach((isActiveInput) => {
    isActiveInput.addEventListener("change", handleIsActiveChange);
  });

  ////// classe css "inactive" au chargement de la page ////////////////////////
  window.addEventListener("DOMContentLoaded", () => {
    const activities = document.querySelectorAll(".activity-card");

    activities.forEach((activity) => {
      const isActiveInput = activity.querySelector('input[name$="[isActive]"]');
      const isInactive = isActiveInput && !isActiveInput.checked;

      if (isInactive) {
        activity.classList.add("inactive");
      }
    });
  });

  ////////////////////// recherche ////////////////////////
  function searchActivities() {
    const searchInput = document.getElementById("search-input");
    const searchTerm = searchInput.value.toLowerCase();

    const activities = document.querySelectorAll(".activity-card");
    activities.forEach((activity) => {
      const descriptionElement = activity.querySelector(
        'textarea[name$="[description]"]'
      );
      const nameElement = activity.querySelector('input[name$="[name]"]');

      if (descriptionElement && descriptionElement.textContent) {
        const description = descriptionElement.textContent.toLowerCase();

        let name = "";
        if (nameElement) {
          name = nameElement.value.trim().toLowerCase();
        }

        if (description.includes(searchTerm) || name.includes(searchTerm)) {
          activity.style.display = "block";
        } else {
          activity.style.display = "none";
        }
      }
    });
  }

  const activitySearchForm = document.getElementById("search-input");
  if (activitySearchForm) {
    activitySearchForm.addEventListener("input", () => {
      searchActivities();
    });
  }

  window.searchActivities = searchActivities;
});
