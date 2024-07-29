// Variables
import { initializeFlatpickr } from "./flatpickr";

const container = document.querySelector(".activity-container");
const activityList = document.querySelector(".activity-list");

////////////////// Add New Activity bloc //////////////////////////////////
const addActivityToCollection = (e) => {
  const collectionHolder = document.querySelector(
    "." + e.currentTarget.dataset.collectionHolderClass
  );
  const item = document.createElement("li");
  item.className = `new-activity-card rounded overflow-hidden p-2 mt-3`;
  item.innerHTML = collectionHolder.dataset.prototype.replace(
    /__name__/g,
    collectionHolder.dataset.index
  );
  collectionHolder.appendChild(item);
  collectionHolder.dataset.index++;
  newFormBtns(item);
  initializeFlatpickr(item.querySelectorAll(".flatpickr"));
  item.scrollIntoView({ behavior: "smooth" });
};

document.querySelectorAll(".add-activity-btn").forEach((btn) => {
  btn.addEventListener("click", addActivityToCollection);
});

// New Activity save and delete btns
const newFormBtns = (newItem) => {
  const removeFormButton = document.createElement("button");
  removeFormButton.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
  removeFormButton.className = `btn btn-danger fs-6 px-2 btn-sm`;

  const newSaveButton = document.createElement("button");
  newSaveButton.innerHTML = '<i class="fa-solid fa-file-arrow-down me-1"></i>';
  newSaveButton.className = `btn btn-warning fs-6 px-2 btn-sm`;
  newSaveButton.type = "submit";

  const newRow = newItem.querySelector(".activity-buttons");
  newRow.insertAdjacentElement("afterbegin", removeFormButton);
  newRow.insertAdjacentElement("beforeend", newSaveButton);

  newSaveButton.addEventListener("click", (e) => {
    e.preventDefault();
    const form = newItem.closest("form");
    if (form) {
      form.submit();
    }
  });

  removeFormButton.addEventListener("click", (e) => {
    e.preventDefault();
    newItem.remove();
  });
};

// document.querySelectorAll("new-activity-card").forEach((newItem) => {
//   newFormDeleteBtn(newItem);
// });

// Activity save btn
const formSaveBtn = (item) => {
  const saveFormButton = document.createElement("button");
  saveFormButton.innerHTML = '<i class="fa-solid fa-file-arrow-down me-1"></i>';
  saveFormButton.className = `btn btn-warning fs-6 px-2 btn-sm`;
  saveFormButton.type = "submit";

  // const newActiveInput = item.querySelector('input[name$="[dueDate]"]');
  // const buttonsRow = item.querySelector(".activity-buttons");
  item.insertAdjacentElement("beforeend", saveFormButton);

  saveFormButton.addEventListener("click", (e) => {
    e.preventDefault();
    const form = item.closest("form");
    if (form) {
      form.submit();
    }
  });
};

document.querySelectorAll(".activity-buttons").forEach((item) => {
  formSaveBtn(item);
});

////////////////// Delete Existing Activity bloc //////////////////////////////////
const addGroupDeleteLink = (item) => {
  const removeFormButton = document.createElement("button");
  removeFormButton.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
  removeFormButton.className = `btn btn-danger btn-sm`;

  item.append(removeFormButton);

  removeFormButton.addEventListener("click", (e) => {
    e.preventDefault();
    item.parentNode.remove();
  });
};

document.querySelectorAll("div.activity-buttons").forEach((group) => {
  addGroupDeleteLink(group);
});

////////////////// Filtering Activity bloc //////////////////////////////////
// Attachez un écouteur d'événement au bouton de filtrage
const filterButton = document.getElementById("filter-button");
filterButton.addEventListener("click", filterActivities);

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
    filterButton.textContent = "Cacher";
    filterButton.classList.remove("show-inactive");
  } else {
    filterButton.textContent = "Voir";
    filterButton.classList.add("show-inactive");
  }
}

////////////////// Ghosting inactiv bloc //////////////////////////////////
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

////// classe "inactive" au chargement de la page ////////////////////////
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
activitySearchForm.addEventListener("input", () => {
  searchActivities();
});

window.searchActivities = searchActivities;
