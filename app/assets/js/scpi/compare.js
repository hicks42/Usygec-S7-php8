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
    makeObject(e);
    addToCompareCart(produitObj);
    openComparePopup(compareCart);
  });
});

launchCompareBtn.addEventListener("click", (e) => {
  const produitIds = [];
  compareCart.forEach((produitObj) => {
    produitIds.push(produitObj.id);
  });
  window.location.href = `/comparator/${produitIds}`;
});

closeCompareBtn.addEventListener("click", closeComparePopup);
razBtn.addEventListener("click", clearCompare);

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
  comparePopup.classList.add("active");
  comparePopup.classList.add("active");

  displayCompareCart(compareCart);
}

function closeComparePopup() {
  comparePopup.classList.remove("active");
  comparePopup.classList.remove("active");
}

function inArray(id, array) {
  const length = array.length;
  for (let i = 0; i < length; i++) {
    if (array[i].id == id) return true;
  }
  return false;
}

function makeObject(event) {
  protoObj = event.target.getAttribute("datat-produit-obj");
  produitObj = JSON.parse(protoObj);
  return produitObj;
}
