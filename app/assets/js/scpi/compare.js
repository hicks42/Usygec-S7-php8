const compareSlots = document.querySelectorAll(".compare-card");
const produitBtns = document.querySelectorAll(".select-produit");
const launchCompareBtn = document.querySelector(".compareBtn");
const razBtn = document.querySelector(".razBtn");

//popup
const comparePopup = document.getElementById("compare-popup");
const closeCompareBtn = document.querySelector(".close-compare");

let compareCart = [];

// Event listeners #############################################################

produitBtns.forEach((button) => {
  button.addEventListener("click", (e) => {
    const produitObj = makeObject(e);
    addToCompareCart(produitObj);
    openComparePopup(compareCart);
  });
});

if (launchCompareBtn) {
  launchCompareBtn.addEventListener("click", (e) => {
    const produitIds = [];
    compareCart.forEach((produitObj) => {
      produitIds.push(produitObj.id);
    });
    window.location.href = `/scpi/comparator/${produitIds}`;
  });
}

if (closeCompareBtn) {
  closeCompareBtn.addEventListener("click", closeComparePopup);
}

if (razBtn) {
  razBtn.addEventListener("click", clearCompare);
}

// Functions ###################################################################

function makeCompareCard(produitObj, compareSlot) {
  const imgLink =
    "<a href=\" {{ path('produit_show', {slug: produit.slug}) }} \"><img src=\"{{ (produit.imageName ? vich_uploader_asset(produit) : asset('build/images/placeholder.jpg')) | imagine_filter('square_thumbnail_medium') }}\" alt=\"{{ produit.name }}\"/></a>";

  // const compareImg = document.createElement("div");
  // compareImg.classList.add("compare-image");
  // compareImg.innerHTML = imgLink;

  const preview = document.createElement("div");
  preview.classList.add("compare-info");
  const name = document.createElement("h6");
  name.innerText = produitObj.name;

  const ul = document.createElement("div");
  ul.classList.add("info-container");
  let map = new Map();
  map.set("id", "N°");
  map.set("name", "Nom");
  map.set("SocGest", "Gérer par");
  map.set("categorie", "Catégorie");
  map.set("capital", "Type de capital");
  map.set("capitalisation", "Capitalisation");

  let produitObjindex = 0;
  for (const [key, value] of Object.entries(produitObj)) {
    if (produitObjindex >= 3) {
      let li = document.createElement("div");
      li.innerHTML = `${map.get(key)} : <strong> ${value}</strong>`;
      if (key === "capitalisation") {
        li.append(" M€");
      }
      ul.appendChild(li);
    }
    produitObjindex++;
  }

  preview.appendChild(name);
  preview.appendChild(ul);
  compareSlot.appendChild(preview);
}

function addToCompareCart(produitObj) {
  const id = produitObj.id;
  let size = compareCart.length;
  if (!inArray(id, compareCart)) {
    if (size > 2) {
      compareCart.shift();
    }
    compareCart.push(produitObj);
  }
  return compareCart;
}

function displayCompareCart(compareCart) {
  compareSlots.forEach((slot) => (slot.innerHTML = ""));
  compareCart.forEach((produitObj, index) => {
    makeCompareCard(produitObj, compareSlots[index]);
  });
}

function clearCompare() {
  if (compareCart.length <= 1) {
    closeComparePopup();
  }
  compareCart.pop();
  displayCompareCart(compareCart);
}

function openComparePopup(compareCart) {
  comparePopup.classList.remove("-translate-y-64");
  comparePopup.classList.remove("opacity-0");
  comparePopup.classList.add("translate-y-0");
  comparePopup.classList.add("opacity-100");

  displayCompareCart(compareCart);
}

function closeComparePopup() {
  comparePopup.classList.add("-translate-y-64");
  comparePopup.classList.add("opacity-0");
  comparePopup.classList.remove("translate-y-0");
  comparePopup.classList.remove("opacity-100");
}

function inArray(id, array) {
  const length = array.length;
  for (let i = 0; i < length; i++) {
    if (array[i].id == id) return true;
  }
  return false;
}

function makeObject(event) {
  const button = event.target.closest('.select-produit');
  const protoObj = button.getAttribute("data-produit-obj");
  const produitObj = JSON.parse(protoObj);
  return produitObj;
}

// Modal functions for text ellipsis ###########################################

window.openTextModal = function(fieldName, fieldLabel) {
  const modal = document.getElementById('textModal');
  const modalTitle = document.getElementById('modalTitle');
  const modalContent = document.getElementById('modalContent');

  if (!modal || !modalTitle || !modalContent) {
    console.error('Modal elements not found');
    return;
  }

  // Set modal title
  modalTitle.textContent = fieldLabel;

  // Get all full texts for this field
  const fullTexts = document.querySelectorAll(`[data-full-text^="${fieldName}-"]`);

  console.log('Opening modal for field:', fieldName, 'Found texts:', fullTexts.length);

  // Determine grid columns based on number of products
  const columnCount = fullTexts.length;
  modalContent.style.gridTemplateColumns = `repeat(${columnCount}, 1fr)`;

  // Clear previous content
  modalContent.innerHTML = '';

  // Add each product's text
  fullTexts.forEach((textDiv) => {
    const productName = textDiv.getAttribute('data-product-name');
    const fullText = textDiv.innerHTML;

    const column = document.createElement('div');
    column.className = 'border border-gray-300 rounded p-4';

    const header = document.createElement('h3');
    header.className = 'font-bold text-lg mb-3 text-red-600';
    header.textContent = productName;

    const content = document.createElement('div');
    content.className = 'text-justify';
    content.innerHTML = fullText;

    column.appendChild(header);
    column.appendChild(content);
    modalContent.appendChild(column);
  });

  // Show modal
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

window.closeTextModal = function() {
  const modal = document.getElementById('textModal');
  if (!modal) {
    console.error('Modal not found');
    return;
  }
  modal.classList.add('hidden');
  modal.classList.remove('flex');
}

// Check for truncated text and show/hide "Lire la suite" button
function checkTruncatedTexts() {
  // Find all line-clamped elements
  const clampedElements = document.querySelectorAll('[id^="text-"]');

  clampedElements.forEach((element) => {
    const id = element.id;
    const btnId = id.replace('text-', 'btn-');
    const button = document.getElementById(btnId);

    if (!button) return;

    // Check if text is truncated by comparing scroll height to client height
    // Add a small buffer (5px) to account for rounding errors
    if (element.scrollHeight > element.clientHeight + 5) {
      button.style.display = 'block';
    } else {
      button.style.display = 'none';
    }
  });
}

// Add event listeners to all "Lire la suite" buttons
function attachReadMoreListeners() {
  const buttons = document.querySelectorAll('[id^="btn-"]');

  buttons.forEach((button) => {
    button.addEventListener('click', function() {
      const fieldName = this.getAttribute('data-field');
      const fieldLabel = this.getAttribute('data-label');
      openTextModal(fieldName, fieldLabel);
    });
  });
}

// Run check after DOM is loaded and after a short delay to ensure styles are applied
document.addEventListener('DOMContentLoaded', function() {
  // Attach event listeners
  attachReadMoreListeners();

  // Initial check
  checkTruncatedTexts();

  // Check again after a short delay to ensure all styles are loaded
  setTimeout(checkTruncatedTexts, 100);

  // Check again after images and fonts are loaded
  window.addEventListener('load', checkTruncatedTexts);
});
